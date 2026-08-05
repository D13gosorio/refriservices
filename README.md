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

Usuario administrador de prueba: `admin@refriservices.com` / `admin10`
Usuario cliente de prueba: `cliente@correo.com` / `cliente123`

## Despliegue en Vercel

El proyecto incluye `vercel.json` con el runtime PHP y el enrutamiento:
todo el tráfico (excepto `/assets/*`, servido como estático desde
`public/assets`) pasa por `api/index.php`.

1. Importa el repositorio en Vercel.
2. Configura las variables de entorno de la tabla anterior en el proyecto de
   Vercel (Settings → Environment Variables).
3. Despliega.
