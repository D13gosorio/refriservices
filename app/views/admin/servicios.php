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
                    <td><?= $s["id"] ?></td>
                    <td><?= $s["nombre"] ?></td>
                    <td><?= $s["descripcion"] ?></td>
                    <td>$<?= $s["precio"] ?></td>

                    <td>
                        <a href="<?= BASE_URL ?>/?controller=AdminController&method=editarServicio&id=<?= $s['id'] ?>" class="btn-small">
                            Editar
                        </a>

                        <a href="<?= BASE_URL ?>/?controller=AdminController&method=eliminarServicio&id=<?= $s['id'] ?>"
                           class="btn-small btn-danger"
                           onclick="return confirm('¿Seguro que deseas eliminar este servicio?');">
                           Eliminar
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>
</section>
