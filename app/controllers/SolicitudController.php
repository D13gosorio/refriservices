<?php
require_once ROOT_PATH . "/app/models/Servicio.php";
require_once ROOT_PATH . "/app/models/Solicitud.php";

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

        include ROOT_PATH . "/app/views/layout/header.php";
        include ROOT_PATH . "/app/views/cliente/solicitar_servicio.php";
        include ROOT_PATH . "/app/views/layout/footer.php";
    }

    public function guardar() {

        if (!isset($_SESSION["usuario_id"])) {
            header("Location: " . BASE_URL . "/?controller=AuthController&method=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/?controller=ServicioController&method=index");
            exit;
        }

        Csrf::verificarOMorir();

        // El servicio debe existir realmente (evita ids inventados/manipulados).
        $servicio = Servicio::obtenerPorId($_POST['id_servicio'] ?? null);
        if (!$servicio) {
            die("Servicio no encontrado.");
        }

        $cantidad = filter_var($_POST['cantidad'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($cantidad === false) {
            die("Cantidad inválida.");
        }

        $fecha = $_POST['fecha_servicio'] ?? '';
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
            die("Fecha inválida.");
        }

        $data = [
            ':id_usuario' => $_SESSION["usuario_id"],
            ':id_servicio' => $servicio['id'],
            ':cantidad' => $cantidad,
            ':fecha_solicitada' => $fecha,
            ':descripcion' => $_POST['descripcion'] ?? null
        ];

        Solicitud::crear($data);

        header("Location: " . BASE_URL . "/?controller=MisSolicitudesController&method=index");
        exit;
    }
}
