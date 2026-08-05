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

        <!-- Nombre -->
        <div class="grupo-formulario">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <!-- Correo -->
        <div class="grupo-formulario">
            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" required>
        </div>

        <!-- Teléfono -->
        <div class="grupo-formulario">
            <label for="telefono">Teléfono (opcional):</label>
            <input type="text" id="telefono" name="telefono">
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
            <textarea id="mensaje" name="mensaje" rows="5" required
                      placeholder="Escribe aquí tu mensaje..."></textarea>
        </div>

        <!-- Botón -->
        <div class="texto-centrado">
            <button type="submit" class="boton-naranja">Enviar Mensaje</button>
        </div>

    </form>

</section>
