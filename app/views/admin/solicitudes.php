<section class="admin-module">
    <h1 class="titulo-admin">Gestión de Solicitudes</h1>

    <div class="tabla-contenedor">
        <table class="tabla-admin">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Servicio</th>
                    <th>Estado</th>
                    <th>Fecha solicitada</th>
                    <th>Fecha programada</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($solicitudes as $s): ?>
                <?php $formId = "form-solicitud-" . $s['id']; ?>
                <tr>
                    <td><?= (int) $s["id"] ?></td>
                    <td><?= htmlspecialchars($s["cliente"]) ?></td>
                    <td><?= htmlspecialchars($s["servicio"]) ?></td>

                    <!--
                        El <form> no puede envolver varias celdas de la fila (HTML inválido:
                        los navegadores lo autocierran al toparse con </td>/<tr>, y los campos
                        de las celdas siguientes quedaban fuera del envío). Se usa un <form>
                        vacío fuera de la tabla y el atributo form="" en cada control para
                        asociarlos, sin importar en qué celda estén.
                    -->
                    <form id="<?= $formId ?>" method="POST" action="<?= BASE_URL ?>/?controller=AdminController&method=actualizarSolicitud">
                        <?= Csrf::field() ?>
                    </form>

                    <td>
                        <input type="hidden" form="<?= $formId ?>" name="id" value="<?= (int) $s['id'] ?>">

                        <select form="<?= $formId ?>" name="estado" class="select-estado">
                            <option value="Pendiente"   <?= $s["estado"] == "Pendiente" ? "selected" : "" ?>>Pendiente</option>
                            <option value="En proceso"  <?= $s["estado"] == "En proceso" ? "selected" : "" ?>>En proceso</option>
                            <option value="Finalizado"  <?= $s["estado"] == "Finalizado" ? "selected" : "" ?>>Finalizado</option>
                            <option value="Cancelado"   <?= $s["estado"] == "Cancelado" ? "selected" : "" ?>>Cancelado</option>
                        </select>
                    </td>

                    <td><?= htmlspecialchars($s["fecha_solicitada"]) ?></td>

                    <td>
                        <input
                        type="date"
                        form="<?= $formId ?>"
                        name="fecha_programada"
                        value="<?= htmlspecialchars($s['fecha_programada'] ?? '') ?>"
                        min="<?= date('Y-m-d') ?>"
                        >

                    </td>

                    <td><?= (int) $s["cantidad"] ?></td>

                    <td class="acciones-col">
                        <button class="btn-small btn-primary" form="<?= $formId ?>" type="submit">Actualizar</button>

                        <form method="POST" action="<?= BASE_URL ?>/?controller=AdminController&method=eliminarSolicitud"
                              class="form-inline-eliminar"
                              data-confirm="¿Seguro que deseas eliminar esta solicitud?">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="id" value="<?= (int) $s['id'] ?>">
                            <button type="submit" class="btn-small btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>

        </table>
    </div>
</section>
