# RefriServices Aguadulce

Sitio web de RefriServices Aguadulce (servicios de refrigeración y aire
acondicionado): catálogo de servicios y repuestos, solicitudes de clientes,
formulario de contacto y panel de administración.

## Stack

- PHP 8 (MVC simple, sin framework)
- PostgreSQL (Supabase)
- Despliegue en Vercel usando el runtime [`vercel-php`](https://github.com/vercel-community/php)

## Estructura

```
api/index.php        Punto de entrada para Vercel (serverless)
public/index.php     Punto de entrada para desarrollo local (Apache/XAMPP)
public/assets/        CSS, JS, imágenes y video (estáticos)
app/controllers/      Controladores
app/models/           Acceso a datos (PDO)
app/views/            Vistas
app/core/              Router, conexión a BD y manejador de sesiones
config.php            Configuración vía variables de entorno
```

Ambos puntos de entrada (`api/index.php` y `public/index.php`) usan el mismo
`Router` y los mismos controladores — no hay lógica duplicada.

## Variables de entorno

| Variable     | Descripción                                              |
|--------------|-----------------------------------------------------------|
| `DB_HOST`    | Host de PostgreSQL (usar el *pooler* en Vercel, ver abajo) |
| `DB_PORT`    | Puerto (`6543` con el pooler en modo transacción)          |
| `DB_NAME`    | Nombre de la base de datos (`postgres` en Supabase)         |
| `DB_USER`    | Usuario de la base de datos                                |
| `DB_PASS`    | Contraseña                                                  |
| `DB_SSLMODE` | `require` (recomendado)                                     |
| `BASE_URL`   | Vacío en Vercel. En XAMPP local: `http://localhost/refriservices/public` |
| `APP_ORIGENES` | Opcional. Lista separada por comas de los orígenes desde los que se aceptan formularios, p. ej. `https://refriservices.com,https://www.refriservices.com`. Si se deja sin definir se acepta solo el origen de la propia petición |
| `APP_DEBUG`  | Opcional. `1` muestra los errores en pantalla. **Solo en local**, nunca en Vercel |

Ninguna de estas variables se guarda en el repositorio: `.env*` está en
`.gitignore` y en Vercel se configuran en Settings → Environment Variables.

En Vercel, Supabase solo es alcanzable por el *connection pooler* (Supavisor,
modo transacción, puerto `6543`) porque Vercel es IPv4-only y la conexión
directa de Supabase es IPv6. El usuario de conexión en el pooler tiene el
formato `usuario.referencia_proyecto`.

## Desarrollo local

Requiere PHP 8+ con las extensiones `pdo_pgsql` y `session`, y acceso a una
base de datos PostgreSQL (se puede usar el mismo proyecto de Supabase).

1. Configura las variables de entorno de la tabla anterior (por ejemplo, con
   `SetEnv` en la configuración de Apache/XAMPP, o exportándolas antes de
   levantar el servidor embebido de PHP).
2. Document root: `public/`.
3. Con el servidor embebido de PHP, desde la carpeta `public/`:
   ```
   php -S localhost:8000
   ```
   y define `BASE_URL=http://localhost:8000`.

## Base de datos

El esquema completo (tablas, relaciones y datos de prueba) vive en Supabase.
Incluye:

- `usuarios`, `servicios`, `repuestos`, `solicitudes`, `mensajes_contacto`
- `sesiones`: respaldo de las sesiones PHP en base de datos (necesario en
  Vercel, donde no hay filesystem persistente entre invocaciones)
- `intentos_login`: contador de intentos por ventana de tiempo, usado para
  limitar login, registro y envíos del formulario de contacto

Las credenciales de las cuentas de prueba no se publican aquí: este
repositorio es público y cualquiera podría entrar con ellas. Créalas o
cámbialas directamente en la base de datos.

Tras aplicar el esquema, ejecuta `db/seguridad.sql` (ver *Seguridad*).

## Despliegue en Vercel

El proyecto incluye `vercel.json` con el runtime PHP y el enrutamiento:
todo el tráfico (excepto `/assets/*`, servido como estático desde
`public/assets`) pasa por `api/index.php`.

1. Importa el repositorio en Vercel.
2. Configura las variables de entorno de la tabla anterior en el proyecto de
   Vercel (Settings → Environment Variables).
3. Despliega.

## Seguridad

Resumen de las medidas activas y de dónde vive cada una.

**Credenciales.** No hay ninguna en el código: todo sale de variables de
entorno (`config.php`), y `.env*`, `.vercel/` y `hash.php` están en
`.gitignore`. El workflow `.github/workflows/seguridad.yml` pasa *gitleaks*
en cada push y cada pull request, ahí solo sobre los commits de ese evento.
El repaso del historial completo es el que corre los lunes, y se puede lanzar
a mano desde Actions → Seguridad → Run workflow.

**Acceso a la base de datos.** `db/seguridad.sql` activa Row Level Security en
todas las tablas y retira los permisos a los roles `anon` y `authenticated`.
Sin eso, la API REST que Supabase publica junto a la base de datos deja leer
las tablas —incluidos los hashes de contraseña— sin pasar por la aplicación.
La conexión va siempre con `sslmode=require`.

**Sesiones** (`app/core/Sesion.php`). Se guardan en Postgres, no en disco.
Cookie `HttpOnly`, `Secure` y `SameSite=Lax`; `session.use_strict_mode`
activo (con `validateId()` en `DbSessionHandler`, que es lo que lo hace
efectivo); el id se renueva al iniciar sesión; caducan a los 30 minutos de
inactividad y a las 8 horas en todo caso. Cerrar sesión es un POST con token
CSRF y borra los datos, el registro en la base y la cookie.

**Peticiones que modifican datos.** Token CSRF por sesión (`app/core/Csrf.php`)
más comprobación de origen (`app/core/Origen.php`): se exige que `Origin` o
`Referer` coincidan con `APP_ORIGENES`, o con el propio dominio si esa variable
no está definida. No se envía `Access-Control-Allow-Origin` a nadie, así que
ninguna página ajena puede leer las respuestas.

**Autenticación y abuso.** Contraseñas con `password_hash()`. El login se
limita por IP+correo (5 intentos / 15 min) y por IP a secas (20 / 15 min, para
frenar el *password spraying*); el registro, a 5 cuentas por hora y conexión; y
el formulario de contacto, a 5 mensajes por hora. Todo en `app/core/Limite.php`.

**Autorización.** El rol de administrador se vuelve a leer de la base de datos
en cada petición al panel, no se da por bueno lo que quedó en la sesión. Las
solicitudes se comprueban por propietario, y una solicitud ajena responde 404
igual que una inexistente, para no revelar cuáles existen.

**Entrada y salida.** Todas las consultas son preparadas con parámetros
(`app/models/`), las vistas escapan con `htmlspecialchars()`, y los modelos
piden columnas explícitas en vez de `SELECT *` (el hash de contraseña solo se
lee en el login). Cada campo tiene validación de formato y tope de longitud.
Las subidas de archivos están desactivadas en `api/php.ini` porque la
aplicación no recibe ninguna.

**Transporte y cabeceras.** `config.php` redirige a HTTPS cualquier petición en
claro. `vercel.json` añade HSTS, una CSP sin `unsafe-inline`, `nosniff`,
`X-Frame-Options: DENY`, `Referrer-Policy` y `Permissions-Policy`.

**Errores.** Nunca se muestran al visitante salvo que se defina `APP_DEBUG=1`;
se registran con `error_log` (`config.php`, `api/php.ini`).
