<section class="seccion-login">
    <h1 class="titulo-principal texto-centrado">Iniciar Sesión</h1>

    <p class="texto-centrado descripcion-subtitulo">
        Accede a tu cuenta para solicitar servicios o gestionar información.
    </p>

    <form method="POST" action="<?= BASE_URL ?>/?controller=AuthController&method=doLogin"
          class="formulario-login">

        <div class="grupo-formulario">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email"
                   required placeholder="ejemplo@correo.com">
        </div>

        <div class="grupo-formulario">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password"
                   required placeholder="********">
        </div>

        <div class="texto-centrado">
            <button type="submit" class="boton-naranja">
                Iniciar Sesión
            </button>
        </div>
    </form>

    <p class="texto-centrado enlace-registro">
        ¿No tienes una cuenta?
        <a href="<?= BASE_URL ?>/?controller=AuthController&method=registro"
           class="enlace-azul">
           Regístrate aquí
        </a>
    </p>
</section>
