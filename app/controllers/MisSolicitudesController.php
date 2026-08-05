<?php
require_once "../app/models/Solicitud.php";

class MisSolicitudesController {

    public function index() {
        session_start();

        if (!isset($_SESSION["usuario_id"])) {
            header("Location: " . BASE_URL . "/?controller=AuthController&method=login");
            exit;
        }

        $cssPagina = "mis_solicitudes";

        $solicitudes = Solicitud::obtenerPorUsuario($_SESSION["usuario_id"]);

        include "../app/views/layout/header.php";
        include "../app/views/cliente/mis_solicitudes.php";
        include "../app/views/layout/footer.php";
    }

    public function detalle() {
        session_start();

        if (!isset($_SESSION["usuario_id"])) {
            die("Debes iniciar sesión.");
        }

        $id = $_GET["id"] ?? null;

        if (!$id) die("Solicitud no encontrada.");

        $solicitud = Solicitud::obtenerPorId($id);

        if (!$solicitud) die("Solicitud no encontrada.");
        if ($solicitud["id_usuario"] != $_SESSION["usuario_id"]) die("Acceso denegado.");

        $cssPagina = "mis_solicitudes";

        include "../app/views/layout/header.php";
        include "../app/views/cliente/solicitud_detalle.php";
        include "../app/views/layout/footer.php";
    }

    public function cancelar() {
        session_start();

        if (!isset($_SESSION["usuario_id"])) die("Debes iniciar sesión.");

        $id = $_GET["id"] ?? null;
        if (!$id) die("Solicitud no encontrada.");

        $solicitud = Solicitud::obtenerPorId($id);

        if ($solicitud["id_usuario"] != $_SESSION["usuario_id"]) {
            die("Acceso denegado.");
        }

        Solicitud::actualizarEstado($id, "Cancelado");

        header("Location: " . BASE_URL . "/?controller=MisSolicitudesController&method=index");
        exit;
    }
}
