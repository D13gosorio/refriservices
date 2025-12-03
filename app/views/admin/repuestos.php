<section class="admin-module">
    <h1 class="titulo-admin">Gestión de Repuestos</h1>

     <div class="admin-top-actions">
        <a href="<?= BASE_URL ?>/?controller=AdminController&method=crearRepuesto" 
            class="btn-agregar-repuesto">
            + Agregar repuesto
        </a>
    </div>


    <!-- Contenedor con el mismo estilo de tabla que solicitudes -->
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
                <tr>
                    <td><?= $r["id"] ?></td>

                    <td>
                        <img src="<?= BASE_URL ?>/assets/img/repuestos/<?= $r["imagen"] ?>" 
                            alt="Imagen repuesto"
                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                    </td>

                    <td><?= $r["nombre"] ?></td>
                    <td>$<?= $r["precio"] ?></td>
                    <td><?= $r["stock"] ?></td>

                    <td>
                        <a href="<?= BASE_URL ?>/?controller=AdminController&method=editarRepuesto&id=<?= $r['id'] ?>" class="btn-editar">
                            Editar
                        </a>

                        <a href="<?= BASE_URL ?>/?controller=AdminController&method=eliminarRepuesto&id=<?= $r['id'] ?>" class="btn-borrar"
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
