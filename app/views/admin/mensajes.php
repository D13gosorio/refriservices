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
                    <td><?= $m["id"] ?></td>
                    <td><?= htmlspecialchars($m["nombre"]) ?></td>
                    <td><?= htmlspecialchars($m["correo"]) ?></td>
                    <td><?= htmlspecialchars($m["telefono"]) ?: "—" ?></td>
                    <td><?= htmlspecialchars($m["asunto"]) ?></td>
                    <td><?= htmlspecialchars($m["mensaje"]) ?></td>
                    <td><?= $m["fecha"] ?></td>

                    <td>
                        <a class="btn-small btn-danger"
                           href="<?= BASE_URL ?>/?controller=AdminController&method=eliminarMensaje&id=<?= $m['id'] ?>"
                           onclick="return confirm('¿Eliminar este mensaje?');">
                           Eliminar
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</section>
