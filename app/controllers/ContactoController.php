<?php

class ContactoController {

    public function index() {

        $cssPagina = "contacto";

        include "../app/views/layout/header.php";
        include "../app/views/public/contacto.php";
        include "../app/views/layout/footer.php";
    }
}
