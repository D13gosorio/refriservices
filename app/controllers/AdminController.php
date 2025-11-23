<?php

class AdminController {

    public function index() {
        $cssPagina = "admin_inicio";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/inicio.php";
    }

    public function servicios() {
        $cssPagina = "admin_servicios";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/servicios.php";
    }

    public function repuestos() {
        $cssPagina = "admin_repuestos";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/repuestos.php";
    }

    public function solicitudes() {
        $cssPagina = "admin_solicitudes";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/solicitudes.php";
    }

    public function mensajes() {
        $cssPagina = "admin_mensajes";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/mensajes.php";
    }
}
