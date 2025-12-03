<section class="seccion-mis-solicitudes">
    <h1 class="titulo-principal texto-centrado">Detalle de Solicitud #<?= $solicitud['id'] ?></h1>
</section>

<section class="tabla-solicitudes-container" style="max-width:700px; margin:auto;">

    <div class="tarjeta">
        <h2>Servicio: <?= htmlspecialchars($solicitud['servicio']) ?></h2>

        <p><strong>Precio unitario:</strong> $<?= $solicitud['precio'] ?></p>
        <p><strong>Cantidad:</strong> <?= $solicitud['cantidad'] ?></p>

        <p><strong>Fecha solicitada:</strong> <?= $solicitud['fecha_solicitada'] ?></p>
        <p><strong>Fecha programada:</strong> <?= $solicitud['fecha_programada'] ?? "—" ?></p>

        <p><strong>Estado:</strong> 
            <span class="estado <?= strtolower($solicitud['estado']) ?>">
                <?= $solicitud['estado'] ?>
            </span>
        </p>

        <p><strong>Descripción:</strong><br>
            <?= $solicitud['descripcion'] ?: "Sin descripción" ?>
        </p>

        <div style="margin-top:1rem; display:flex; gap:1rem;">
            <a href="<?= BASE_URL ?>/?controller=MisSolicitudesController&method=index"
               class="btn-ver">Volver</a>

            <?php if ($solicitud["estado"] != "Finalizado" && $solicitud["estado"] != "Cancelado"): ?>
                <a href="<?= BASE_URL ?>/?controller=MisSolicitudesController&method=cancelar&id=<?= $solicitud['id'] ?>"
                   onclick="return confirm('¿Seguro que deseas cancelar esta solicitud?');"
                   class="btn-ver" style="background:#dc3545; color:white;">
                   Cancelar solicitud
                </a>
            <?php endif; ?>
        </div>
    </div>

</section>
