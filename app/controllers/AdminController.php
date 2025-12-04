<?php
require_once __DIR__ . "/../models/Servicio.php";

class AdminController {


    /* =======================================================
    Verificar que el usuario sea admin
    ======================================================= */

    private function verificarAdmin() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

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


    /* =======================================================
       DASHBOARD
    ======================================================= */
    public function index() {
        $this->verificarAdmin();
        $cssPagina = "admin_inicio";

        include __DIR__ . "/../views/layout/admin_header.php";
        include __DIR__ . "/../views/admin/inicio.php";
        include __DIR__ . "/../views/layout/admin_footer.php";
    }

    /* =======================================================
       GESTIÓN DE SERVICIOS
    ======================================================= */
    public function servicios() {
        $this->verificarAdmin();
        require_once __DIR__ . "/../models/Servicio.php";

        $cssPagina = "admin_servicios";
        $servicios = Servicio::obtenerTodos();

        include __DIR__ . "/../views/layout/admin_header.php";
        include __DIR__ . "/../views/admin/servicios.php";
        include __DIR__ . "/../views/layout/admin_footer.php";
    }

    public function crearServicio() {
        $this->verificarAdmin();
        $cssPagina = "admin_servicio_form";

        include __DIR__ . "/../views/layout/admin_header.php";
        include __DIR__ . "/../views/admin/servicio_form.php";
        include __DIR__ . "/../views/layout/admin_footer.php";
    }

    public function guardarServicio() {
        $this->verificarAdmin();
        require_once __DIR__ . "/../models/Servicio.php";

        $data = [
            ':nombre' => $_POST['nombre'],
            ':descripcion' => $_POST['descripcion'],
            ':precio' => $_POST['precio']
        ];

        Servicio::crear($data);

        header("Location: " . BASE_URL . "/?controller=AdminController&method=servicios");
        exit;
    }

    public function editarServicio() {
        $this->verificarAdmin();
        require_once __DIR__ . "/../models/Servicio.php";

        $cssPagina = "admin_servicio_form";
        $servicio = Servicio::obtenerPorId($_GET['id']);

        include __DIR__ . "/../views/layout/admin_header.php";
        include __DIR__ . "/../views/admin/servicio_form.php";
        include __DIR__ . "/../views/layout/admin_footer.php";
    }

    public function actualizarServicio() {
        $this->verificarAdmin();
        require_once __DIR__ . "/../models/Servicio.php";

        $data = [
            ':id' => $_POST['id'],
            ':nombre' => $_POST['nombre'],
            ':descripcion' => $_POST['descripcion'],
            ':precio' => $_POST['precio']
        ];

        Servicio::actualizar($data);

        header("Location: " . BASE_URL . "/?controller=AdminController&method=servicios");
        exit;
    }

    public function eliminarServicio() {
        $this->verificarAdmin();
        require_once __DIR__ . "/../models/Servicio.php";

        Servicio::eliminar($_GET['id']);

        header("Location: " . BASE_URL . "/?controller=AdminController&method=servicios");
        exit;
    }

    /* =======================================================
       GESTIÓN DE REPUESTOS
    ======================================================= */
    public function repuestos() {
        $this->verificarAdmin();
        require_once __DIR__ . "/../models/Repuesto.php";

        $cssPagina = "admin_repuestos";
        $repuestos = Repuesto::obtenerTodos();

        include __DIR__ . "/../views/layout/admin_header.php";
        include __DIR__ . "/../views/admin/repuestos.php";
        include __DIR__ . "/../views/layout/admin_footer.php";
    }   

    // Formulario de crear repuestos
    public function crearRepuesto() {
        $this->verificarAdmin();
    require_once __DIR__ . "/../models/Repuesto.php";

    $cssPagina = "admin_repuesto_form";
    $repuesto = null; // formulario vacío

    include __DIR__ . "/../views/layout/admin_header.php";
    include __DIR__ . "/../views/admin/repuesto_form.php";
    include __DIR__ . "/../views/layout/admin_footer.php";
    }

    //Guardar repuesto
    public function guardarRepuesto() {
        $this->verificarAdmin();
    require_once __DIR__ . "/../models/Repuesto.php";

    $data = [
        ':nombre' => $_POST['nombre'],
        ':descripcion' => $_POST['descripcion'],
        ':precio' => $_POST['precio'],
        ':stock' => $_POST['stock'],
        ':imagen' => $_POST['imagen'] ?? 'default.jpg'
    ];

    Repuesto::crear($data);

    header("Location: " . BASE_URL . "/?controller=AdminController&method=repuestos");
    exit;
    }

    //Editar repuesto
    public function editarRepuesto() {
        $this->verificarAdmin();
    require_once __DIR__ . "/../models/Repuesto.php";

    $cssPagina = "admin_repuesto_form";
    $repuesto = Repuesto::obtenerPorId($_GET['id']);

    include __DIR__ . "/../views/layout/admin_header.php";
    include __DIR__ . "/../views/admin/repuesto_form.php";
    include __DIR__ . "/../views/layout/admin_footer.php";
    }

    // Actualizar repuesto
    public function actualizarRepuesto() {
        $this->verificarAdmin();
    require_once __DIR__ . "/../models/Repuesto.php";

    $data = [
        ':id' => $_POST['id'],
        ':nombre' => $_POST['nombre'],
        ':descripcion' => $_POST['descripcion'],
        ':precio' => $_POST['precio'],
        ':stock' => $_POST['stock'],
        ':imagen' => $_POST['imagen']
    ];

    Repuesto::actualizar($data);

    header("Location: " . BASE_URL . "/?controller=AdminController&method=repuestos");
    exit;
    }

    // Eliminar repuesto
    public function eliminarRepuesto() {
        $this->verificarAdmin();
    require_once __DIR__ . "/../models/Repuesto.php";

    Repuesto::eliminar($_GET['id']);

    header("Location: " . BASE_URL . "/?controller=AdminController&method=repuestos");
    exit;
    }


    /* =======================================================
       GESTIÓN DE SOLICITUDES
    ======================================================= */
    public function solicitudes() {
        $this->verificarAdmin();
        require_once __DIR__ . "/../models/Servicio.php";

        $cssPagina = "admin_solicitudes";
        $solicitudes = Solicitud::obtenerTodas();

        include __DIR__ . "/../views/layout/admin_header.php";
        include __DIR__ . "/../views/admin/solicitudes.php";
        include __DIR__ . "/../views/layout/admin_footer.php";
    }

    public function actualizarSolicitud() {
        $this->verificarAdmin();
        require_once __DIR__ . "/../models/Servicio.php";

        $id = $_POST['id'];
        $estado = $_POST['estado'];
        $fecha_programada = $_POST['fecha_programada'] ?? null;

        Solicitud::actualizarEstado($id, $estado);

        if (!empty($fecha_programada)) {
            Solicitud::actualizarFechaProgramada($id, $fecha_programada);
        }

        header("Location: " . BASE_URL . "/?controller=AdminController&method=solicitudes");
        exit;
    }

    public function eliminarSolicitud() {
        $this->verificarAdmin();
        require_once __DIR__ . "/../models/Servicio.php";

        $id = $_GET['id'];
        Solicitud::eliminar($id);

        header("Location: " . BASE_URL . "/?controller=AdminController&method=solicitudes");
        exit;
    }

    /* =======================================================
       GESTIÓN DE MENSAJES
    ======================================================= */
    public function mensajes() {
        $this->verificarAdmin();
        require_once __DIR__ . "/../models/Mensaje.php";

        $mensajes = Mensaje::obtenerTodos();
        $cssPagina = "admin_mensajes";

        include __DIR__ . "/../views/layout/admin_header.php";
        include __DIR__ . "/../views/admin/mensajes.php";
        include __DIR__ . "/../views/layout/admin_footer.php";
    }

    public function eliminarMensaje() {
        $this->verificarAdmin();
        require_once __DIR__ . "/../models/Mensaje.php";

        $id = $_GET["id"] ?? null;
        if (!$id) die("ID inválido");

        Mensaje::eliminar($id);

        header("Location: " . BASE_URL . "/?controller=AdminController&method=mensajes");
        exit;
    }
}
