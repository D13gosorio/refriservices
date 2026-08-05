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
    public static function verificarOMorir(): void {
        $recibido = $_POST['csrf_token'] ?? '';

        if (empty($_SESSION[self::SESSION_KEY]) || !hash_equals($_SESSION[self::SESSION_KEY], $recibido)) {
            http_response_code(403);
            die("Solicitud inválida o expirada. Vuelve a intentarlo.");
        }
    }
}
