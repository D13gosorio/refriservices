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

// Conexión a BD, sesiones persistentes en la base de datos y utilidades de
// seguridad. Las sesiones en BD son obligatorias en entornos serverless
// (Vercel), donde no hay disco compartido entre invocaciones.
require_once ROOT_PATH . "/app/core/DB.php";
require_once ROOT_PATH . "/app/core/DbSessionHandler.php";
require_once ROOT_PATH . "/app/core/Sesion.php";
require_once ROOT_PATH . "/app/core/Origen.php";
require_once ROOT_PATH . "/app/core/Csrf.php";
require_once ROOT_PATH . "/app/core/Limite.php";
require_once ROOT_PATH . "/app/core/LoginThrottle.php";
require_once ROOT_PATH . "/app/core/Password.php";

// mbstring viene de serie en el runtime de Vercel y en XAMPP, pero sigue siendo
// una extensión opcional. Si faltara, las comprobaciones de longitud del
// registro y del formulario de contacto provocarían un error fatal. Con esto
// pasan a contar bytes, que para un tope máximo cumple igual de bien.
if (!function_exists('mb_strlen')) {
    function mb_strlen($cadena, $codificacion = null) {
        return strlen((string) $cadena);
    }
}

if (!function_exists('mb_strtolower')) {
    function mb_strtolower($cadena, $codificacion = null) {
        return strtolower((string) $cadena);
    }
}

if (!function_exists('mb_str_split')) {
    function mb_str_split($cadena, $longitud = 1, $codificacion = null) {
        return str_split((string) $cadena, $longitud);
    }
}

// Todo el sitio va por HTTPS: si llega una petición en claro se redirige antes
// de tocar la sesión o la base de datos, para que la cookie de sesión no llegue
// a viajar sin cifrar. En local (http://localhost) no se redirige.
//
// Solo se redirige cuando hay constancia de que la petición vino en claro:
//
//   - el proxy lo dice explícitamente (X-Forwarded-Proto: http), o
//   - no hay ningún proxy delante y PHP confirma que no hay TLS.
//
// Si hay un proxy delante pero no dice qué protocolo usó, no se redirige. Esa
// prudencia es a propósito: dar por supuesto que vino en claro cuando en
// realidad venía cifrado deja el sitio dando vueltas en un bucle infinito de
// redirecciones, y eso es peor que la falta que se pretendía corregir.
// (En Vercel esto es solo una red de seguridad: la plataforma ya redirige a
// HTTPS en el borde.)
$hostPeticion   = preg_replace('/[^A-Za-z0-9.\-:\[\]]/', '', $_SERVER['HTTP_HOST'] ?? '');
$protoReenviado = strtolower(trim($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? ''));
$esLocal        = preg_match('/^(localhost|127\.0\.0\.1|\[::1\])(:\d+)?$/i', $hostPeticion) === 1;

$hayProxyDelante = isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || isset($_SERVER['HTTP_X_FORWARDED_HOST'])
    || isset($_SERVER['HTTP_X_FORWARDED_PROTO']);

$vinoEnClaro = $protoReenviado === 'http'
    || (!$hayProxyDelante && !Sesion::httpsActivo());

// 302 y no 301: un redirect permanente se queda cacheado en el navegador, y si
// alguien entra al XAMPP por la IP de la red local (que no cuenta como local
// según el patrón de arriba) se quedaría clavado apuntando a un https que ahí
// no existe, hasta que limpiara la caché.
if ($vinoEnClaro && !$esLocal && $hostPeticion !== '') {
    header("Location: https://" . $hostPeticion . ($_SERVER['REQUEST_URI'] ?? '/'), true, 302);
    exit;
}

// La sesión se inicia aquí, antes de que cualquier vista imprima HTML.
// (session_start() debe llamarse antes de enviar cualquier salida; el
// runtime de PHP en Vercel no usa buffering de salida por defecto como
// sí ocurre típicamente en XAMPP/Apache, así que iniciarla más tarde,
// dentro de un controlador o vista, falla en producción).
Sesion::iniciar();
