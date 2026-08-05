<?php

class DB {

    private static $instance = null;

    public static function getConnection() {

        if (self::$instance === null) {
            $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";sslmode=" . DB_SSLMODE;

            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    // Obligatorio: el pooler de Supabase (Supavisor, modo transacción)
                    // no soporta prepared statements nativos del servidor, ya que cada
                    // consulta puede viajar por una conexión física distinta.
                    PDO::ATTR_EMULATE_PREPARES   => true,
                ]);
            } catch (PDOException $e) {
                // No se expone el detalle de la excepción (puede incluir host,
                // usuario u otros datos de conexión): se registra en el log
                // del servidor y se muestra un mensaje genérico al visitante.
                error_log('[DB] Error de conexión: ' . $e->getMessage());
                http_response_code(503);
                die(defined('APP_DEBUG') && APP_DEBUG
                    ? "Error de conexión a la base de datos: " . $e->getMessage()
                    : "El servicio no está disponible en este momento. Intenta de nuevo más tarde.");
            }
        }

        return self::$instance;
    }
}
