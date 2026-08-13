<?php

class Usuario {
    protected static function conexion(){
        return DB::getConnection();
    }

    // =====================================================
    // Buscar usuario por email
    // =====================================================
    // Es la única consulta que trae el hash de la contraseña, porque el login
    // lo necesita para password_verify(). Se piden las columnas una por una en
    // vez de "SELECT *" para que, si mañana la tabla gana campos sensibles,
    // no empiecen a viajar solos hasta los controladores y las vistas.
    // La comparación ignora mayúsculas: los correos no las distinguen en la
    // práctica, y buscándolos tal cual se podía registrar "Admin@x.com" cuando
    // ya existía "admin@x.com", quedando dos cuentas para la misma persona.
    // Se apoya en el índice sobre LOWER(email) que crea db/seguridad.sql.
    public static function buscarPorEmail($email){
        $db = self::conexion();
        $sql = "SELECT id, nombre, email, password, rol
                FROM usuarios WHERE LOWER(email) = LOWER(:email) LIMIT 1";
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
    // Sin el hash de la contraseña: esta consulta se usa para comprobar
    // permisos en cada petición al panel, y ese dato no pinta nada ahí.
    public static function buscarPorId($id){
        $db = self::conexion();

        $sql = "SELECT id, nombre, email, telefono, direccion, rol
                FROM usuarios WHERE id = :id LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}