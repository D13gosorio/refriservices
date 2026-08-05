<section class="admin-module">
    <h1 class="titulo-admin">Gestión de Repuestos</h1>

    <!-- Botón Agregar -->
    <div class="admin-top-actions">
        <a href="<?= BASE_URL ?>/?controller=AdminController&method=crearRepuesto" 
           class="btn-agregar-repuesto">
            + Agregar repuesto
        </a>
    </div>

    <!-- Tabla -->
    <div class="tabla-contenedor">
        <table class="tabla-admin">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($repuestos as $r): ?>

                <?php
                    // Obtener imagen (puede ser URL completa o nombre local)
                    $img = $r["imagen"];

                    if (preg_match('/^https?:\/\//', $img)) {
                        // URL externa
                        $rutaImagen = $img;
                    } else {
                        // Imagen local dentro de /assets/img/repuestos/
                        $rutaImagen = BASE_URL . "/assets/img/repuestos/" . $img;
                    }
                ?>

                <tr>
                    <td><?= (int) $r["id"] ?></td>

                    <td>
                        <img src="<?= htmlspecialchars($rutaImagen) ?>"
                             alt="Imagen repuesto"
                             class="img-repuesto-tabla">
                    </td>

                    <td><?= htmlspecialchars($r["nombre"]) ?></td>
                    <td>$<?= htmlspecialchars($r["precio"]) ?></td>
                    <td><?= (int) $r["stock"] ?></td>

                    <td>
                        <a href="<?= BASE_URL ?>/?controller=AdminController&method=editarRepuesto&id=<?= (int) $r['id'] ?>"
                           class="btn-editar">
                            Editar
                        </a>

                        <form method="POST" action="<?= BASE_URL ?>/?controller=AdminController&method=eliminarRepuesto"
                              class="form-inline-eliminar"
                              data-confirm="¿Eliminar repuesto?">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                            <button type="submit" class="btn-borrar">Eliminar</button>
                        </form>
                    </td>
                </tr>

                <?php endforeach; ?>
            </tbody>

        </table>
    </div>
</section>
