<?php
require_once ROOT_PATH . "/app/models/Servicio.php";
require_once ROOT_PATH . "/app/models/Repuesto.php";

class HomeController {

    public function index() {

        $cssPagina = "inicio";

        // Vitrina: primeros 3 servicios y 4 repuestos del catálogo real.
        $serviciosDestacados = array_slice(Servicio::obtenerTodos(), 0, 3);
        $repuestosDestacados = array_slice(Repuesto::obtenerTodos(), 0, 4);

        include ROOT_PATH . "/app/views/layout/header.php";
        include ROOT_PATH . "/app/views/public/inicio.php";
        include ROOT_PATH . "/app/views/layout/footer.php";
    }
}
