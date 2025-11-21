<?php

class NosotrosController {

    public function index() {
        
        $cssPagina = "nosotros";

        include "../app/views/layout/header.php";
        include "../app/views/public/nosotros.php";
        include "../app/views/layout/footer.php";
    }
}
