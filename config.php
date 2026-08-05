<?php
// Ruta absoluta a la raíz del proyecto (útil para requires estables sin importar
// desde qué punto de entrada se ejecute: public/index.php en local o api/index.php en Vercel)
define("ROOT_PATH", __DIR__);

// Modo debug: SOLO se activa si se define explícitamente APP_DEBUG=1 como
// variable de entorno (uso exclusivo para depuración local). En cualquier
// otro caso (incluida producción) los errores nunca se muestran al
// visitante: se registran con error_log y se responde un mensaje genérico.
define("APP_DEBUG", getenv("APP_DEBUG") === "1");

ini_set('display_errors', APP_DEBUG ? '1' : '0');
ini_set('display_startup_errors', APP_DEBUG ? '1' : '0');
error_reporting(E_ALL);

// Nota: solo se centralizan excepciones no capturadas (Throwable) y errores
// fatales (abajo). Los avisos/warnings normales de PHP se dejan con su
// comportamiento habitual (se registran en el log si log_errors está
// activo, pero no interrumpen la respuesta), para no arriesgar cambiar el
// comportamiento de código existente sin poder probarlo exhaustivamente.
set_exception_handler(function (Throwable $e) {
    error_log('[EXCEPCION NO CAPTURADA] ' . $e->getMessage() . ' en ' . $e->getFile() . ':' . $e->getLine());

    if (!headers_sent()) {
        http_response_code(500);
    }

    if (APP_DEBUG) {
        echo '<pre>' . htmlspecialchars((string) $e) . '</pre>';
    } else {
        echo "Ha ocurrido un error inesperado. Por favor intenta de nuevo más tarde.";
    }
});

// Cubre errores fatales que set_exception_handler no puede interceptar
// (por ejemplo, agotar la memoria disponible o un error de sintaxis).
register_shutdown_function(function () {
    $error = error_get_last();
    $esFatal = $error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true);

    if (!$esFatal) {
        return;
    }

    error_log('[ERROR FATAL] ' . $error['message'] . ' en ' . $error['file'] . ':' . $error['line']);

    if (!headers_sent()) {
        http_response_code(500);
    }

    if (!APP_DEBUG) {
        echo "Ha ocurrido un error inesperado. Por favor intenta de nuevo más tarde.";
    }
});

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
require_once ROOT_PATH . "/app/core/Csrf.php";
require_once ROOT_PATH . "/app/core/LoginThrottle.php";
session_set_save_handler(new DbSessionHandler(), true);

// Cookie de sesión endurecida:
// - HttpOnly: inaccesible desde JavaScript (mitiga robo de sesión vía XSS)
// - Secure: solo se envía por HTTPS (se desactiva automáticamente en http local)
// - SameSite=Lax: no se envía en peticiones cross-site que cambian estado
$httpsActivo = (
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
    (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https')
);

session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'secure'   => $httpsActivo,
    'httponly' => true,
    'samesite' => 'Lax',
]);

// La sesión se inicia aquí, antes de que cualquier vista imprima HTML.
// (session_start() debe llamarse antes de enviar cualquier salida; el
// runtime de PHP en Vercel no usa buffering de salida por defecto como
// sí ocurre típicamente en XAMPP/Apache, así que iniciarla más tarde,
// dentro de un controlador o vista, falla en producción).
session_start();
