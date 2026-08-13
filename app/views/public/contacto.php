<section class="contacto-titulo">
    <h1 class="texto-centrado">Formulario de Contacto</h1>
    <p class="texto-centrado subtitulo">
        Envíanos tu consulta y te responderemos lo antes posible.
    </p>
</section>

<section class="seccion-contacto contenedor">

    <form method="POST"
          action="<?= BASE_URL ?>/?controller=ContactoController&method=enviar"
          class="formulario-contacto">

        <?= Csrf::field() ?>

        <!-- Nombre -->
        <div class="grupo-formulario">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" maxlength="100" required>
        </div>

        <!-- Correo -->
        <div class="grupo-formulario">
            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" maxlength="255" required>
        </div>

        <!-- Teléfono: mismas reglas que valida el servidor, para que el aviso
             lo dé el navegador antes de enviar y no se pierda lo escrito. -->
        <div class="grupo-formulario">
            <label for="telefono">Teléfono (opcional):</label>
            <input type="text" id="telefono" name="telefono"
                   pattern="[0-9+\(\)\s.\-]{6,30}"
                   title="Entre 6 y 30 caracteres: números, espacios y los signos + - ( ) ."
                   maxlength="30">
        </div>

        <!-- Asunto -->
        <div class="grupo-formulario">
            <label for="asunto">Asunto:</label>
            <select id="asunto" name="asunto" required>
                <option value="">Selecciona una opción...</option>
                <option value="Consulta general">Consulta general</option>
                <option value="Soporte técnico">Soporte técnico</option>
                <option value="Información de repuestos">Información de repuestos</option>
                <option value="Otro">Otro</option>
            </select>
        </div>

        <!-- Mensaje -->
        <div class="grupo-formulario">
            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="mensaje" rows="5" maxlength="2000" required
                      placeholder="Escribe aquí tu mensaje..."></textarea>
        </div>

        <!-- Botón -->
        <div class="texto-centrado">
            <button type="submit" class="boton-naranja">Enviar Mensaje</button>
        </div>

    </form>

</section>
