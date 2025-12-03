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
                <tr>
                    <td><?= $s["id"] ?></td>
                    <td><?= htmlspecialchars($s["cliente"]) ?></td>
                    <td><?= htmlspecialchars($s["servicio"]) ?></td>

                    <td>
                        <form method="POST" action="<?= BASE_URL ?>/?controller=AdminController&method=actualizarSolicitud">
                            <input type="hidden" name="id" value="<?= $s['id'] ?>">

                            <select name="estado" class="select-estado">
                                <option value="Pendiente"   <?= $s["estado"] == "Pendiente" ? "selected" : "" ?>>Pendiente</option>
                                <option value="En proceso"  <?= $s["estado"] == "En proceso" ? "selected" : "" ?>>En proceso</option>
                                <option value="Finalizado"  <?= $s["estado"] == "Finalizado" ? "selected" : "" ?>>Finalizado</option>
                                <option value="Cancelado"   <?= $s["estado"] == "Cancelado" ? "selected" : "" ?>>Cancelado</option>
                            </select>
                    </td>

                    <td><?= $s["fecha_solicitada"] ?></td>

                    <td>
                        <input 
                        type="date" 
                        name="fecha_programada" 
                        value="<?= $s['fecha_programada'] ?>"
                        min="<?= date('Y-m-d') ?>"
                        >

                    </td>

                    <td><?= $s["cantidad"] ?></td>

                    <td class="acciones-col">
                        <button class="btn-small btn-primary" type="submit">Actualizar</button>
                        </form>

                        <a href="<?= BASE_URL ?>/?controller=AdminController&method=eliminarSolicitud&id=<?= $s['id'] ?>"
                           class="btn-small btn-danger"
                           onclick="return confirm('¿Seguro que deseas eliminar esta solicitud?');">
                           Eliminar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>

        </table>
    </div>
</section>
