-- ============================================================================
--  RefriServices — Endurecimiento de la base de datos (Supabase / PostgreSQL)
--
--  Ejecutar en el SQL Editor de Supabase, de arriba a abajo.
--
--  Se puede volver a ejecutar sin romper nada, con una sola excepción: el
--  índice único de correos del PASO 2 falla si ya hay duplicados. Ahí mismo
--  está explicado cómo comprobarlo y qué hacer.
--
--  QUÉ RESUELVE
--  ------------
--  Un proyecto de Supabase no solo es una base de datos: además publica una
--  API REST (PostgREST) en https://<referencia>.supabase.co/rest/v1/ que
--  atiende a cualquiera que presente la clave `anon`. Esa clave está pensada
--  para ir en el navegador, o sea que hay que darla por conocida.
--
--  Lo único que separa esa API de los datos es Row Level Security. Con RLS
--  desactivada (que es como nacen las tablas creadas a mano), quien tenga la
--  clave `anon` puede leer la tabla de usuarios entera, incluidos los hashes
--  de contraseña, sin pasar en ningún momento por el PHP de esta aplicación.
--
--  Este script cierra esa puerta por dos vías independientes: activa RLS sin
--  políticas (nadie sujeto a RLS pasa) y además retira los permisos a los
--  roles de la API. La aplicación no se entera, porque se conecta por el
--  puerto de Postgres con el rol dueño de las tablas, que no está sujeto a RLS.
-- ============================================================================


-- ----------------------------------------------------------------------------
-- PASO 0 — COMPROBACIÓN PREVIA (importante, no te la saltes)
-- ----------------------------------------------------------------------------
-- Activar RLS SÍ rompería la aplicación si el usuario configurado en DB_USER
-- no fuera el dueño de las tablas ni tuviera BYPASSRLS.
--
-- Ejecuta primero esto y comprueba el resultado:

SELECT
    current_user                                   AS usuario_conectado,
    (SELECT rolsuper   FROM pg_roles WHERE rolname = current_user) AS es_superusuario,
    (SELECT rolbypassrls FROM pg_roles WHERE rolname = current_user) AS ignora_rls;

SELECT tablename, tableowner
FROM pg_tables
WHERE schemaname = 'public'
ORDER BY tablename;

-- Sigue adelante solo si el usuario de DB_USER aparece como `tableowner` de
-- las tablas, o si `es_superusuario` / `ignora_rls` es true. Si no es así,
-- primero pásale la propiedad:
--
--     ALTER TABLE public.usuarios OWNER TO <usuario_de_la_app>;
--     -- ...y lo mismo con el resto de tablas.


-- ----------------------------------------------------------------------------
-- PASO 1 — Tabla del limitador de intentos
-- ----------------------------------------------------------------------------
-- La usan LoginThrottle (fuerza bruta contra el login) y Limite (registros y
-- formulario de contacto). Se crea aquí por si aún no existe.
--
-- `identidad` no guarda la IP ni el correo, sino su hash SHA-256: son siempre
-- 64 caracteres y la tabla no acaba siendo un registro de datos personales.

CREATE TABLE IF NOT EXISTS public.intentos_login (
    id         BIGSERIAL   PRIMARY KEY,
    identidad  VARCHAR(64) NOT NULL,
    creado_en  TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

-- Si la tabla ya existía (antes guardaba el texto "ip|correo" en claro), se
-- descartan las filas viejas —con el formato nuevo ya no casan con nada— y se
-- ajusta el tipo de la columna.
DELETE FROM public.intentos_login WHERE LENGTH(identidad) <> 64;
ALTER TABLE public.intentos_login
    ALTER COLUMN identidad TYPE VARCHAR(64);

-- Cada intento de login consulta esta tabla: sin índice, el conteo obliga a
-- recorrerla entera y el propio limitador acaba siendo el cuello de botella.
CREATE INDEX IF NOT EXISTS idx_intentos_login_identidad_fecha
    ON public.intentos_login (identidad, creado_en DESC);


-- ----------------------------------------------------------------------------
-- PASO 2 — Índices que evitan recorridos completos en las tablas consultadas
-- ----------------------------------------------------------------------------
-- No es "seguridad" en sentido estricto, pero una consulta que recorre toda la
-- tabla es lo que convierte unas cuantas peticiones en una caída del servicio.

CREATE INDEX IF NOT EXISTS idx_sesiones_actualizado
    ON public.sesiones (actualizado);

CREATE INDEX IF NOT EXISTS idx_solicitudes_usuario
    ON public.solicitudes (id_usuario);

-- Este es el índice que usa el login, que busca con LOWER(email). Además, al
-- ser único, impide que se creen dos cuentas para el mismo correo escrito con
-- distintas mayúsculas.
--
-- OJO: es el único paso del script que puede fallar, y falla si ya existen
-- correos duplicados. Comprueba antes que esta consulta no devuelva nada:
--
--     SELECT LOWER(email), COUNT(*)
--     FROM public.usuarios
--     GROUP BY LOWER(email)
--     HAVING COUNT(*) > 1;
--
-- Si devuelve filas, decide con cuál te quedas y borra el resto antes de
-- seguir. Si prefieres dejarlo para después, quita la palabra UNIQUE: el
-- índice seguirá acelerando el login, solo que sin impedir duplicados.
CREATE UNIQUE INDEX IF NOT EXISTS idx_usuarios_email
    ON public.usuarios (LOWER(email));


-- ----------------------------------------------------------------------------
-- PASO 3 — Activar Row Level Security en todas las tablas
-- ----------------------------------------------------------------------------
-- Sin ninguna política asociada, RLS deniega todo por defecto. Eso es
-- exactamente lo que se busca: aquí quien decide qué puede ver cada cliente es
-- el PHP (sesión + comprobación de propiedad), no la base de datos, así que a
-- través de la API REST no debe pasar absolutamente nadie.

ALTER TABLE public.usuarios           ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.servicios          ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.repuestos          ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.solicitudes        ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.mensajes_contacto  ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.sesiones           ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.intentos_login     ENABLE ROW LEVEL SECURITY;


-- ----------------------------------------------------------------------------
-- PASO 4 — Retirar los permisos de los roles de la API REST
-- ----------------------------------------------------------------------------
-- Segunda barrera, independiente de la anterior: aunque algún día se añadiera
-- una política permisiva por error, estos roles seguirían sin poder tocar nada.
--
--   anon           = peticiones con la clave pública (la que va en el navegador)
--   authenticated  = usuarios de Supabase Auth, que esta aplicación no usa

REVOKE ALL ON ALL TABLES    IN SCHEMA public FROM anon, authenticated;
REVOKE ALL ON ALL SEQUENCES IN SCHEMA public FROM anon, authenticated;
REVOKE ALL ON ALL FUNCTIONS IN SCHEMA public FROM anon, authenticated;
REVOKE USAGE ON SCHEMA public FROM anon, authenticated;

-- Y que las tablas que se creen a partir de ahora nazcan igual de cerradas,
-- sin depender de acordarse de repetir el REVOKE.
ALTER DEFAULT PRIVILEGES IN SCHEMA public
    REVOKE ALL ON TABLES FROM anon, authenticated;
ALTER DEFAULT PRIVILEGES IN SCHEMA public
    REVOKE ALL ON SEQUENCES FROM anon, authenticated;


-- ----------------------------------------------------------------------------
-- PASO 5 — Comprobación final
-- ----------------------------------------------------------------------------
-- Las siete tablas deben salir con rls_activada = true.

SELECT tablename, rowsecurity AS rls_activada
FROM pg_tables
WHERE schemaname = 'public'
ORDER BY tablename;

-- Y esta consulta no debe devolver ninguna fila (ningún permiso suelto):

SELECT grantee, table_name, privilege_type
FROM information_schema.role_table_grants
WHERE table_schema = 'public'
  AND grantee IN ('anon', 'authenticated')
ORDER BY table_name;


-- ----------------------------------------------------------------------------
-- PASO 6 — A mano, desde el panel de Supabase
-- ----------------------------------------------------------------------------
--  1. Settings → Database → cambia la contraseña de la base de datos y
--     actualiza DB_PASS en Vercel. La anterior estuvo en un repositorio
--     público y hay que darla por comprometida.
--
--  2. Cambia las contraseñas de las cuentas de prueba, que también estuvieron
--     publicadas. Genera el hash con PHP:
--
--         php -r "echo password_hash('LA_NUEVA', PASSWORD_DEFAULT);"
--
--     y aplícalo:
--
--         UPDATE public.usuarios
--         SET password = '<hash generado>'
--         WHERE email = 'admin@refriservices.com';
--
--     No pongas nunca la contraseña en claro en esta consulta.
--
--  3. Settings → API → si no piensas usar la API REST, restringe el acceso
--     o rota las claves `anon` y `service_role`.
-- ============================================================================
