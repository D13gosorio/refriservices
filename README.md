# RefriServices Aguadulce

[![Seguridad](https://github.com/D13gosorio/refriservices/actions/workflows/seguridad.yml/badge.svg)](https://github.com/D13gosorio/refriservices/actions/workflows/seguridad.yml)

Sitio web de RefriServices Aguadulce, empresa de refrigeración y aire
acondicionado. Incluye catálogo de servicios y repuestos, solicitudes de
servicio para clientes registrados, formulario de contacto y panel de
administración.

## Funcionalidades

**Público**

- Catálogo de servicios con precios
- Catálogo de repuestos con detalle, existencias y ordenamiento
- Página institucional y formulario de contacto

**Clientes registrados**

- Registro e inicio de sesión
- Solicitud de un servicio indicando cantidad y fecha deseada
- Seguimiento y cancelación de sus solicitudes

**Administración**

- Alta, edición y baja de servicios y repuestos
- Gestión de solicitudes: cambio de estado y asignación de fecha programada
- Bandeja de mensajes recibidos por el formulario de contacto

## Stack

- PHP 8, patrón MVC sin framework
- PostgreSQL alojado en Supabase, acceso mediante PDO
- Despliegue en Vercel con el runtime [`vercel-php`](https://github.com/vercel-community/php)

## Estructura

```
api/index.php       Punto de entrada en Vercel (serverless)
public/index.php    Punto de entrada en desarrollo local (Apache/XAMPP)
public/assets/      CSS, JS, imágenes y video
app/controllers/    Controladores
app/models/         Acceso a datos (PDO)
app/views/          Vistas
app/core/           Router, conexión a BD, sesiones y utilidades de seguridad
config.php          Configuración y arranque
db/seguridad.sql    Endurecimiento de la base de datos
```

Los dos puntos de entrada comparten `Router` y controladores, así que no hay
lógica duplicada entre local y producción.

## Requisitos

- PHP 8.0 o superior con las extensiones `pdo_pgsql` y `session`
  (`mbstring` es recomendable; si falta, se usa un sustituto)
- PostgreSQL 9.5 o superior; el proyecto se ejecuta sobre Supabase
- Cuenta de Vercel y de Supabase para el despliegue

## Configuración

Todos los parámetros se leen de variables de entorno. No hay credenciales en
el código: `.env*`, `.vercel/` y `hash.php` están en `.gitignore`, y en Vercel
se definen en Settings → Environment Variables.

| Variable       | Requerida | Descripción                                                        |
|----------------|-----------|--------------------------------------------------------------------|
| `DB_HOST`      | Sí        | Host de PostgreSQL                                                 |
| `DB_PORT`      | Sí        | Puerto; `6543` con el pooler de Supabase en modo transacción       |
| `DB_NAME`      | Sí        | Nombre de la base de datos (`postgres` en Supabase)                |
| `DB_USER`      | Sí        | Usuario de la base de datos                                        |
| `DB_PASS`      | Sí        | Contraseña                                                         |
| `DB_SSLMODE`   | Sí        | `require`                                                          |
| `BASE_URL`     | Sí        | Vacía en Vercel. En local, la URL raíz: `http://localhost:8000`    |
| `APP_ORIGENES` | No        | Orígenes autorizados para enviar formularios, separados por comas. Si se omite se acepta solo el origen de la petición |
| `APP_DEBUG`    | No        | `1` muestra los errores en pantalla. Solo para uso local           |

> En Vercel hay que conectar a Supabase por el *connection pooler* (Supavisor,
> modo transacción, puerto `6543`): Vercel solo tiene IPv4 y la conexión
> directa de Supabase es IPv6. El usuario del pooler tiene el formato
> `usuario.referencia_proyecto`.

## Desarrollo local

```bash
cd public
php -S localhost:8000
```

Con `BASE_URL=http://localhost:8000` y las variables de conexión definidas en
el entorno. Con Apache o XAMPP, el *document root* debe ser `public/`.

## Base de datos

El esquema vive en Supabase y consta de estas tablas:

| Tabla               | Contenido                                                  |
|---------------------|------------------------------------------------------------|
| `usuarios`          | Cuentas de clientes y administradores                      |
| `servicios`         | Catálogo de servicios                                      |
| `repuestos`         | Catálogo de repuestos                                      |
| `solicitudes`       | Solicitudes de servicio y su estado                        |
| `mensajes_contacto` | Envíos del formulario de contacto                          |
| `sesiones`          | Sesiones PHP; en Vercel no hay disco persistente           |
| `intentos_login`    | Contador para los límites de login, registro y contacto    |

Tras crear el esquema hay que ejecutar `db/seguridad.sql`, que activa Row Level
Security y ajusta permisos e índices. El propio script incluye una
comprobación previa y explica cada paso.

Las credenciales de las cuentas de prueba no se documentan aquí porque el
repositorio es público. Se crean y se cambian directamente en la base de datos.

## Despliegue

`vercel.json` define el runtime de PHP y el enrutamiento: todo el tráfico pasa
por `api/index.php`, salvo `/assets/*`, que se sirve como estático.

1. Importar el repositorio en Vercel.
2. Definir las variables de entorno de la tabla anterior.
3. Desplegar.

## Seguridad

- **Credenciales**: solo por variables de entorno. *gitleaks* revisa cada push
  y cada pull request; el repaso del historial completo corre semanalmente y
  puede lanzarse desde Actions → Seguridad → Run workflow.
- **Base de datos**: Row Level Security activo en todas las tablas y permisos
  retirados a los roles `anon` y `authenticated`, para que la API REST de
  Supabase no exponga los datos. Conexión con `sslmode=require`.
- **Sesiones** (`app/core/Sesion.php`): almacenadas en PostgreSQL, cookie
  `HttpOnly`/`Secure`/`SameSite=Lax`, modo estricto de identificadores,
  renovación al iniciar sesión y caducidad por inactividad.
- **Formularios**: token CSRF por sesión (`app/core/Csrf.php`) y validación del
  origen de la petición (`app/core/Origen.php`).
- **Autenticación**: contraseñas con `password_hash()` y límites de intentos
  por IP y por cuenta en login, registro y contacto (`app/core/Limite.php`).
- **Autorización**: el rol se comprueba contra la base de datos en cada
  petición al panel, y cada solicitud se valida contra su propietario.
- **Entrada y salida**: consultas preparadas, escapado con
  `htmlspecialchars()`, columnas explícitas en los modelos, validación de
  formato y longitud en todos los campos, y subida de archivos desactivada.
- **Transporte**: redirección a HTTPS, HSTS y cabeceras de seguridad
  (CSP sin `unsafe-inline`, `nosniff`, `X-Frame-Options`, `Referrer-Policy`,
  `Permissions-Policy`) definidas en `vercel.json`.
- **Errores**: nunca se muestran al visitante; se registran con `error_log`.
