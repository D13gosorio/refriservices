<section class="seccion-servicios-principal">
    <h1 class="titulo-principal">Servicios Disponibles</h1>
    <p class="descripcion-subtitulo">
        Ofrecemos instalación, mantenimiento y reparación profesional para hogares y negocios.
    </p>
</section>
<!-- Aquí cambiamos esto para que funcionara como quiere imanol, favor revisar -->
<section class="bloque-mis-solicitudes">
    <p>¿Ya has solicitado un servicio anteriormente?</p>
    <a href="<?= BASE_URL ?>/?controller=MisSolicitudesController&method=index" class="btn-mis-solicitudes">
        Ver historial de mis solicitudes
    </a>
</section>

<section class="lista-servicios">

    <?php if (!empty($servicios)): ?>
        <?php foreach ($servicios as $servicio): ?>
            <article class="item-servicio">
                <div class="contenido-servicio">
                    <h3><?= htmlspecialchars($servicio['nombre']) ?></h3>
                    <p><?= htmlspecialchars($servicio['descripcion']) ?></p>
                    <p class="precio-servicio">$<?= number_format($servicio['precio'], 2) ?></p>
                </div>

                <div class="boton-servicio">
                    <a href="<?= BASE_URL ?>/?controller=SolicitudController&method=formulario&id_servicio=<?= $servicio['id'] ?>"
                       class="boton-accion">
                        Solicitar
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="texto-centrado">Por el momento no hay servicios disponibles.</p>
    <?php endif; ?>

</section>
