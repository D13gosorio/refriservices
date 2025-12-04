<?php

require_once __DIR__ . "/../models/Repuesto.php";
 
class RepuestoController {

    public function index() {
   
        $cssPagina = "repuestos";

        $repuestos = Repuesto::obtenerTodos();

        include __DIR__ . "/../views/layout/header.php";
        include __DIR__ . "/../views/public/repuestos.php";
        include __DIR__ . "/../views/layout/footer.php";
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

        include __DIR__ . "/../views/layout/header.php";
        include __DIR__ . "/../views/public/detalle_repuesto.php";
        include __DIR__ . "/../views/layout/footer.php";
    }
}
