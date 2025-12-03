<?php

class Servicio {

    public static function obtenerTodos() {
        $db = DB::getConnection();

        $sql = "SELECT * FROM servicios ORDER BY precio ASC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

    public static function obtenerPorId($id) {
        $db = DB::getConnection();

        $sql = "SELECT * FROM servicios WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public static function crear($data) {
        $db = DB::getConnection();

        $sql = "INSERT INTO servicios (nombre, descripcion, precio)
                VALUES (:nombre, :descripcion, :precio)";

        $stmt = $db->prepare($sql);
        return $stmt->execute($data);
    }

    public static function actualizar($data) {
        $db = DB::getConnection();

        $sql = "UPDATE servicios
                SET nombre = :nombre,
                    descripcion = :descripcion,
                    precio = :precio
                WHERE id = :id";

        $stmt = $db->prepare($sql);
        return $stmt->execute($data);
    }

    public static function eliminar($id) {
        $db = DB::getConnection();

        $sql = "DELETE FROM servicios WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
