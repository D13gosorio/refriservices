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
                    <td><?= $r["id"] ?></td>

                    <td>
                        <img src="<?= htmlspecialchars($rutaImagen) ?>" 
                             alt="Imagen repuesto"
                             class="img-repuesto-tabla">
                    </td>

                    <td><?= htmlspecialchars($r["nombre"]) ?></td>
                    <td>$<?= $r["precio"] ?></td>
                    <td><?= $r["stock"] ?></td>

                    <td>
                        <a href="<?= BASE_URL ?>/?controller=AdminController&method=editarRepuesto&id=<?= $r['id'] ?>" 
                           class="btn-editar">
                            Editar
                        </a>

                        <a href="<?= BASE_URL ?>/?controller=AdminController&method=eliminarRepuesto&id=<?= $r['id'] ?>" 
                           class="btn-borrar"
                           onclick="return confirm('¿Eliminar repuesto?');">
                            Eliminar
                        </a>
                    </td>
                </tr>

                <?php endforeach; ?>
            </tbody>

        </table>
    </div>
</section>
