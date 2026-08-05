<?php
require_once ROOT_PATH . "/app/models/Solicitud.php";

class AdminController {


    /* =======================================================
    Verificar que el usuario sea admin
    ======================================================= */

    private function verificarAdmin() {
    // Verifica que exista la sesión
    if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['usuario_rol'])) {
        header("Location: " . BASE_URL . "/?controller=AuthController&method=login");
        exit;
    }

    // Verifica que tenga rol admin
    if ($_SESSION['usuario_rol'] !== 'admin') {
        // Opcional: mandar mensaje de error
        $_SESSION['error'] = "No tienes permisos para acceder al área de administración.";
        header("Location: " . BASE_URL);
        exit;
    }
}

    // Verifica que la petición sea POST y que el token CSRF sea válido.
    // Se usa en toda acción que modifica datos (crear/editar/eliminar).
    private function verificarPost() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die("Método no permitido.");
        }
        Csrf::verificarOMorir();
    }


    /* =======================================================
       DASHBOARD
    ======================================================= */
    public function index() {
        $this->verificarAdmin();
        $cssPagina = "admin_inicio";

        include ROOT_PATH . "/app/views/layout/admin_header.php";
        include ROOT_PATH . "/app/views/admin/inicio.php";
        include ROOT_PATH . "/app/views/layout/admin_footer.php";
    }

    /* =======================================================
       GESTIÓN DE SERVICIOS
    ======================================================= */
    public function servicios() {
        $this->verificarAdmin();
        require_once ROOT_PATH . "/app/models/Servicio.php";

        $cssPagina = "admin_servicios";
        $servicios = Servicio::obtenerTodos();

        include ROOT_PATH . "/app/views/layout/admin_header.php";
        include ROOT_PATH . "/app/views/admin/servicios.php";
        include ROOT_PATH . "/app/views/layout/admin_footer.php";
    }

    public function crearServicio() {
        $this->verificarAdmin();
        $cssPagina = "admin_servicio_form";

        include ROOT_PATH . "/app/views/layout/admin_header.php";
        include ROOT_PATH . "/app/views/admin/servicio_form.php";
        include ROOT_PATH . "/app/views/layout/admin_footer.php";
    }

    public function guardarServicio() {
        $this->verificarAdmin();
        $this->verificarPost();
        require_once ROOT_PATH . "/app/models/Servicio.php";

        $data = $this->validarDatosServicio();

        Servicio::crear($data);

        header("Location: " . BASE_URL . "/?controller=AdminController&method=servicios");
        exit;
    }

    public function editarServicio() {
        $this->verificarAdmin();
        require_once ROOT_PATH . "/app/models/Servicio.php";

        $cssPagina = "admin_servicio_form";
        $servicio = Servicio::obtenerPorId($_GET['id'] ?? null);

        if (!$servicio) die("Servicio no encontrado.");

        include ROOT_PATH . "/app/views/layout/admin_header.php";
        include ROOT_PATH . "/app/views/admin/servicio_form.php";
        include ROOT_PATH . "/app/views/layout/admin_footer.php";
    }

    public function actualizarServicio() {
        $this->verificarAdmin();
        $this->verificarPost();
        require_once ROOT_PATH . "/app/models/Servicio.php";

        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id) die("ID inválido.");

        $data = $this->validarDatosServicio();
        $data[':id'] = $id;

        Servicio::actualizar($data);

        header("Location: " . BASE_URL . "/?controller=AdminController&method=servicios");
        exit;
    }

    public function eliminarServicio() {
        $this->verificarAdmin();
        $this->verificarPost();
        require_once ROOT_PATH . "/app/models/Servicio.php";

        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id) die("ID inválido.");

        Servicio::eliminar($id);

        header("Location: " . BASE_URL . "/?controller=AdminController&method=servicios");
        exit;
    }

    // Valida y normaliza los campos del formulario de servicio (crear/editar).
    private function validarDatosServicio(): array {
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio = filter_var($_POST['precio'] ?? null, FILTER_VALIDATE_FLOAT, ['options' => ['min_range' => 0]]);

        if ($nombre === '' || $descripcion === '' || $precio === false) {
            die("Datos del servicio inválidos.");
        }

        return [
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':precio' => $precio,
        ];
    }

    /* =======================================================
       GESTIÓN DE REPUESTOS
    ======================================================= */
    public function repuestos() {
        $this->verificarAdmin();
        require_once ROOT_PATH . "/app/models/Repuesto.php";

        $cssPagina = "admin_repuestos";
        $repuestos = Repuesto::obtenerTodos();

        include ROOT_PATH . "/app/views/layout/admin_header.php";
        include ROOT_PATH . "/app/views/admin/repuestos.php";
        include ROOT_PATH . "/app/views/layout/admin_footer.php";
    }

    // Formulario de crear repuestos
    public function crearRepuesto() {
        $this->verificarAdmin();
        require_once ROOT_PATH . "/app/models/Repuesto.php";

        $cssPagina = "admin_repuesto_form";
        $repuesto = null; // formulario vacío

        include ROOT_PATH . "/app/views/layout/admin_header.php";
        include ROOT_PATH . "/app/views/admin/repuesto_form.php";
        include ROOT_PATH . "/app/views/layout/admin_footer.php";
    }

    //Guardar repuesto
    public function guardarRepuesto() {
        $this->verificarAdmin();
        $this->verificarPost();
        require_once ROOT_PATH . "/app/models/Repuesto.php";

        $data = $this->validarDatosRepuesto();

        Repuesto::crear($data);

        header("Location: " . BASE_URL . "/?controller=AdminController&method=repuestos");
        exit;
    }

    //Editar repuesto
    public function editarRepuesto() {
        $this->verificarAdmin();
        require_once ROOT_PATH . "/app/models/Repuesto.php";

        $cssPagina = "admin_repuesto_form";
        $repuesto = Repuesto::obtenerPorId($_GET['id'] ?? null);

        if (!$repuesto) die("Repuesto no encontrado.");

        include ROOT_PATH . "/app/views/layout/admin_header.php";
        include ROOT_PATH . "/app/views/admin/repuesto_form.php";
        include ROOT_PATH . "/app/views/layout/admin_footer.php";
    }

    // Actualizar repuesto
    public function actualizarRepuesto() {
        $this->verificarAdmin();
        $this->verificarPost();
        require_once ROOT_PATH . "/app/models/Repuesto.php";

        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id) die("ID inválido.");

        $data = $this->validarDatosRepuesto();
        $data[':id'] = $id;

        Repuesto::actualizar($data);

        header("Location: " . BASE_URL . "/?controller=AdminController&method=repuestos");
        exit;
    }

    // Eliminar repuesto
    public function eliminarRepuesto() {
        $this->verificarAdmin();
        $this->verificarPost();
        require_once ROOT_PATH . "/app/models/Repuesto.php";

        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id) die("ID inválido.");

        Repuesto::eliminar($id);

        header("Location: " . BASE_URL . "/?controller=AdminController&method=repuestos");
        exit;
    }

    // Valida y normaliza los campos del formulario de repuesto (crear/editar).
    // La "imagen" puede ser un nombre de archivo local o una URL http(s); se
    // rechaza cualquier otro esquema (por ejemplo "javascript:") por prudencia.
    private function validarDatosRepuesto(): array {
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio = filter_var($_POST['precio'] ?? null, FILTER_VALIDATE_FLOAT, ['options' => ['min_range' => 0]]);
        $stock = filter_var($_POST['stock'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
        $imagen = trim($_POST['imagen'] ?? '') ?: 'default.jpg';

        if ($nombre === '' || $descripcion === '' || $precio === false || $stock === false) {
            die("Datos del repuesto inválidos.");
        }

        $esUrlSegura = preg_match('/^https?:\/\//i', $imagen) === 1;
        $esNombreArchivo = preg_match('/^[A-Za-z0-9._-]+$/', $imagen) === 1;

        if (!$esUrlSegura && !$esNombreArchivo) {
            die("Nombre de imagen inválido.");
        }

        return [
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':precio' => $precio,
            ':stock' => $stock,
            ':imagen' => $imagen,
        ];
    }


    /* =======================================================
       GESTIÓN DE SOLICITUDES
    ======================================================= */
    public function solicitudes() {
        $this->verificarAdmin();
        require_once ROOT_PATH . "/app/models/Solicitud.php";

        $cssPagina = "admin_solicitudes";
        $solicitudes = Solicitud::obtenerTodas();

        include ROOT_PATH . "/app/views/layout/admin_header.php";
        include ROOT_PATH . "/app/views/admin/solicitudes.php";
        include ROOT_PATH . "/app/views/layout/admin_footer.php";
    }

    public function actualizarSolicitud() {
        $this->verificarAdmin();
        $this->verificarPost();
        require_once ROOT_PATH . "/app/models/Solicitud.php";

        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id) die("ID inválido.");

        $estadosValidos = ['Pendiente', 'En proceso', 'Finalizado', 'Cancelado'];
        $estado = $_POST['estado'] ?? '';
        if (!in_array($estado, $estadosValidos, true)) {
            die("Estado inválido.");
        }

        $fecha_programada = $_POST['fecha_programada'] ?? null;
        if (!empty($fecha_programada) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_programada)) {
            die("Fecha inválida.");
        }

        Solicitud::actualizarEstado($id, $estado);

        if (!empty($fecha_programada)) {
            Solicitud::actualizarFechaProgramada($id, $fecha_programada);
        }

        header("Location: " . BASE_URL . "/?controller=AdminController&method=solicitudes");
        exit;
    }

    public function eliminarSolicitud() {
        $this->verificarAdmin();
        $this->verificarPost();
        require_once ROOT_PATH . "/app/models/Solicitud.php";

        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id) die("ID inválido.");

        Solicitud::eliminar($id);

        header("Location: " . BASE_URL . "/?controller=AdminController&method=solicitudes");
        exit;
    }

    /* =======================================================
       GESTIÓN DE MENSAJES
    ======================================================= */
    public function mensajes() {
        $this->verificarAdmin();
        require_once ROOT_PATH . "/app/models/Mensaje.php";

        $mensajes = Mensaje::obtenerTodos();
        $cssPagina = "admin_mensajes";

        include ROOT_PATH . "/app/views/layout/admin_header.php";
        include ROOT_PATH . "/app/views/admin/mensajes.php";
        include ROOT_PATH . "/app/views/layout/admin_footer.php";
    }

    public function eliminarMensaje() {
        $this->verificarAdmin();
        $this->verificarPost();
        require_once ROOT_PATH . "/app/models/Mensaje.php";

        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id) die("ID inválido.");

        Mensaje::eliminar($id);

        header("Location: " . BASE_URL . "/?controller=AdminController&method=mensajes");
        exit;
    }
}
