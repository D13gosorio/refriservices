<section class="seccion-solicitud">
    <h1 class="titulo-principal texto-centrado">Solicitar Servicio</h1>
    <p class="texto-centrado descripcion-subtitulo">
        Complete los datos para procesar su solicitud.
    </p>
</section>

<section class="resumen-servicio">
    <h2 class="nombre-servicio"><?= htmlspecialchars($servicio['nombre']) ?></h2>
    <p class="precio-servicio">$<?= $servicio['precio'] ?></p>
    <p class="texto-pequeno">Precio por unidad de servicio</p>
</section>

<section class="formulario-solicitud">
    <form method="POST" action="<?= BASE_URL ?>/?controller=SolicitudController&method=guardar">

        <input type="hidden" name="id_servicio" value="<?= $servicio['id'] ?>">

        <div class="grupo-formulario">
            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" min="1" value="1" required>
        </div>

        <div class="grupo-formulario">
            <label for="fecha_servicio">Fecha deseada para el servicio:</label>
            <input type="date" id="fecha_servicio" name="fecha_servicio" required>
        </div>

        <div class="grupo-formulario">
            <label for="descripcion">Descripción o detalles adicionales:</label>
            <textarea id="descripcion" name="descripcion" rows="4"></textarea>
        </div>

        <div class="texto-centrado">
            <button type="submit" class="boton-naranja">Confirmar Solicitud</button>
        </div>

    </form>
</section>
