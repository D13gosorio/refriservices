<?php

require_once ROOT_PATH . "/app/models/Mensaje.php";

class ContactoController {

    public function index() {
        $cssPagina = "contacto";

        include ROOT_PATH . "/app/views/layout/header.php";
        include ROOT_PATH . "/app/views/public/contacto.php";
        include ROOT_PATH . "/app/views/layout/footer.php";
    }

    public function enviar() {

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            die("Método no permitido.");
        }

        Csrf::verificarOMorir();

        // Validar campos
        $data = [
            ":nombre"   => $_POST["nombre"] ?? "",
            ":correo"   => $_POST["correo"] ?? "",
            ":telefono" => $_POST["telefono"] ?? "",
            ":asunto"   => $_POST["asunto"] ?? "",
            ":mensaje"  => $_POST["mensaje"] ?? ""
        ];

        if (empty($data[":nombre"]) || empty($data[":correo"]) || empty($data[":mensaje"])) {
            die("Debes completar los campos obligatorios.");
        }

        Mensaje::crear($data);

        header("Location: " . BASE_URL . "/?controller=ContactoController&method=gracias");
        exit;
    }

    public function gracias() {
        $cssPagina = "contacto";

        include ROOT_PATH . "/app/views/layout/header.php";
        include ROOT_PATH . "/app/views/public/contacto_gracias.php";
        include ROOT_PATH . "/app/views/layout/footer.php";
    }
}
