<section class="admin-module">
    <h1 class="titulo-admin">Mensajes de Contacto</h1>

    <div class="tabla-contenedor">
        <table class="tabla-admin">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Asunto</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                    <th>Opciones</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($mensajes as $m): ?>
                <tr>
                    <td><?= (int) $m["id"] ?></td>
                    <td><?= htmlspecialchars($m["nombre"]) ?></td>
                    <td><?= htmlspecialchars($m["correo"]) ?></td>
                    <td><?= htmlspecialchars($m["telefono"]) ?: "—" ?></td>
                    <td><?= htmlspecialchars($m["asunto"]) ?></td>
                    <td><?= htmlspecialchars($m["mensaje"]) ?></td>
                    <td><?= htmlspecialchars($m["fecha"]) ?></td>

                    <td>
                        <form method="POST" action="<?= BASE_URL ?>/?controller=AdminController&method=eliminarMensaje"
                              class="form-inline-eliminar"
                              data-confirm="¿Eliminar este mensaje?">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="id" value="<?= (int) $m['id'] ?>">
                            <button type="submit" class="btn-small btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</section>
