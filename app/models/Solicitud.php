<?php

class Solicitud {

    public static function obtenerTodas() {
        $db = DB::getConnection();

        $sql = "SELECT s.id,
                       u.nombre AS cliente,
                       srv.nombre AS servicio,
                       s.estado,
                       s.fecha_solicitada,
                       s.fecha_programada,
                       s.cantidad
                FROM solicitudes s
                INNER JOIN usuarios u ON s.id_usuario = u.id
                INNER JOIN servicios srv ON s.id_servicio = srv.id
                ORDER BY s.id DESC";

        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

    public static function obtenerPorUsuario($idUsuario) {
        $db = DB::getConnection();

        $sql = "SELECT s.id,
                       srv.nombre AS servicio,
                       s.cantidad,
                       s.fecha_solicitada,
                       s.fecha_programada,
                       s.estado
                FROM solicitudes s
                INNER JOIN servicios srv ON s.id_servicio = srv.id
                WHERE s.id_usuario = :id_usuario
                ORDER BY s.id DESC";

        $stmt = $db->prepare($sql);
        $stmt->execute([":id_usuario" => $idUsuario]);

        return $stmt->fetchAll();
    }

    public static function obtenerPorId($id) {
        $db = DB::getConnection();

        $sql = "SELECT s.id,
                       s.id_usuario,
                       srv.nombre AS servicio,
                       srv.precio AS precio,
                       s.cantidad,
                       s.fecha_solicitada,
                       s.fecha_programada,
                       s.descripcion,
                       s.estado
                FROM solicitudes s
                INNER JOIN servicios srv ON s.id_servicio = srv.id
                WHERE s.id = :id";

        $stmt = $db->prepare($sql);
        $stmt->execute([":id" => $id]);

        return $stmt->fetch();
    }

    public static function crear($data) {
        $db = DB::getConnection();

        $sql = "INSERT INTO solicitudes 
               (id_usuario, id_servicio, cantidad, fecha_solicitada, descripcion)
                VALUES (:id_usuario, :id_servicio, :cantidad, :fecha_solicitada, :descripcion)";

        $stmt = $db->prepare($sql);
        return $stmt->execute($data);
    }

    public static function actualizarEstado($id, $estado) {
        $db = DB::getConnection();

        $sql = "UPDATE solicitudes SET estado = :estado WHERE id = :id";
        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ':estado' => $estado,
            ':id' => $id
        ]);
    }

    public static function actualizarFechaProgramada($id, $fecha) {
        $db = DB::getConnection();

        $sql = "UPDATE solicitudes SET fecha_programada = :fecha WHERE id = :id";
        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ':fecha' => $fecha,
            ':id' => $id
        ]);
    }

    public static function eliminar($id) {
        $db = DB::getConnection();

        $sql = "DELETE FROM solicitudes WHERE id = :id";
        $stmt = $db->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }
}
