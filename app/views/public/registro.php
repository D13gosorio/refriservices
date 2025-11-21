<section class="seccion-registro">
    <h1 class="titulo-principal texto-centrado">Crear Cuenta</h1>

    <p class="texto-centrado descripcion-subtitulo">
        Regístrate para solicitar servicios, acceder a tu historial y enviar mensajes de contacto.
    </p>

    <form method="POST"
          action="<?= BASE_URL ?>/?controller=AuthController&method=doRegistro"
          class="formulario-registro">

        <!-- Nombre -->
        <div class="grupo-formulario">
            <label for="nombre">Nombre completo:</label>
            <input type="text" id="nombre" name="nombre"
                   required placeholder="Tu nombre aquí">
        </div>

               <!-- Teléfono -->
        <div class="grupo-formulario">
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono"
                   required placeholder="XXXX-XXXX">
        </div>

                <!-- Dirección -->
        <div class="grupo-formulario">
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion"
                   required placeholder="Ej: Barrio X, Calle Y, Casa Z">
        </div>

        <!-- Email -->
        <div class="grupo-formulario">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email"
                   required placeholder="ejemplo@correo.com">
        </div>


        <!-- Contraseña -->
        <div class="grupo-formulario">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password"
                   required placeholder="********">
        </div>

        <!-- Confirmar contraseña -->
        <div class="grupo-formulario">
            <label for="password_confirm">Confirmar contraseña:</label>
            <input type="password" id="password_confirm" name="password_confirm"
                   required placeholder="********">
        </div>

        <div class="texto-centrado">
            <button type="submit" class="boton-naranja">
                Crear Cuenta
            </button>
        </div>
    </form>

    <p class="texto-centrado enlace-login">
        ¿Ya tienes cuenta?
        <a href="<?= BASE_URL ?>/?controller=AuthController&method=login"
           class="enlace-azul">Inicia sesión aquí</a>
    </p>
</section>
