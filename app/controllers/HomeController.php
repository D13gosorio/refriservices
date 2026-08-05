<?php

class HomeController {

    public function index() {

        $cssPagina = "inicio";

        include ROOT_PATH . "/app/views/layout/header.php";
        include ROOT_PATH . "/app/views/public/inicio.php";
        include ROOT_PATH . "/app/views/layout/footer.php";
    }
}
