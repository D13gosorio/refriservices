<?php

class AuthController {

    // Vuelve al formulario de acceso con un aviso, conservando el correo ya
    // escrito. La contraseña no se guarda nunca.
    private function volverALogin(string $mensaje, string $email = ''): void {
        $_SESSION['error'] = $mensaje;

        if ($email !== '') {
            $_SESSION['login_email'] = $email;
        }

        header("Location: " . BASE_URL . "/?controller=AuthController&method=login");
        exit;
    }

    // Vuelve al formulario de registro conservando lo ya escrito y señalando
    // qué campo hay que corregir. Antes se perdían los cinco campos por
    // equivocarse en uno solo, y había que teclearlo todo de nuevo.
    private function volverAlRegistro(string $mensaje, array $datos = [], ?string $campo = null): void {
        $_SESSION['error'] = $mensaje;
        $_SESSION['registro_datos'] = $datos;

        if ($campo !== null) {
            $_SESSION['registro_campo_error'] = $campo;
        }

        header("Location: " . BASE_URL . "/?controller=AuthController&method=registro");
        exit;
    }

    // =====================================================
    // 1. Mostrar formulario de login
    // =====================================================
    public function login() {

        // Acceso y registro comparten hoja de estilos: son la misma pantalla
        // con distintos campos.
        $cssPagina = "autenticacion";

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
        $this->volverALogin("Acceso no permitido.");
    }

    Csrf::verificarOMorir();

    // 2. Recibir campos
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // 3. Validar campos vacíos
    if (empty($email) || empty($password)) {
        $this->volverALogin("El correo y la contraseña son obligatorios.", $email);
    }

    // 4. Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->volverALogin("Correo electrónico no válido.", $email);
    }

    // 5. Verificar que no haya demasiados intentos fallidos recientes
    //    para esta combinación de IP + correo (protección anti fuerza bruta)
    if (LoginThrottle::bloqueado($email)) {
        $this->volverALogin("Demasiados intentos fallidos. Espera unos minutos e inténtalo de nuevo.", $email);
    }

    // 6. Buscar usuario por email
    $usuario = Usuario::buscarPorEmail($email);

    // 7. Correo inexistente y contraseña incorrecta dan el MISMO mensaje:
    //    distinguirlos permitiría averiguar qué correos están registrados.
    //
    //    Cuando no hay usuario se hace igualmente un hasheo de coste
    //    equivalente. Sin eso, la respuesta llegaría muy por delante en ese
    //    caso, y esa diferencia de tiempo delata exactamente lo mismo que el
    //    mensaje que se acaba de unificar.
    if ($usuario) {
        $credencialesValidas = password_verify($password, $usuario['password']);
    } else {
        password_hash($password, PASSWORD_DEFAULT);
        $credencialesValidas = false;
    }

    if (!$credencialesValidas) {
        LoginThrottle::registrarFallo($email);
        $this->volverALogin("El correo o la contraseña ingresados son incorrectos.", $email);
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

        $cssPagina = "autenticacion";

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
            $this->volverAlRegistro("Se alcanzó el límite de cuentas nuevas desde esta conexión. Inténtalo más tarde.");
        }

        // 2. Recibir los campos
        $nombre = trim($_POST['nombre'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST ['password_confirm'] ?? '';

        // Lo que se devuelve al formulario si algo falla. Nunca las
        // contraseñas: se vuelven a escribir siempre.
        $datos = [
            'nombre' => $nombre,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'email' => $email,
        ];

        // 3. Hacemos la validación de campos vacíos, señalando el primero que
        //    falte para que el formulario pueda marcarlo.
        foreach (['nombre' => $nombre, 'telefono' => $telefono, 'direccion' => $direccion, 'email' => $email] as $campo => $valor) {
            if ($valor === '') {
                $this->volverAlRegistro("Faltan datos por completar.", $datos, $campo);
            }
        }

        if ($password === '' || $password_confirm === '') {
            $this->volverAlRegistro("Escribe la contraseña y su confirmación.", $datos, 'password');
        }

        // 4. Validamos el formato del email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->volverAlRegistro("El correo electrónico no es válido.", $datos, 'email');
        }

        // 4.1 Topes de longitud y formato. Los atributos del formulario HTML
        // se saltan con cualquier cliente que no sea un navegador, así que sin
        // esto se pueden enviar campos de megabytes (llenan la tabla) o
        // contraseñas enormes (cada intento cuesta memoria y CPU al hashear).
        if (mb_strlen($nombre) > 60) {
            $this->volverAlRegistro("El nombre no puede tener más de 60 caracteres.", $datos, 'nombre');
        }

        if (mb_strlen($email) > 255) {
            $this->volverAlRegistro("El correo no puede tener más de 255 caracteres.", $datos, 'email');
        }

        if (mb_strlen($direccion) > 255) {
            $this->volverAlRegistro("La dirección no puede tener más de 255 caracteres.", $datos, 'direccion');
        }

        if (strlen($password) > 72) {
            $this->volverAlRegistro("La contraseña no puede tener más de 72 caracteres.", $datos, 'password');
        }

        // Mismo formato que exige el formulario (0000-0000). Si el servidor
        // aceptara más de lo que la pantalla promete, el aviso que ve el
        // usuario describiría una regla que no es la que se aplica.
        if (!preg_match('/^[0-9]{4}-[0-9]{4}$/', $telefono)) {
            $this->volverAlRegistro("El teléfono debe tener ocho dígitos, con el formato 6031-6975.", $datos, 'telefono');
        }

        // 5. Validamos la contraseña
        if ($password !== $password_confirm){
            $this->volverAlRegistro("Las contraseñas no coinciden.", $datos, 'password');
        }

        // La validación del formulario (minlength/pattern) es solo del lado
        // del cliente y se puede saltar fácilmente; se repite aquí.
        if (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
            $this->volverAlRegistro("La contraseña debe tener al menos 8 caracteres e incluir letras y números.", $datos, 'password');
        }

        // 6. Incluir modelo
        require_once __DIR__ . "/../models/Usuario.php";

        // 7. Validamos si el email ya está registrado
        $existe = Usuario::buscarPorEmail($email);

        if($existe){
            $this->volverAlRegistro("Ese correo ya está registrado. ¿Quieres iniciar sesión?", $datos, 'email');
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

        if (!$creado) {
            $this->volverAlRegistro("Hubo un error al crear tu cuenta. Intenta nuevamente.", $datos);
        }

        Limite::registrar($claveRegistro);

        // El correo se lleva al formulario de acceso ya escrito, para que
        // entrar por primera vez sea un paso y no dos.
        $_SESSION['success'] = "Tu cuenta se creó correctamente. Ya puedes iniciar sesión.";
        $_SESSION['login_email'] = $email;

        header("Location: " . BASE_URL . "/?controller=AuthController&method=login");
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
