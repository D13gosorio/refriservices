<?php

class SolicitudController {

    public function formulario() {

        // 1. Recibir ID del servicio desde la URL
        $idServicio = $_GET["id_servicio"] ?? null;

        // 2. Validar si existe
        if (!$idServicio) {
            // Si no viene id, redirige a servicios
            header("Location: " . BASE_URL . "/?controller=ServicioController&method=index");
            exit;
        }

        // 3. Aquí más adelante buscaremos el servicio en la BD.
        // Por ahora lo dejamos estático hasta que conectemos el backend.
        $servicio = [
            "nombre" => "Nombre del servicio",
            "precio" => "00.00"
        ];

        //Cargar el CSS específico de esta página
        $cssPagina = "solicitar";

    
        include "../app/views/layout/header.php";
        include "../app/views/cliente/solicitar_servicio.php";
        include "../app/views/layout/footer.php";
    }
}

