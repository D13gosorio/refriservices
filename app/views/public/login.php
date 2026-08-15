<?php
// La sesión ya se inicia en config.php antes de renderizar cualquier vista.

// Correo del intento anterior, para no obligar a reescribirlo tras un fallo.
// La contraseña nunca se recuerda.
$emailPrevio = $_SESSION['login_email'] ?? '';
unset($_SESSION['login_email']);
?>

<section class="seccion-auth">

    <h1 class="titulo-principal texto-centrado">Iniciar sesión</h1>

    <p class="texto-centrado descripcion-subtitulo">
        Accede a tu cuenta para solicitar servicios y seguir tus solicitudes.
    </p>

    <?php if (!empty($_SESSION['error'])): ?>
        <!-- role="alert" hace que un lector de pantalla lo anuncie al cargar
             la página; sin él, el aviso pasa desapercibido. -->
        <div class="alerta-error" role="alert">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alerta-exito" role="status">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <form method="POST"
          action="<?= BASE_URL ?>/?controller=AuthController&method=doLogin"
          class="formulario-auth">

        <?= Csrf::field() ?>

        <div class="grupo-formulario">
            <label for="email">Correo electrónico</label>
            <!-- autocomplete deja que el navegador y el gestor de contraseñas
                 rellenen el campo; autofocus pone el cursor donde toca. -->
            <input type="email"
                   id="email"
                   name="email"
                   value="<?= htmlspecialchars($emailPrevio, ENT_QUOTES, 'UTF-8') ?>"
                   required
                   maxlength="255"
                   autocomplete="email"
                   autofocus
                   placeholder="ejemplo@correo.com">
        </div>

        <div class="grupo-formulario">
            <label for="password">Contraseña</label>
            <div class="campo-password">
                <input type="password"
                       id="password"
                       name="password"
                       required
                       autocomplete="current-password"
                       placeholder="Tu contraseña">
            </div>
        </div>

        <button type="submit" class="boton-naranja">Iniciar sesión</button>
    </form>

    <p class="enlace-auth">
        ¿No tienes cuenta?
        <a href="<?= BASE_URL ?>/?controller=AuthController&method=registro">Crea una aquí</a>
    </p>

</section>

<script src="<?= BASE_URL ?>/assets/js/autenticacion.js"></script>
