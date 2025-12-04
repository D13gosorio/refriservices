<?php
require_once __DIR__ . "/../models/Servicio.php";
require_once __DIR__ . "/../models/Solicitud.php";

class SolicitudController {

    public function formulario() {
        $idServicio = $_GET["id_servicio"] ?? null;

        if (!$idServicio) {
            header("Location: " . BASE_URL . "/?controller=ServicioController&method=index");
            exit;
        }

        // Obtener servicio real
        $servicio = Servicio::obtenerPorId($idServicio);

        if (!$servicio) {
            die("Servicio no encontrado.");
        }

        $cssPagina = "solicitar";

        include __DIR__ . "/../views/layout/header.php";
        include __DIR__ . "/../views/cliente/solicitar_servicio.php";
        include __DIR__ . "/../views/layout/footer.php";
    }

    public function guardar() {
        session_start();

        if (!isset($_SESSION["usuario_id"])) {
            header("Location: " . BASE_URL . "/?controller=AuthController&method=login");
        exit;
            
        }

        $data = [
            ':id_usuario' => $_SESSION["usuario_id"],
            ':id_servicio' => $_POST['id_servicio'],
            ':cantidad' => $_POST['cantidad'],
            ':fecha_solicitada' => $_POST['fecha_servicio'],
            ':descripcion' => $_POST['descripcion'] ?? null
        ];

        Solicitud::crear($data);

        header("Location: " . BASE_URL . "/?controller=MisSolicitudesController&method=index");
        exit;
    }
}
