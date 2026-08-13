<?php

// Contador genérico de acciones por ventana de tiempo. Sirve para frenar
// fuerza bruta contra el login y envíos masivos del formulario de contacto.
//
// Se apoya en la tabla `intentos_login` que ya existía: su columna `identidad`
// guarda una clave con prefijo ("login:...", "contacto:...") para poder contar
// varios tipos de acción sin crear una tabla por cada uno.
class Limite {

    // IP del visitante. Detrás del proxy de Vercel la IP real llega en
    // X-Forwarded-For con el formato "cliente, proxy1, proxy2".
    public static function ip(): string {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'desconocida';

        // Se recorta para que una cabecera manipulada de tamaño absurdo no
        // llegue nunca a la consulta.
        return substr(trim(explode(',', $ip)[0]), 0, 45);
    }

    // Lo que se guarda no es la clave sino su hash, por dos motivos:
    //
    //   - la clave lleva IP y correo, y esta tabla no necesita conservar datos
    //     personales para hacer su trabajo (solo comparar por igualdad);
    //   - así la columna recibe siempre 64 caracteres, en vez de una cadena que
    //     con un correo largo puede pasar de 300.
    private static function huella(string $clave): string {
        return hash('sha256', $clave);
    }

    // true si la clave ya alcanzó el máximo de registros dentro de la ventana.
    public static function excedido(string $clave, int $maximo, int $minutos): bool {
        try {
            $db = DB::getConnection();
            $stmt = $db->prepare(
                "SELECT COUNT(*) FROM intentos_login
                 WHERE identidad = :identidad AND creado_en > NOW() - MAKE_INTERVAL(mins => :minutos)"
            );
            $stmt->execute([':identidad' => self::huella($clave), ':minutos' => $minutos]);

            return (int) $stmt->fetchColumn() >= $maximo;
        } catch (PDOException $e) {
            // Si el contador falla no se deja el sitio inservible: se registra
            // el problema y se permite continuar. El token CSRF y el resto de
            // validaciones siguen aplicando en todo caso.
            error_log('[LIMITE] No se pudo consultar el contador: ' . $e->getMessage());
            return false;
        }
    }

    public static function registrar(string $clave): void {
        try {
            $db = DB::getConnection();
            $stmt = $db->prepare("INSERT INTO intentos_login (identidad) VALUES (:identidad)");
            $stmt->execute([':identidad' => self::huella($clave)]);

            self::limpiezaOportunista();
        } catch (PDOException $e) {
            error_log('[LIMITE] No se pudo registrar el intento: ' . $e->getMessage());
        }
    }

    public static function limpiar(string $clave): void {
        try {
            $db = DB::getConnection();
            $stmt = $db->prepare("DELETE FROM intentos_login WHERE identidad = :identidad");
            $stmt->execute([':identidad' => self::huella($clave)]);
        } catch (PDOException $e) {
            error_log('[LIMITE] No se pudo limpiar el contador: ' . $e->getMessage());
        }
    }

    // No hay tarea programada (cron) que purgue filas viejas, así que se
    // aprovecha una de cada veinte escrituras para borrar lo que ya no aporta.
    private static function limpiezaOportunista(): void {
        if (random_int(1, 20) !== 1) {
            return;
        }

        $db = DB::getConnection();
        $stmt = $db->prepare("DELETE FROM intentos_login WHERE creado_en < NOW() - INTERVAL '1 day'");
        $stmt->execute();
    }
}
