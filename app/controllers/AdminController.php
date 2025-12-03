<?php
require_once "../app/models/Solicitud.php";

class AdminController {

    /* =======================================================
       DASHBOARD
    ======================================================= */
    public function index() {
        $cssPagina = "admin_inicio";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/inicio.php";
        include "../app/views/layout/admin_footer.php";
    }

    /* =======================================================
       GESTIÓN DE SERVICIOS
    ======================================================= */
    public function servicios() {
        require_once "../app/models/Servicio.php";

        $cssPagina = "admin_servicios";
        $servicios = Servicio::obtenerTodos();

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/servicios.php";
        include "../app/views/layout/admin_footer.php";
    }

    public function crearServicio() {
        $cssPagina = "admin_servicio_form";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/servicio_form.php";
        include "../app/views/layout/admin_footer.php";
    }

    public function guardarServicio() {
        require_once "../app/models/Servicio.php";

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
        require_once "../app/models/Servicio.php";

        $cssPagina = "admin_servicio_form";
        $servicio = Servicio::obtenerPorId($_GET['id']);

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/servicio_form.php";
        include "../app/views/layout/admin_footer.php";
    }

    public function actualizarServicio() {
        require_once "../app/models/Servicio.php";

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
        require_once "../app/models/Servicio.php";

        Servicio::eliminar($_GET['id']);

        header("Location: " . BASE_URL . "/?controller=AdminController&method=servicios");
        exit;
    }

    /* =======================================================
       GESTIÓN DE REPUESTOS
    ======================================================= */
    public function repuestos() {
        require_once "../app/models/Repuesto.php";

        $cssPagina = "admin_repuestos";
        $repuestos = Repuesto::obtenerTodos();

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/repuestos.php";
        include "../app/views/layout/admin_footer.php";
    }   

    // Formulario de crear repuestos
    public function crearRepuesto() {
    require_once "../app/models/Repuesto.php";

    $cssPagina = "admin_repuesto_form";
    $repuesto = null; // formulario vacío

    include "../app/views/layout/admin_header.php";
    include "../app/views/admin/repuesto_form.php";
    include "../app/views/layout/admin_footer.php";
    }

    //Guardar repuesto
    public function guardarRepuesto() {
    require_once "../app/models/Repuesto.php";

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
    require_once "../app/models/Repuesto.php";

    $cssPagina = "admin_repuesto_form";
    $repuesto = Repuesto::obtenerPorId($_GET['id']);

    include "../app/views/layout/admin_header.php";
    include "../app/views/admin/repuesto_form.php";
    include "../app/views/layout/admin_footer.php";
    }

    // Actualizar repuesto
    public function actualizarRepuesto() {
    require_once "../app/models/Repuesto.php";

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
    require_once "../app/models/Repuesto.php";

    Repuesto::eliminar($_GET['id']);

    header("Location: " . BASE_URL . "/?controller=AdminController&method=repuestos");
    exit;
    }


    /* =======================================================
       GESTIÓN DE SOLICITUDES
    ======================================================= */
    public function solicitudes() {
        require_once "../app/models/Solicitud.php";

        $cssPagina = "admin_solicitudes";
        $solicitudes = Solicitud::obtenerTodas();

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/solicitudes.php";
        include "../app/views/layout/admin_footer.php";
    }

    public function actualizarSolicitud() {
        require_once "../app/models/Solicitud.php";

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
        require_once "../app/models/Solicitud.php";

        $id = $_GET['id'];
        Solicitud::eliminar($id);

        header("Location: " . BASE_URL . "/?controller=AdminController&method=solicitudes");
        exit;
    }

    /* =======================================================
       GESTIÓN DE MENSAJES
    ======================================================= */
    public function mensajes() {
        require_once "../app/models/Mensaje.php";

        $mensajes = Mensaje::obtenerTodos();
        $cssPagina = "admin_mensajes";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/mensajes.php";
        include "../app/views/layout/admin_footer.php";
    }

    public function eliminarMensaje() {
        require_once "../app/models/Mensaje.php";

        $id = $_GET["id"] ?? null;
        if (!$id) die("ID inválido");

        Mensaje::eliminar($id);

        header("Location: " . BASE_URL . "/?controller=AdminController&method=mensajes");
        exit;
    }
}
