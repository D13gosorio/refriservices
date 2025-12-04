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
                   required placeholder="Tu nombre aquí"
                   pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,60}"
                   title="El nombre solo puede contener letras y espacios (mínimo 3 caracteres)">
        </div>

               <!-- Teléfono -->
        <div class="grupo-formulario">
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono"
                   required placeholder="0000-0000"
                   pattern="^[0-9]{4}-[0-9]{4}$"
                   title="El teléfono debe tener el formato 0000-0000">
        </div>

                <!-- Dirección -->
        <div class="grupo-formulario">
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion"
                   required placeholder="Ej: Barrio X, Calle Y, Casa Z"
                   minlength="5"
                   title="La dirección debe contener al menos 5 caracteres">
        </div>

        <!-- Email -->
        <div class="grupo-formulario">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email"
                   required placeholder="ejemplo@correo.com"
                   pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$"
                   title="Introduce un correo válido">
        </div>


        <!-- Contraseña -->
        <div class="grupo-formulario">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password"
                   required placeholder="********"
                   minlength="8"
                   pattern="^(?=.*[A-Za-z])(?=.*\d).{8,}$"
                   title="La contraseña debe tener mínimo 8 caracteres e incluir letras y números">
        </div>

        <!-- Confirmar contraseña -->
        <div class="grupo-formulario">
            <label for="password_confirm">Confirmar contraseña:</label>
            <input type="password" id="password_confirm" name="password_confirm"
                   required placeholder="********"
                   minlength="8"
                   pattern="^(?=.*[A-Za-z])(?=.*\d).{8,}$"
                   title="Debe coincidir con la contraseña anterior">
        </div>

        <div class="texto-centrado">
            <button type="submit" class="boton-naranja">
                Crear Cuenta
            </button>
        </div>
        <div id="password-error" style="color:red; text-align:center; display:none; margin-bottom:10px;">
            Las contraseñas no coinciden.
        </div>
    </form>

    <p class="texto-centrado enlace-login">
        ¿Ya tienes cuenta?
        <a href="<?= BASE_URL ?>/?controller=AuthController&method=login"
           class="enlace-azul">Inicia sesión aquí</a>
    </p>

<script>
document.querySelector(".formulario-registro").addEventListener("submit", function(event) {
    const pass = document.getElementById("password").value;
    const passConfirm = document.getElementById("password_confirm").value;
    const errorDiv = document.getElementById("password-error");

    if (pass !== passConfirm) {
        event.preventDefault();
        errorDiv.style.display = "block";
    } else {
        errorDiv.style.display = "none";
    }
});
const telefono = document.getElementById("telefono");
telefono.addEventListener("input", () => {
    telefono.value = telefono.value.replace(/[^0-9-]/g, "");
});
</script>
</section>
