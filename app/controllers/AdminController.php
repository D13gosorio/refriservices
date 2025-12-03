<?php

class AdminController {

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

    // Mostrar formulario vacío (crear)
    public function crearServicio() {
        $cssPagina = "admin_servicio_form";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/servicio_form.php";
        include "../app/views/layout/admin_footer.php";
    }

    // Guardar nuevo servicio
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

    // Cargar datos en el formulario (editar)
    public function editarServicio() {
        require_once "../app/models/Servicio.php";

        $cssPagina = "admin_servicio_form";

        $servicio = Servicio::obtenerPorId($_GET['id']);

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/servicio_form.php";
        include "../app/views/layout/admin_footer.php";
    }

    // Procesa actualización
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

    // Eliminar servicio
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

    /* =======================================================
       GESTIÓN DE SOLICITUDES
    ======================================================= */

    public function solicitudes() {
        $cssPagina = "admin_solicitudes";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/solicitudes.php";
        include "../app/views/layout/admin_footer.php";
    }

    /* =======================================================
       GESTIÓN DE MENSAJES
    ======================================================= */

    public function mensajes() {
        $cssPagina = "admin_mensajes";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/mensajes.php";
        include "../app/views/layout/admin_footer.php";
    }
}
