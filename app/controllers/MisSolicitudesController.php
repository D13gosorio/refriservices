<?php
require_once ROOT_PATH . "/app/models/Solicitud.php";

class MisSolicitudesController {

    public function index() {

        if (!isset($_SESSION["usuario_id"])) {
            header("Location: " . BASE_URL . "/?controller=AuthController&method=login");
            exit;
        }

        $cssPagina = "mis_solicitudes";

        $solicitudes = Solicitud::obtenerPorUsuario($_SESSION["usuario_id"]);

        include ROOT_PATH . "/app/views/layout/header.php";
        include ROOT_PATH . "/app/views/cliente/mis_solicitudes.php";
        include ROOT_PATH . "/app/views/layout/footer.php";
    }

    public function detalle() {

        if (!isset($_SESSION["usuario_id"])) {
            http_response_code(401);
            die("Debes iniciar sesión.");
        }

        $id = filter_var($_GET["id"] ?? null, FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(404);
            die("Solicitud no encontrada.");
        }

        $solicitud = Solicitud::obtenerPorId($id);

        // Se responde lo mismo tanto si la solicitud no existe como si es de
        // otro cliente: distinguir ambos casos permitiría recorrer los ids y
        // averiguar cuántas solicitudes hay y cuáles existen.
        if (!$solicitud || (int) $solicitud["id_usuario"] !== (int) $_SESSION["usuario_id"]) {
            http_response_code(404);
            die("Solicitud no encontrada.");
        }

        $cssPagina = "mis_solicitudes";

        include ROOT_PATH . "/app/views/layout/header.php";
        include ROOT_PATH . "/app/views/cliente/solicitud_detalle.php";
        include ROOT_PATH . "/app/views/layout/footer.php";
    }

    public function cancelar() {

        if (!isset($_SESSION["usuario_id"])) {
            http_response_code(401);
            die("Debes iniciar sesión.");
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die("Método no permitido.");
        }

        Csrf::verificarOMorir();

        $id = filter_var($_POST["id"] ?? null, FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(404);
            die("Solicitud no encontrada.");
        }

        $solicitud = Solicitud::obtenerPorId($id);

        if (!$solicitud || (int) $solicitud["id_usuario"] !== (int) $_SESSION["usuario_id"]) {
            http_response_code(404);
            die("Solicitud no encontrada.");
        }

        Solicitud::actualizarEstado($id, "Cancelado");

        header("Location: " . BASE_URL . "/?controller=MisSolicitudesController&method=index");
        exit;
    }
}
