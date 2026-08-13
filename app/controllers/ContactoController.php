<?php

require_once ROOT_PATH . "/app/models/Mensaje.php";

class ContactoController {

    public function index() {
        $cssPagina = "contacto";

        include ROOT_PATH . "/app/views/layout/header.php";
        include ROOT_PATH . "/app/views/public/contacto.php";
        include ROOT_PATH . "/app/views/layout/footer.php";
    }

    // Opciones del <select> de la vista. El navegador solo deja elegir estas,
    // pero un POST hecho a mano puede traer cualquier cosa.
    private const ASUNTOS_VALIDOS = [
        'Consulta general',
        'Soporte técnico',
        'Información de repuestos',
        'Otro',
    ];

    public function enviar() {

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            http_response_code(405);
            die("Método no permitido.");
        }

        Csrf::verificarOMorir();

        // Tope de mensajes por conexión: el formulario es público y sin límite
        // sirve para inundar la tabla de mensajes y la bandeja del administrador.
        $clave = 'contacto:' . Limite::ip();

        if (Limite::excedido($clave, 5, 60)) {
            http_response_code(429);
            die("Has enviado varios mensajes seguidos. Espera un rato antes de enviar otro.");
        }

        $nombre   = trim($_POST["nombre"] ?? "");
        $correo   = trim($_POST["correo"] ?? "");
        $telefono = trim($_POST["telefono"] ?? "");
        $asunto   = trim($_POST["asunto"] ?? "");
        $mensaje  = trim($_POST["mensaje"] ?? "");

        if ($nombre === "" || $correo === "" || $mensaje === "") {
            http_response_code(400);
            die("Debes completar los campos obligatorios.");
        }

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            die("El correo electrónico no es válido.");
        }

        if (!in_array($asunto, self::ASUNTOS_VALIDOS, true)) {
            http_response_code(400);
            die("Debes elegir un asunto de la lista.");
        }

        if ($telefono !== "" && !preg_match('/^[0-9+()\s.-]{6,30}$/', $telefono)) {
            http_response_code(400);
            die("El teléfono solo puede tener números, espacios y los signos + - ( ) .");
        }

        // Sin topes de longitud se pueden guardar campos de megabytes.
        if (mb_strlen($nombre) > 100 || mb_strlen($correo) > 255 || mb_strlen($mensaje) > 2000) {
            http_response_code(400);
            die("Alguno de los datos ingresados es demasiado largo.");
        }

        Mensaje::crear([
            ":nombre"   => $nombre,
            ":correo"   => $correo,
            ":telefono" => $telefono,
            ":asunto"   => $asunto,
            ":mensaje"  => $mensaje,
        ]);

        Limite::registrar($clave);

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
