<?php

class HomeController {

    public function index() {
        
        $cssPagina = "inicio";

        include __DIR__ . "/../views/layout/header.php";
        include __DIR__ . "/../views/public/inicio.php";
        include __DIR__ . "/../views/layout/footer.php";
    }
}
