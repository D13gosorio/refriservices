<?php

class NosotrosController {

    public function index() {
        
        $cssPagina = "nosotros";

        include __DIR__ . "/../views/layout/header.php";
        include __DIR__ . "/../views/public/nosotros.php";
        include __DIR__ . "/../views/layout/footer.php";
    }
}
