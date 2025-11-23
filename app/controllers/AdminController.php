<?php

class AdminController {

    public function index() {
        $cssPagina = "admin_inicio";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/inicio.php";
        include "../app/views/layout/admin_footer.php";
    }

    public function servicios() {
        $cssPagina = "admin_servicios";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/servicios.php";
        include "../app/views/layout/admin_footer.php";
    }

    public function repuestos() {
        $cssPagina = "admin_repuestos";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/repuestos.php";
        include "../app/views/layout/admin_footer.php";
    }

    public function solicitudes() {
        $cssPagina = "admin_solicitudes";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/solicitudes.php";
        include "../app/views/layout/admin_footer.php";
    }

    public function mensajes() {
        $cssPagina = "admin_mensajes";

        include "../app/views/layout/admin_header.php";
        include "../app/views/admin/mensajes.php";
        include "../app/views/layout/admin_footer.php";
    }
}
