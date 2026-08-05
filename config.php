<?php
// Ruta absoluta a la raíz del proyecto (útil para requires estables sin importar
// desde qué punto de entrada se ejecute: public/index.php en local o api/index.php en Vercel)
define("ROOT_PATH", __DIR__);

// URL base de la app.
// - En Vercel: se deja vacía (rutas relativas a la raíz del dominio).
// - En local (XAMPP): define la variable de entorno BASE_URL, por ejemplo
//   http://localhost/refriservices/public
define("BASE_URL", rtrim(getenv("BASE_URL") ?: "", "/"));

// Datos de conexión a la base de datos (PostgreSQL / Supabase).
// Todos se leen de variables de entorno para no exponer credenciales en el código.
define("DB_HOST", getenv("DB_HOST") ?: "127.0.0.1");
define("DB_PORT", getenv("DB_PORT") ?: "5432");
define("DB_NAME", getenv("DB_NAME") ?: "postgres");
define("DB_USER", getenv("DB_USER") ?: "postgres");
define("DB_PASS", getenv("DB_PASS") ?: "");
define("DB_SSLMODE", getenv("DB_SSLMODE") ?: "require");

// Conexión a BD y manejo de sesiones persistentes en la base de datos.
// Esto es obligatorio en entornos serverless (Vercel), donde no hay disco
// compartido entre invocaciones para guardar sesiones en archivos.
require_once ROOT_PATH . "/app/core/DB.php";
require_once ROOT_PATH . "/app/core/DbSessionHandler.php";
session_set_save_handler(new DbSessionHandler(), true);
