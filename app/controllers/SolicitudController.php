<?php
require_once "../app/models/Servicio.php";
require_once "../app/models/Solicitud.php";

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

        include "../app/views/layout/header.php";
        include "../app/views/cliente/solicitar_servicio.php";
        include "../app/views/layout/footer.php";
    }

    public function guardar() {
        session_start();

        if (!isset($_SESSION["usuario_id"])) {
            die("Debes iniciar sesión para solicitar un servicio.");
        }

        $data = [
            ':id_usuario' => $_SESSION["usuario_id"],
            ':id_servicio' => $_POST['id_servicio'],
            ':cantidad' => $_POST['cantidad'],
            ':fecha_solicitada' => $_POST['fecha_servicio'],
            ':descripcion' => $_POST['descripcion'] ?? null
        ];

        Solicitud::crear($data);

        header("Location: " . BASE_URL . "/?controller=SolicitudController&method=misSolicitudes");
        exit;
    }
}
