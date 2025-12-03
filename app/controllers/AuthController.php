<?php

class AuthController {

    // =====================================================
    // 1. Mostrar formulario de login
    // =====================================================
    public function login() {

        session_start();
        // CSS específico de esta vista
        $cssPagina = "login";

        include "../app/views/layout/header.php";
        include "../app/views/public/login.php";
        include "../app/views/layout/footer.php";
    }

    // =====================================================
    // 2. Procesar login 
    // =====================================================
    public function doLogin() {
    session_start();
    require_once __DIR__ . "/../models/Usuario.php";

    // 1. Verificar que venga por POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error'] = "Acceso no permitido.";
        header("Location: " . BASE_URL . "/?controller=AuthController&method=login");
        exit;
    }

    // 2. Recibir campos
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // 3. Validar campos vacíos
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "El correo y la contraseña son obligatorios.";
        header("Location: " . BASE_URL . "/?controller=AuthController&method=login");
        exit;
    }

    // 4. Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Correo electrónico no válido.";
        header("Location: " . BASE_URL . "/?controller=AuthController&method=login");
        exit;
    }

    // 5. Buscar usuario por email
    $usuario = Usuario::buscarPorEmail($email);

    if (!$usuario) {
        $_SESSION['error'] = "El correo o la contraseña ingresados son incorrectos.";
        header("Location: " . BASE_URL . "/?controller=AuthController&method=login");
        exit;
    }

    // 6. Validar contraseña con password_verify()
    if (!password_verify($password, $usuario['password'])) {
        $_SESSION['error'] = "El correo o la contraseña ingresados son incorrectos.";
        header("Location: " . BASE_URL . "/?controller=AuthController&method=login");
        exit;
    }

    // 7. Iniciar sesión
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nombre'] = $usuario['nombre'];
    $_SESSION['usuario_rol'] = $usuario['rol'];
    session_regenerate_id(true);

    // 8. Redirigir según rol
    if ($usuario['rol'] === 'admin') {
        header("Location: " . BASE_URL . "/?controller=AdminController&method=index");
    } else {
        header("Location: " . BASE_URL . "/?controller=HomeController&method=index");
    }

    exit;
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
            $_SESSION['error'] = "Las contraseñas no coinciden.";
            header("Location: " . BASE_URL . "/?controller=AuthController&method=registro");
        }

        // 6. Incluir modelo
        require_once __DIR__ . "/../models/Usuario.php";

        // 7. Validamos si el email ya está registrado
        $existe = Usuario::buscarPorEmail($email);

        if($existe){
            $_SESSION['error'] = "Ese correo ya está registrado.";
            header("Location: " . BASE_URL . "/?controller=AuthController&method=registro");
            exit;
        }

        // 8. Hashear la contraseña
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // 9. Crear usuario
        $creado = Usuario::crear([
            'nombre' => $nombre,
            'email' => $email,
            'password' => $hash,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'rol' => 'cliente'
        ]);

        if($creado){
            $_SESSION['success'] = "Tu cuenta se creó correctamente. Ya puedes iniciar sesión.";
            header("Location: " . BASE_URL . "/?controller=AuthController&method=login");
        } else {
            $_SESSION['error'] = "Hubo un error al crear tu cuenta. Intenta nuevamente.";
            header("Location: " . BASE_URL . "/?controller=AuthController&method=registro");
        }
        exit;
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
