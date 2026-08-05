<?php

class HomeController {

    public function index() {
        
        $cssPagina = "inicio";

        include "../app/views/layout/header.php";
        include "../app/views/public/inicio.php";
        include "../app/views/layout/footer.php";
    }
}
