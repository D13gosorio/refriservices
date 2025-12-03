<?php

class Repuesto {

    public static function obtenerTodos() {
        $db = DB::getConnection();

        $sql = "SELECT * FROM repuestos ORDER BY id ASC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

    public static function obtenerPorId($id) {
        $db = DB::getConnection();

        $sql = "SELECT * FROM repuestos WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public static function crear($data) {
        $db = DB::getConnection();

        $sql = "INSERT INTO repuestos (nombre, descripcion, precio, stock, imagen)
                VALUES (:nombre, :descripcion, :precio, :stock, :imagen)";

        $stmt = $db->prepare($sql);
        return $stmt->execute($data);
    }

    public static function actualizar($data) {
        $db = DB::getConnection();

        $sql = "UPDATE repuestos
                SET nombre = :nombre, descripcion = :descripcion, precio = :precio,
                    stock = :stock, imagen = :imagen
                WHERE id = :id";

        $stmt = $db->prepare($sql);
        return $stmt->execute($data);
    }

    public static function eliminar($id) {
        $db = DB::getConnection();

        $sql = "DELETE FROM repuestos WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
