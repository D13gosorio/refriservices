<?php

class NosotrosController {

    public function index() {
        
        $cssPagina = "nosotros";

        include ROOT_PATH . "/app/views/layout/header.php";
        include ROOT_PATH . "/app/views/public/nosotros.php";
        include ROOT_PATH . "/app/views/layout/footer.php";
    }
}
