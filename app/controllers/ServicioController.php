<?php

require_once __DIR__ . "/../models/Servicio.php";

class ServicioController {

    public function index() {

        $cssPagina = "servicios";

        // Obtener datos desde la BD
        $servicios = Servicio::obtenerTodos();

        // Cargar layout y vista
        include __DIR__ . "/../views/layout/header.php";
        include __DIR__ . "/../views/public/servicios.php";
        include __DIR__ . "/../views/layout/footer.php";
    }
}

