<section class="seccion-login">

    <!-- Título -->
    <h1 class="titulo-principal texto-centrado">Iniciar Sesión</h1>

    <!-- Subtítulo -->
    <p class="texto-centrado descripcion-subtitulo">
        Accede a tu cuenta para solicitar servicios o gestionar información.
    </p>

    <!-- Mensajes de error -->
    <?php if (!empty($_GET['error'])): ?>
        <div class="alerta-error">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
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
                   placeholder="ejemplo@correo.com"
                   value="<?= isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '' ?>">
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
