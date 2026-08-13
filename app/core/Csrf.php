<?php

// Protección CSRF basada en un token por sesión.
class Csrf {

    private const SESSION_KEY = '_csrf_token';

    // Devuelve el token de la sesión actual, generándolo si no existe.
    public static function token(): string {
        if (empty($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
        }

        return $_SESSION[self::SESSION_KEY];
    }

    // Imprime el <input hidden> listo para incrustar en un <form>.
    public static function field(): string {
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(self::token()) . '">';
    }

    // Verifica el token recibido en la petición contra el de la sesión.
    // Si no coincide, corta la ejecución con 403 (no revela más detalle).
    //
    // De paso se comprueba el origen de la petición. Se hace aquí, y no en cada
    // controlador, porque todas las acciones que modifican datos ya pasan por
    // este método: así no queda ninguna sin cubrir por olvido.
    public static function verificarOMorir(): void {
        Origen::verificarOMorir();

        // Se comprueba que sea texto antes de compararlo: enviando
        // "csrf_token[]=x" el valor llega como array y hash_equals() lanzaría
        // un TypeError, es decir un error 500 en vez del 403 que toca.
        $recibido = $_POST['csrf_token'] ?? '';

        if (!is_string($recibido) || empty($_SESSION[self::SESSION_KEY])
            || !hash_equals($_SESSION[self::SESSION_KEY], $recibido)) {
            http_response_code(403);
            die("Solicitud inválida o expirada. Vuelve a intentarlo.");
        }
    }
}
