<section class="seccion-mis-solicitudes">
    <h1 class="titulo-principal texto-centrado">Detalle de Solicitud #<?= (int) $solicitud['id'] ?></h1>
</section>

<section class="tabla-solicitudes-container contenedor-detalle-solicitud">

    <div class="tarjeta">
        <h2>Servicio: <?= htmlspecialchars($solicitud['servicio']) ?></h2>

        <p><strong>Precio unitario:</strong> $<?= htmlspecialchars($solicitud['precio']) ?></p>
        <p><strong>Cantidad:</strong> <?= (int) $solicitud['cantidad'] ?></p>

        <p><strong>Fecha solicitada:</strong> <?= htmlspecialchars($solicitud['fecha_solicitada']) ?></p>
        <p><strong>Fecha programada:</strong> <?= htmlspecialchars($solicitud['fecha_programada'] ?? "—") ?></p>

        <p><strong>Estado:</strong>
            <span class="estado <?= str_replace(' ', '-', strtolower($solicitud['estado'])) ?>">
                <?= htmlspecialchars($solicitud['estado']) ?>
            </span>
        </p>

        <p><strong>Descripción:</strong><br>
            <?= $solicitud['descripcion'] ? nl2br(htmlspecialchars($solicitud['descripcion'])) : "Sin descripción" ?>
        </p>

        <div class="acciones-detalle-solicitud">
            <a href="<?= BASE_URL ?>/?controller=MisSolicitudesController&method=index"
               class="btn-ver">Volver</a>

            <?php if ($solicitud["estado"] != "Finalizado" && $solicitud["estado"] != "Cancelado"): ?>
                <form method="POST" action="<?= BASE_URL ?>/?controller=MisSolicitudesController&method=cancelar"
                      class="form-inline-eliminar"
                      data-confirm="¿Seguro que deseas cancelar esta solicitud?">
                    <?= Csrf::field() ?>
                    <input type="hidden" name="id" value="<?= (int) $solicitud['id'] ?>">
                    <button type="submit" class="btn-ver btn-cancelar-solicitud">
                        Cancelar solicitud
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>

</section>
