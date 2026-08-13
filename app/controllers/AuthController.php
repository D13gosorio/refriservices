<?php

class AuthController {

    // =====================================================
    // 1. Mostrar formulario de login
    // =====================================================
    public function login() {

        // CSS específico de esta vista
        $cssPagina = "login";

        include ROOT_PATH . "/app/views/layout/header.php";
        include ROOT_PATH . "/app/views/public/login.php";
        include ROOT_PATH . "/app/views/layout/footer.php";
    }

    // =====================================================
    // 2. Procesar login 
    // =====================================================
    public function doLogin() {
    require_once __DIR__ . "/../models/Usuario.php";

    // 1. Verificar que venga por POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error'] = "Acceso no permitido.";
        header("Location: " . BASE_URL . "/?controller=AuthController&method=login");
        exit;
    }

    Csrf::verificarOMorir();

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

    // 5. Verificar que no haya demasiados intentos fallidos recientes
    //    para esta combinación de IP + correo (protección anti fuerza bruta)
    if (LoginThrottle::bloqueado($email)) {
        $_SESSION['error'] = "Demasiados intentos fallidos. Espera unos minutos e inténtalo de nuevo.";
        header("Location: " . BASE_URL . "/?controller=AuthController&method=login");
        exit;
    }

    // 6. Buscar usuario por email
    $usuario = Usuario::buscarPorEmail($email);

    if (!$usuario) {
        LoginThrottle::registrarFallo($email);
        $_SESSION['error'] = "El correo o la contraseña ingresados son incorrectos.";
        header("Location: " . BASE_URL . "/?controller=AuthController&method=login");
        exit;
    }

    // 7. Validar contraseña con password_verify()
    if (!password_verify($password, $usuario['password'])) {
        LoginThrottle::registrarFallo($email);
        $_SESSION['error'] = "El correo o la contraseña ingresados son incorrectos.";
        header("Location: " . BASE_URL . "/?controller=AuthController&method=login");
        exit;
    }

    // 8. Iniciar sesión
    LoginThrottle::limpiar($email);

    // El id se renueva ANTES de guardar nada: si alguien consiguió que la
    // víctima usara un id conocido, ese id queda descartado y nunca llega a
    // estar asociado a una sesión autenticada (session fixation).
    session_regenerate_id(true);

    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nombre'] = $usuario['nombre'];
    $_SESSION['usuario_rol'] = $usuario['rol'];

    // Arranca aquí el reloj de la duración máxima de sesión.
    $_SESSION['_creada_en'] = time();

    // 9. Redirigir según rol
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

        include ROOT_PATH . "/app/views/layout/header.php";
        include ROOT_PATH . "/app/views/public/registro.php";
        include ROOT_PATH . "/app/views/layout/footer.php";
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

        Csrf::verificarOMorir();

        // 1.1 Tope de cuentas creadas desde una misma conexión, para que nadie
        // llene la tabla de usuarios con registros automatizados.
        $claveRegistro = 'registro:' . Limite::ip();

        if (Limite::excedido($claveRegistro, 5, 60)) {
            $_SESSION['error'] = "Se alcanzó el límite de cuentas nuevas desde esta conexión. Inténtalo más tarde.";
            header("Location: " . BASE_URL . "/?controller=AuthController&method=registro");
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

        // 4.1 Topes de longitud y formato. Los atributos del formulario HTML
        // se saltan con cualquier cliente que no sea un navegador, así que sin
        // esto se pueden enviar campos de megabytes (llenan la tabla) o
        // contraseñas enormes (cada intento cuesta memoria y CPU al hashear).
        if (mb_strlen($nombre) > 100 || mb_strlen($email) > 255 ||
            mb_strlen($telefono) > 30 || mb_strlen($direccion) > 255) {
            $_SESSION['error'] = "Alguno de los datos ingresados es demasiado largo.";
            header("Location: " . BASE_URL . "/?controller=AuthController&method=registro");
            exit;
        }

        if (strlen($password) > 72) {
            $_SESSION['error'] = "La contraseña no puede tener más de 72 caracteres.";
            header("Location: " . BASE_URL . "/?controller=AuthController&method=registro");
            exit;
        }

        if (!preg_match('/^[0-9+()\s.-]{6,30}$/', $telefono)) {
            $_SESSION['error'] = "El teléfono solo puede tener números, espacios y los signos + - ( ) .";
            header("Location: " . BASE_URL . "/?controller=AuthController&method=registro");
            exit;
        }

        // 5. Validamos la contraseña
        if ($password !== $password_confirm){
            $_SESSION['error'] = "Las contraseñas no coinciden.";
            header("Location: " . BASE_URL . "/?controller=AuthController&method=registro");
            exit;
        }

        // La validación del formulario (minlength/pattern) es solo del lado
        // del cliente y se puede saltar fácilmente; se repite aquí.
        if (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
            $_SESSION['error'] = "La contraseña debe tener al menos 8 caracteres e incluir letras y números.";
            header("Location: " . BASE_URL . "/?controller=AuthController&method=registro");
            exit;
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
        try {
            $creado = Usuario::crear([
                'nombre' => $nombre,
                'email' => $email,
                'password' => $hash,
                'telefono' => $telefono,
                'direccion' => $direccion,
                'rol' => 'cliente'
            ]);
        } catch (PDOException $e) {
            $creado = false;
        }

        if($creado){
            Limite::registrar($claveRegistro);
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
    // Solo por POST y con token CSRF: si fuera un enlace GET, cualquier página
    // ajena (o el prefetch del propio navegador) podría cerrar la sesión del
    // usuario con solo cargar una imagen apuntando a esta URL.
    public function logout() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die("Método no permitido.");
        }

        Csrf::verificarOMorir();

        Sesion::cerrar();

        header("Location: " . BASE_URL . "/");
        exit;
    }
}
