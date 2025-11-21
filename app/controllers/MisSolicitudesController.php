<?php

class MisSolicitudesController {

    public function index() {
        
        $cssPagina = "mis_solicitudes";

        include "../app/views/layout/header.php";
        include "../app/views/cliente/mis_solicitudes.php";
        include "../app/views/layout/footer.php";
    }
}
