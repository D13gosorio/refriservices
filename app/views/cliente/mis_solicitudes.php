<section class="seccion-mis-solicitudes">
    <h1 class="titulo-principal texto-centrado">Mis Solicitudes</h1>
    <p class="descripcion-subtitulo texto-centrado">
        Aquí puedes revisar todas tus solicitudes registradas.
    </p>
</section>

<section class="tabla-solicitudes-container">
    <table class="tabla-solicitudes">
        <thead>
            <tr>
                <th>ID</th>
                <th>Servicio</th>
                <th>Cantidad</th>
                <th>Fecha Solicitud</th>
                <th>Fecha Programada</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

        <?php if (empty($solicitudes)): ?>
            <tr>
                <td colspan="7" style="text-align:center; padding:1rem;">
                    No tienes solicitudes aún.
                </td>
            </tr>
        <?php endif; ?>

        <?php foreach ($solicitudes as $s): ?>
            <tr>
                <td><?= $s["id"] ?></td>
                <td><?= htmlspecialchars($s["servicio"]) ?></td>
                <td><?= $s["cantidad"] ?></td>
                <td><?= $s["fecha_solicitada"] ?></td>
                <td><?= $s["fecha_programada"] ?? "—" ?></td>

                <td>
                    <span class="estado <?= strtolower($s['estado']) ?>">
                        <?= $s["estado"] ?>
                    </span>
                </td>

                <td>
                    <a class="btn-ver"
                       href="<?= BASE_URL ?>/?controller=MisSolicitudesController&method=detalle&id=<?= $s['id'] ?>">
                       Ver
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</section>
