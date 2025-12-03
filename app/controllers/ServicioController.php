<?php

require_once "../app/models/Servicio.php";

class ServicioController {

    public function index() {

        $cssPagina = "servicios";

        // Obtener datos desde la BD
        $servicios = Servicio::obtenerTodos();

        // Cargar layout y vista
        include "../app/views/layout/header.php";
        include "../app/views/public/servicios.php";
        include "../app/views/layout/footer.php";
    }
}

