<?php

// Limita los intentos de login por combinación de IP + correo, para
// dificultar ataques de fuerza bruta / credential stuffing.
class LoginThrottle {

    private const MAX_INTENTOS = 5;
    private const VENTANA_MINUTOS = 15;

    private static function identidad(string $email): string {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'desconocida';
        // X-Forwarded-For puede traer una lista "cliente, proxy1, proxy2"
        $ip = trim(explode(',', $ip)[0]);

        return $ip . '|' . strtolower($email);
    }

    // true si ya se superó el límite de intentos recientes.
    public static function bloqueado(string $email): bool {
        $db = DB::getConnection();
        $stmt = $db->prepare(
            "SELECT COUNT(*) FROM intentos_login
             WHERE identidad = :identidad AND creado_en > NOW() - MAKE_INTERVAL(mins => :minutos)"
        );
        $stmt->execute([
            ':identidad' => self::identidad($email),
            ':minutos' => self::VENTANA_MINUTOS,
        ]);

        return (int) $stmt->fetchColumn() >= self::MAX_INTENTOS;
    }

    public static function registrarFallo(string $email): void {
        $db = DB::getConnection();
        $stmt = $db->prepare("INSERT INTO intentos_login (identidad) VALUES (:identidad)");
        $stmt->execute([':identidad' => self::identidad($email)]);

        self::limpiezaOportunista();
    }

    // No hay tarea programada (cron) para purgar filas viejas, así que se
    // aprovecha cada intento fallido para, ocasionalmente, limpiar registros
    // que ya no aportan nada (más antiguos que la ventana de bloqueo).
    private static function limpiezaOportunista(): void {
        if (random_int(1, 20) !== 1) {
            return;
        }

        $db = DB::getConnection();
        $stmt = $db->prepare("DELETE FROM intentos_login WHERE creado_en < NOW() - INTERVAL '1 day'");
        $stmt->execute();
    }

    // Se llama tras un login exitoso para no seguir arrastrando el contador.
    public static function limpiar(string $email): void {
        $db = DB::getConnection();
        $stmt = $db->prepare("DELETE FROM intentos_login WHERE identidad = :identidad");
        $stmt->execute([':identidad' => self::identidad($email)]);
    }
}
