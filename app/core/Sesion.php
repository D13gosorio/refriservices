<?php

// Arranque y ciclo de vida de la sesión, en un solo sitio.
class Sesion {

    // Se cierra la sesión tras este tiempo sin actividad...
    private const INACTIVIDAD_MINUTOS = 30;

    // ...y en todo caso pasado este tiempo desde que se inició, aunque el
    // usuario haya estado navegando sin parar. Acota cuánto sirve una cookie
    // robada.
    private const DURACION_MAXIMA_HORAS = 8;

    public static function httpsActivo(): bool {
        return (
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
            (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https')
        );
    }

    public static function iniciar(): void {
        // Las sesiones se guardan en Postgres: en Vercel (serverless) cada
        // invocación puede correr en una instancia distinta, sin disco
        // compartido para el guardado en archivos por defecto de PHP.
        session_set_save_handler(new DbSessionHandler(), true);

        // Solo se acepta el id de sesión por cookie: si viniera por la URL
        // quedaría registrado en historiales, logs y cabeceras Referer.
        ini_set('session.use_only_cookies', '1');
        ini_set('session.use_trans_sid', '0');

        // Modo estricto: PHP rechaza un id de sesión que no haya emitido él
        // mismo. Sin esto un atacante puede fijar de antemano el id de la
        // víctima (session fixation) y reutilizarlo tras el login.
        // Funciona porque DbSessionHandler implementa validateId().
        ini_set('session.use_strict_mode', '1');

        // La recolección de basura debe usar la MISMA ventana que la caducidad
        // por inactividad de aquí abajo. Por defecto son 1440 segundos (24 min),
        // menos que los 30 minutos anunciados: sin esto, DbSessionHandler::gc()
        // borraría la fila antes de tiempo y el usuario recibiría una sesión
        // nueva y anónima en vez del aviso de que expiró.
        ini_set('session.gc_maxlifetime', (string) (self::INACTIVIDAD_MINUTOS * 60));

        // Nombre propio en vez de PHPSESSID, que anuncia la tecnología del
        // servidor a cualquier escáner automático.
        session_name('refriservices_sesion');

        // Cookie endurecida:
        // - HttpOnly: inaccesible desde JavaScript (mitiga el robo vía XSS)
        // - Secure:   solo viaja por HTTPS (se desactiva en http local)
        // - SameSite: no se envía desde otro sitio en peticiones que cambian estado
        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => '/',
            'secure'   => self::httpsActivo(),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        session_start();

        self::aplicarCaducidad();
    }

    // Cierra la sesión por completo: vacía los datos, borra el registro en la
    // base de datos y elimina la cookie del navegador. session_destroy() por sí
    // solo no hace las dos últimas cosas, y la cookie caducada se queda dando
    // vueltas.
    public static function cerrar(): void {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $parametros = session_get_cookie_params();

            setcookie(session_name(), '', [
                'expires'  => time() - 42000,
                'path'     => $parametros['path'],
                'domain'   => $parametros['domain'],
                'secure'   => $parametros['secure'],
                'httponly' => $parametros['httponly'],
                'samesite' => $parametros['samesite'],
            ]);
        }

        session_destroy();
    }

    private static function aplicarCaducidad(): void {
        $ahora = time();

        if (!isset($_SESSION['_creada_en'])) {
            $_SESSION['_creada_en'] = $ahora;
        }

        $inactiva = isset($_SESSION['_ultimo_acceso'])
            && ($ahora - $_SESSION['_ultimo_acceso']) > self::INACTIVIDAD_MINUTOS * 60;

        $agotada = ($ahora - $_SESSION['_creada_en']) > self::DURACION_MAXIMA_HORAS * 3600;

        if (isset($_SESSION['usuario_id']) && ($inactiva || $agotada)) {
            $_SESSION = [];

            // Id nuevo y borrado del registro anterior, para que la cookie
            // vieja no valga aunque alguien la haya copiado.
            session_regenerate_id(true);

            $_SESSION['_creada_en'] = $ahora;
            $_SESSION['error'] = "Tu sesión expiró. Vuelve a iniciar sesión.";
        }

        $_SESSION['_ultimo_acceso'] = $ahora;
    }
}
