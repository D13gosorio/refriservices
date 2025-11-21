<?php

class AuthController {

    // =====================================================
    // 1. Mostrar formulario de login
    // =====================================================
    public function login() {

        // CSS específico de esta vista
        $cssPagina = "login";

        include "../app/views/layout/header.php";
        include "../app/views/public/login.php";
        include "../app/views/layout/footer.php";
    }

    // =====================================================
    // 2. Procesar login (aún sin backend)
    // =====================================================
    public function doLogin() {

        // Más adelante: validar correo/contraseña con BD
        echo "Procesando login (todavía sin backend)";
    }

    // =====================================================
    // 3. Mostrar formulario de registro
    // =====================================================
    public function registro() {

        // CSS específico de esta vista
        $cssPagina = "registro";

        include "../app/views/layout/header.php";
        include "../app/views/public/registro.php";
        include "../app/views/layout/footer.php";
    }

    // =====================================================
    // 4. Cerrar sesión
    // =====================================================
    public function logout() {

        session_start();
        session_destroy();

        header("Location: " . BASE_URL . "/");
        exit;
    }
}
