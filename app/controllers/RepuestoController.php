<?php

require_once "../app/models/Repuesto.php";
 
class RepuestoController {

    public function index() {
   
        $cssPagina = "repuestos";

        $repuestos = Repuesto::obtenerTodos();

        include "../app/views/layout/header.php";
        include "../app/views/public/repuestos.php";
        include "../app/views/layout/footer.php";
    }

    public function detalle() {
        
        $cssPagina = "detalle_repuesto";

         if (!isset($_GET['id'])) {
            die("Repuesto no especificado.");
        }

        $id = intval($_GET['id']);
        $repuesto = Repuesto::obtenerPorId($id);

        if (!$repuesto) {
            die("Repuesto no encontrado.");
        }

        include "../app/views/layout/header.php";
        include "../app/views/public/detalle_repuesto.php";
        include "../app/views/layout/footer.php";
    }
}
