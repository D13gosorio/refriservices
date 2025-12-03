<?php

class AdminController {

    /* // MÉTODO DE SEGURIDAD
    private function protegerAdmin() {
        session_start();

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: " . BASE_URL . "/?controller=AuthController&method=login");
            exit;
        }
    }
*/
    public function index() {
        // $this->protegerAdmin();

        $cssPagina = "admin_inicio";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/inicio.php";
        include "../app/views/layout/admin_footer.php";
    }

    /* =======================================================
       GESTIÓN DE SERVICIOS
    ======================================================= */

    public function servicios() {
        // $this->protegerAdmin();

        require_once "../app/models/Servicio.php";

        $cssPagina = "admin_servicios";
        $servicios = Servicio::obtenerTodos();

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/servicios.php";
        include "../app/views/layout/admin_footer.php";
    }

    public function crearServicio() {
        // $this->protegerAdmin();

        $cssPagina = "admin_servicio_form";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/servicio_form.php";
        include "../app/views/layout/admin_footer.php";
    }

    public function guardarServicio() {
        // $this->protegerAdmin();

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
        // $this->protegerAdmin();

        require_once "../app/models/Servicio.php";

        $cssPagina = "admin_servicio_form";
        $servicio = Servicio::obtenerPorId($_GET['id']);

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/servicio_form.php";
        include "../app/views/layout/admin_footer.php";
    }

    public function actualizarServicio() {
        // $this->protegerAdmin();

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
        // $this->protegerAdmin();

        require_once "../app/models/Servicio.php";

        Servicio::eliminar($_GET['id']);

        header("Location: " . BASE_URL . "/?controller=AdminController&method=servicios");
        exit;
    }

    /* =======================================================
       GESTIÓN DE REPUESTOS
    ======================================================= */

    public function repuestos() {
        // $this->protegerAdmin();

        require_once "../app/models/Repuesto.php";

        $cssPagina = "admin_repuestos";
        $repuestos = Repuesto::obtenerTodos();

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/repuestos.php";
        include "../app/views/layout/admin_footer.php";
    }

    /* =======================================================
       GESTIÓN DE SOLICITUDES
    ======================================================= */

    public function solicitudes() {
        // $this->protegerAdmin();

        $cssPagina = "admin_solicitudes";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/solicitudes.php";
        include "../app/views/layout/admin_footer.php";
    }

    /* =======================================================
       GESTIÓN DE MENSAJES
    ======================================================= */

    public function mensajes() {
        // $this->protegerAdmin();

        $cssPagina = "admin_mensajes";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/mensajes.php";
        include "../app/views/layout/admin_footer.php";
    }
}
