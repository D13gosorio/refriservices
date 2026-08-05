<?php

// Manejador de sesiones respaldado por la tabla `sesiones` en Postgres.
// Necesario porque en Vercel (serverless) cada invocación puede correr en una
// instancia distinta, sin filesystem compartido para el guardado por defecto de PHP.
class DbSessionHandler implements SessionHandlerInterface {

    public function open($savePath, $sessionName): bool {
        return true;
    }

    public function close(): bool {
        return true;
    }

    public function read($id): string {
        $db = DB::getConnection();
        $stmt = $db->prepare("SELECT datos FROM sesiones WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        return $row ? $row['datos'] : "";
    }

    public function write($id, $data): bool {
        $db = DB::getConnection();
        $sql = "INSERT INTO sesiones (id, datos, actualizado)
                VALUES (:id, :datos, NOW())
                ON CONFLICT (id) DO UPDATE
                SET datos = EXCLUDED.datos, actualizado = EXCLUDED.actualizado";

        $stmt = $db->prepare($sql);
        return $stmt->execute([':id' => $id, ':datos' => $data]);
    }

    public function destroy($id): bool {
        $db = DB::getConnection();
        $stmt = $db->prepare("DELETE FROM sesiones WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function gc($max_lifetime): int|false {
        $db = DB::getConnection();
        $stmt = $db->prepare("DELETE FROM sesiones WHERE actualizado < NOW() - MAKE_INTERVAL(secs => :segundos)");
        $stmt->execute([':segundos' => $max_lifetime]);
        return $stmt->rowCount();
    }
}
