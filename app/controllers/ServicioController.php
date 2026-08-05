<?php

require_once ROOT_PATH . "/app/models/Servicio.php";

class ServicioController {

    public function index() {

        $cssPagina = "servicios";

        // Obtener datos desde la BD
        $servicios = Servicio::obtenerTodos();

        // Cargar layout y vista
        include ROOT_PATH . "/app/views/layout/header.php";
        include ROOT_PATH . "/app/views/public/servicios.php";
        include ROOT_PATH . "/app/views/layout/footer.php";
    }
}

