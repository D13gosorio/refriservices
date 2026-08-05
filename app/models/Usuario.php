<?php

class Usuario {
    protected static function conexion(){
        return DB::getConnection();
    }

    // =====================================================
    // Buscar usuario por email
    // =====================================================
    public static function buscarPorEmail($email){
        $db = self::conexion();
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email',$email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // =====================================================
    // insertar usuario a la base de datos
    // =====================================================
    public static function crear($data){
        $db = self::conexion();

        $sql = "INSERT INTO usuarios (nombre, email, password, telefono, direccion, rol) VALUES (:nombre, :email, :password, :telefono, :direccion, :rol)";

        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':email' => $data['email'],
            ':password' => $data['password'],
            ':telefono' => $data['telefono'],
            ':direccion' => $data['direccion'],
            ':rol' => $data['rol'] ?? 'cliente'
        ]);
    }

     // =====================================================
    // Busqueda por ID
    // =====================================================
    public static function buscarPorId($id){
        $db = self::conexion();

        $sql = "SELECT * FROM usuarios WHERE id = :id LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}