<?php

class Mensaje {

    public static function crear($data) {
        $db = DB::getConnection();

        $sql = "INSERT INTO mensajes_contacto
                (nombre, correo, telefono, asunto, mensaje, fecha)
                VALUES (:nombre, :correo, :telefono, :asunto, :mensaje, NOW())";

        $stmt = $db->prepare($sql);
        return $stmt->execute($data);
    }

    public static function obtenerTodos() {
        $db = DB::getConnection();

        $sql = "SELECT * FROM mensajes_contacto ORDER BY id DESC";
        $stmt = $db->query($sql);

        return $stmt->fetchAll();
    }

    public static function eliminar($id) {
        $db = DB::getConnection();

        $sql = "DELETE FROM mensajes_contacto WHERE id = :id";
        $stmt = $db->prepare($sql);

        return $stmt->execute([":id" => $id]);
    }
}
