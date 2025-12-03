<?php

class AuthController {

    // =====================================================
    // 1. Mostrar formulario de login
    // =====================================================
    public function login() {

        // CSS específico de esta vista
        $cssPagina = "login";

        include "../app/views/layout/header.php";
        include "../app/views/public/login.php";
        include "../app/views/layout/footer.php";
    }

    // =====================================================
    // 2. Procesar login (aún sin backend)
    // =====================================================
    public function doLogin() {

        // Más adelante: validar correo/contraseña con BD
        echo "Procesando login (todavía sin backend)";
    }

    // =====================================================
    // 3. Mostrar formulario de registro
    // =====================================================
    public function registro() {

        // CSS específico de esta vista
        $cssPagina = "registro";

        include "../app/views/layout/header.php";
        include "../app/views/public/registro.php";
        include "../app/views/layout/footer.php";
    }

// =====================================================
    // 4. Procesar registro 
    // =====================================================
    public function doRegistro(){
        // 1. Validamos que venga por el metodo POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header("Location: ". BASE_URL . "/?controller=AuthController&method=registro");
            exit;
        }

        // 2. Recibir los campos
        $nombre = trim($_POST['nombre'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST ['password_confirm'] ?? '';

        // 3. Hacemos la validación de campos vacíos
        if (empty($nombre) || empty($telefono) || empty($direccion) || empty($email) || empty($password) || empty($password_confirm)){
            $_SESSION['error'] = "Todos los campos son obligatorios";
            header("Location: " . BASE_URL . "/?controller=AuthController&method=registro");
            exit;
        }

        // 4. Validamos el formato del email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['error'] = "El correo electrónico no es válido.";
            header("Location: " . BASE_URL . "/?controller=AuthController&method=registro");
            exit;
        }

        // 5. Validamos la contraseña
        if ($password !== $password_confirm){
            
        }







    }

    

    // =====================================================
    // 5. Cerrar sesión
    // =====================================================
    public function logout() {

        session_start();
        session_destroy();

        header("Location: " . BASE_URL . "/");
        exit;
    }
}
