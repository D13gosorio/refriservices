<section class="admin-module">
    <h1 class="titulo-admin">Gestión de Repuestos</h1>

    <!-- Botón Agregar (arriba a la derecha) -->
    <div style="text-align: right; width: 90%; max-width: 1200px; margin: 1rem auto;">
        <button class="btn-agregar-repuesto">+ Agregar repuesto</button>
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

                <?php
                // 🔧 DATOS ESTÁTICOS (REEMPLAZAR POR CONSULTA REAL A LA BASE DE DATOS)
                $repuestosPrueba = [
                    [
                        "id" => 1,
                        "imagen" => BASE_URL . "/assets/img/repuestos/default.jpg",
                        "nombre" => "Motor de ventilador",
                        "precio" => "35.00",
                        "cantidad" => 12
                    ],
                    [
                        "id" => 2,
                        "imagen" => BASE_URL . "/assets/img/repuestos/default.jpg",
                        "nombre" => "Filtro lavable",
                        "precio" => "9.00",
                        "cantidad" => 50
                    ],
                    [
                        "id" => 3,
                        "imagen" => BASE_URL . "/assets/img/repuestos/default.jpg",
                        "nombre" => "Capacitor 45uF",
                        "precio" => "7.50",
                        "cantidad" => 28
                    ],
                ];
                ?>

                <?php foreach ($repuestosPrueba as $r): ?>
                <tr>
                    <td><?= $r["id"] ?></td>

                    <td>
                        <img src="<?= $r["imagen"] ?>" alt="Imagen repuesto" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                    </td>

                    <td><?= $r["nombre"] ?></td>
                    <td>$<?= $r["precio"] ?></td>
                    <td><?= $r["cantidad"] ?></td>

                    <td>
                        <button class="btn-editar">Editar</button>
                        <button class="btn-borrar">Eliminar</button>
                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>

        </table>
    </div>
</section>
