<?php

class RepuestoController {

    public function index() {
   
        $cssPagina = "repuestos";

        include "../app/views/layout/header.php";
        include "../app/views/public/repuestos.php";
        include "../app/views/layout/footer.php";
    }

    public function detalle() {
        
        $cssPagina = "detalle_repuesto";

        include "../app/views/layout/header.php";
        include "../app/views/public/detalle_repuesto.php";
        include "../app/views/layout/footer.php";
    }
}
