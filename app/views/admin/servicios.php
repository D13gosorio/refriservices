<section class="admin-module">
    <h1 class="titulo-admin">Gestión de Servicios</h1>

    <div class="top-actions">
        <a href="<?= BASE_URL ?>/?controller=AdminController&method=crearServicio" class="btn-primary">
            + Agregar servicio
        </a>
    </div>

    <div class="tabla-contenedor">
        <table class="tabla-admin">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Servicio</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Opciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($servicios as $s): ?>
                <tr>
                    <td><?= (int) $s["id"] ?></td>
                    <td><?= htmlspecialchars($s["nombre"]) ?></td>
                    <td><?= htmlspecialchars($s["descripcion"]) ?></td>
                    <td>$<?= htmlspecialchars($s["precio"]) ?></td>

                    <td>
                        <a href="<?= BASE_URL ?>/?controller=AdminController&method=editarServicio&id=<?= (int) $s['id'] ?>" class="btn-small">
                            Editar
                        </a>

                        <form method="POST" action="<?= BASE_URL ?>/?controller=AdminController&method=eliminarServicio"
                              class="form-inline-eliminar"
                              data-confirm="¿Seguro que deseas eliminar este servicio?">
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
