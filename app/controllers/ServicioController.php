<?php

class ServicioController {

    public function index() {

        $cssPagina = "servicios";

        include "../app/views/layout/header.php";
        include "../app/views/public/servicios.php";
        include "../app/views/layout/footer.php";
    }
}

