<?php

// Limita los intentos de login para dificultar fuerza bruta y credential
// stuffing. Se cuenta en dos niveles:
//
//   - por IP + correo: frena el ataque contra una cuenta concreta.
//   - por IP a secas:  frena el "password spraying", donde se prueba una
//                      misma contraseña contra muchísimos correos distintos
//                      y el contador por cuenta nunca llegaría al límite.
//
// Nota: las claves llevan prefijo ("login:", "login-ip:"), así que los
// contadores que hubiera de antes del cambio simplemente dejan de contar.
class LoginThrottle {

    private const MAX_POR_CUENTA  = 5;
    private const MAX_POR_IP      = 20;
    private const VENTANA_MINUTOS = 15;

    private static function claveCuenta(string $email): string {
        return 'login:' . Limite::ip() . '|' . strtolower($email);
    }

    private static function claveIp(): string {
        return 'login-ip:' . Limite::ip();
    }

    // true si ya se superó alguno de los dos límites.
    public static function bloqueado(string $email): bool {
        return Limite::excedido(self::claveCuenta($email), self::MAX_POR_CUENTA, self::VENTANA_MINUTOS)
            || Limite::excedido(self::claveIp(), self::MAX_POR_IP, self::VENTANA_MINUTOS);
    }

    public static function registrarFallo(string $email): void {
        Limite::registrar(self::claveCuenta($email));
        Limite::registrar(self::claveIp());
    }

    // Se llama tras un login exitoso para no seguir arrastrando el contador
    // de esa cuenta. El contador por IP se deja intacto a propósito: si no,
    // bastaría con una credencial válida para reiniciarlo a voluntad.
    public static function limpiar(string $email): void {
        Limite::limpiar(self::claveCuenta($email));
    }
}
