<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<section class="seccion-login">

    <!-- Título -->
    <h1 class="titulo-principal texto-centrado">Iniciar Sesión</h1>

    <!-- Subtítulo -->
    <p class="texto-centrado descripcion-subtitulo">
        Accede a tu cuenta para solicitar servicios o gestionar información.
    </p>

    <!-- Mensaje de error -->
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alerta-error">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Mensaje de éxito -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alerta-exito">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- FORMULARIO -->
    <form method="POST"
          action="<?= BASE_URL ?>/?controller=AuthController&method=doLogin"
          class="formulario-login">

        <!-- Email -->
        <div class="grupo-formulario">
            <label for="email">Correo electrónico:</label>

            <input type="email"
                   id="email"
                   name="email"
                   required
                   placeholder="ejemplo@correo.com">
        </div>

        <!-- Contraseña -->
        <div class="grupo-formulario">
            <label for="password">Contraseña:</label>

            <input type="password"
                   id="password"
                   name="password"
                   required
                   placeholder="********">
        </div>

        <!-- Botón -->
        <div class="texto-centrado">
            <button type="submit" class="boton-naranja">
                Iniciar Sesión
            </button>
        </div>
    </form>

    <!-- Enlace a registro -->
    <p class="texto-centrado enlace-registro">
        ¿No tienes cuenta?
        <a href="<?= BASE_URL ?>/?controller=AuthController&method=registro" class="enlace-azul">
            Regístrate aquí
        </a>
    </p>

</section>
