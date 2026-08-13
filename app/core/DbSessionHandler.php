<?php

// Manejador de sesiones respaldado por la tabla `sesiones` en Postgres.
// Necesario porque en Vercel (serverless) cada invocación puede correr en una
// instancia distinta, sin filesystem compartido para el guardado por defecto de PHP.
//
// Implementa además SessionUpdateTimestampHandlerInterface porque es lo que
// permite que `session.use_strict_mode` funcione de verdad con un manejador
// propio: sin validateId(), PHP no puede distinguir un id inventado por un
// atacante de uno emitido por el servidor.
class DbSessionHandler implements SessionHandlerInterface, SessionUpdateTimestampHandlerInterface {

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

        // El casting es por el tipo de retorno declarado: si la columna llegara
        // a NULL, devolverla tal cual sería un TypeError.
        return (string) ($row['datos'] ?? "");
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

    // Solo acepta ids que ya existan en la tabla, es decir, emitidos por el
    // propio servidor. Si un visitante llega con un id inventado, PHP genera
    // uno nuevo en lugar de adoptarlo (esto es lo que corta session fixation).
    public function validateId($id): bool {
        $db = DB::getConnection();
        $stmt = $db->prepare("SELECT 1 FROM sesiones WHERE id = :id");
        $stmt->execute([':id' => $id]);

        return $stmt->fetchColumn() !== false;
    }

    // Se llama cuando la sesión no cambió: basta con refrescar la marca de
    // tiempo para que la recolección de basura no la borre estando en uso.
    public function updateTimestamp($id, $data): bool {
        $db = DB::getConnection();
        $stmt = $db->prepare("UPDATE sesiones SET actualizado = NOW() WHERE id = :id");
        $stmt->execute([':id' => $id]);

        // execute() devuelve true aunque no haya tocado ninguna fila. Si la
        // recolección de basura borró el registro mientras la sesión seguía
        // viva, hay que volver a insertarlo: de lo contrario PHP daría por
        // guardada una sesión que ya no existe y se perdería sin avisar.
        if ($stmt->rowCount() === 0) {
            return $this->write($id, $data);
        }

        return true;
    }

    public function gc($max_lifetime): int|false {
        $db = DB::getConnection();
        $stmt = $db->prepare("DELETE FROM sesiones WHERE actualizado < NOW() - MAKE_INTERVAL(secs => :segundos)");
        $stmt->execute([':segundos' => $max_lifetime]);
        return $stmt->rowCount();
    }
}
