<?php
// Datos del intento anterior, para no obligar a rellenar de nuevo el
// formulario entero cuando falla una sola validación. Las contraseñas nunca
// se recuerdan.
$previos = $_SESSION['registro_datos'] ?? [];
$campoError = $_SESSION['registro_campo_error'] ?? null;
unset($_SESSION['registro_datos'], $_SESSION['registro_campo_error']);

// Devuelve el valor anterior de un campo, ya escapado.
$valor = static fn(string $campo): string => htmlspecialchars($previos[$campo] ?? '');

// Marca el campo que provocó el error, para que se vea cuál corregir.
$marca = static fn(string $campo): string => $campoError === $campo
    ? ' class="campo-invalido" aria-invalid="true"'
    : '';
?>

<section class="seccion-auth seccion-auth--ancha">

    <h1 class="titulo-principal texto-centrado">Crear cuenta</h1>

    <p class="texto-centrado descripcion-subtitulo">
        Regístrate para solicitar servicios y seguir el estado de tus solicitudes.
    </p>

    <?php if (!empty($_SESSION['error'])): ?>
        <!-- role="alert" hace que un lector de pantalla lo anuncie al cargar
             la página; sin él, el aviso pasa desapercibido. -->
        <div class="alerta-error" role="alert">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="POST"
          action="<?= BASE_URL ?>/?controller=AuthController&method=doRegistro"
          class="formulario-auth formulario-auth--dos-columnas">

        <?= Csrf::field() ?>

        <!-- Nombre -->
        <div class="grupo-formulario ocupa-fila">
            <label for="nombre">Nombre completo</label>
            <input type="text" id="nombre" name="nombre"
                   value="<?= $valor('nombre') ?>"
                   required minlength="3" maxlength="60"
                   autocomplete="name"
                   autofocus
                   pattern="[A-Za-zÁÉÍÓÚáéíóúÑñÜü ]{3,60}"
                   placeholder="Nombre y apellido"<?= $marca('nombre') ?>>
            <span class="ayuda-campo">Solo letras y espacios.</span>
        </div>

        <!-- Teléfono -->
        <div class="grupo-formulario">
            <label for="telefono">Teléfono</label>
            <input type="tel" id="telefono" name="telefono"
                   value="<?= $valor('telefono') ?>"
                   required maxlength="9"
                   autocomplete="tel-national"
                   inputmode="numeric"
                   pattern="[0-9]{4}-[0-9]{4}"
                   placeholder="6031-6975"<?= $marca('telefono') ?>>
            <span class="ayuda-campo">Ocho dígitos. El guion se pone solo.</span>
        </div>

        <!-- Email -->
        <div class="grupo-formulario">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email"
                   value="<?= $valor('email') ?>"
                   required maxlength="255"
                   autocomplete="email"
                   placeholder="ejemplo@correo.com"<?= $marca('email') ?>>
            <span class="ayuda-campo">Lo usarás para iniciar sesión.</span>
        </div>

        <!-- Dirección -->
        <div class="grupo-formulario ocupa-fila">
            <label for="direccion">Dirección</label>
            <input type="text" id="direccion" name="direccion"
                   value="<?= $valor('direccion') ?>"
                   required minlength="5" maxlength="255"
                   autocomplete="street-address"
                   placeholder="Barrio, calle y número de casa"<?= $marca('direccion') ?>>
            <span class="ayuda-campo">Dónde debe presentarse el técnico.</span>
        </div>

        <!-- Contraseña -->
        <div class="grupo-formulario">
            <label for="password">Contraseña</label>
            <div class="campo-password">
                <input type="password" id="password" name="password"
                       required minlength="8" maxlength="72"
                       autocomplete="new-password"
                       aria-describedby="requisitos-password"
                       placeholder="Crea una contraseña"<?= $marca('password') ?>>
            </div>
            <!-- Los requisitos se ven desde el principio, en vez de esconderse
                 en un `title` que en móvil no aparece nunca. -->
            <ul class="requisitos-password" id="requisitos-password">
                <li data-regla="longitud">Ocho caracteres o más</li>
                <li data-regla="letra">Al menos una letra</li>
                <li data-regla="numero">Al menos un número</li>
            </ul>
        </div>

        <!-- Confirmar contraseña -->
        <div class="grupo-formulario">
            <label for="password_confirm">Repite la contraseña</label>
            <div class="campo-password">
                <input type="password" id="password_confirm" name="password_confirm"
                       required minlength="8" maxlength="72"
                       autocomplete="new-password"
                       aria-describedby="mensaje-password-confirm"
                       placeholder="Escríbela otra vez">
            </div>
            <!-- aria-live: el aviso se anuncia en cuanto aparece, sin esperar
                 a que el usuario vuelva a pasar por el campo. -->
            <span class="mensaje-campo" id="mensaje-password-confirm" aria-live="polite"></span>
        </div>

        <div class="ocupa-fila">
            <button type="submit" class="boton-naranja">Crear cuenta</button>
        </div>
    </form>

    <p class="enlace-auth">
        ¿Ya tienes cuenta?
        <a href="<?= BASE_URL ?>/?controller=AuthController&method=login">Inicia sesión aquí</a>
    </p>

</section>

<script src="<?= BASE_URL ?>/assets/js/autenticacion.js"></script>
