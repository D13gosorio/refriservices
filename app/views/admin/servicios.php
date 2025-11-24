<section class="admin-module">
    <h1 class="titulo-admin">Gestión de Servicios</h1>

    <div class="top-actions">
        <a href="<?= BASE_URL ?>/index.php?controller=ServiciosController&method=create" class="btn-primary">
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
                <?php
                // 🔧 Datos estáticos de prueba — Reemplazar con datos reales desde el controlador
                $serviciosPrueba = [
                    ["id" => 1, "nombre" => "Mantenimiento de aire acondicionado", "desc" => "Limpieza y revisión completa", "precio" => "$45"],
                    ["id" => 2, "nombre" => "Instalación básica", "desc" => "Instalación de equipo split 12,000BTU", "precio" => "$120"],
                    ["id" => 3, "nombre" => "Reparación de fuga", "desc" => "Detección y corrección de fuga de gas", "precio" => "$65"],
                ];
                ?>

                <?php foreach ($serviciosPrueba as $s): ?>
                <tr>
                    <td><?= $s["id"] ?></td>
                    <td><?= $s["nombre"] ?></td>
                    <td><?= $s["desc"] ?></td>
                    <td><?= $s["precio"] ?></td>
                    <td>
                        <a href="#" class="btn-small">Editar</a>
                        <a href="#" class="btn-small btn-danger">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>
</section>
