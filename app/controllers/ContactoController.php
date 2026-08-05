<?php

require_once "../app/models/Mensaje.php";

class ContactoController {

    public function index() {
        $cssPagina = "contacto";

        include "../app/views/layout/header.php";
        include "../app/views/public/contacto.php";
        include "../app/views/layout/footer.php";
    }

    public function enviar() {

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            die("Método no permitido.");
        }

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

        include "../app/views/layout/header.php";
        echo "<section class='texto-centrado' style='padding:2rem;'>
                <h2>¡Mensaje enviado con éxito!</h2>
                <p>Nos pondremos en contacto contigo pronto.</p>
              </section>";
        include "../app/views/layout/footer.php";
    }
}
