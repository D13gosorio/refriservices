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

                <?php
                // 🔧 DATOS ESTÁTICOS (REEMPLAZAR POR CONSULTA A LA BASE DE DATOS)
                $solicitudesPrueba = [
                    [
                        "id" => 101,
                        "cliente" => "Carlos López",
                        "servicio" => "Instalación de aire acondicionado",
                        "estado" => "Pendiente",
                        "fecha_solicitada" => "2025-01-20",
                        "fecha_programada" => "2025-01-25",
                        "cantidad" => 1
                    ],
                    [
                        "id" => 102,
                        "cliente" => "María Pérez",
                        "servicio" => "Mantenimiento general",
                        "estado" => "En proceso",
                        "fecha_solicitada" => "2025-01-22",
                        "fecha_programada" => "2025-01-29",
                        "cantidad" => 2
                    ],
                    [
                        "id" => 103,
                        "cliente" => "José Torres",
                        "servicio" => "Reparación de fuga de gas",
                        "estado" => "Finalizado",
                        "fecha_solicitada" => "2025-01-23",
                        "fecha_programada" => "2025-01-24",
                        "cantidad" => 1
                    ],
                ];
                ?>

                <?php foreach ($solicitudesPrueba as $s): ?>
                <tr>
                    <td><?= $s["id"] ?></td>
                    <td><?= $s["cliente"] ?></td>
                    <td><?= $s["servicio"] ?></td>

                    <!-- SELECT ESTÁTICO PARA ESTADO -->
                    <td>
                        <select class="select-estado">
                            <option value="Pendiente"   <?= $s["estado"] == "Pendiente" ? "selected" : "" ?>>Pendiente</option>
                            <option value="En proceso"  <?= $s["estado"] == "En proceso" ? "selected" : "" ?>>En proceso</option>
                            <option value="Finalizado"  <?= $s["estado"] == "Finalizado" ? "selected" : "" ?>>Finalizado</option>
                            <option value="Cancelado"   <?= $s["estado"] == "Cancelado" ? "selected" : "" ?>>Cancelado</option>
                        </select>
                    </td>

                    <td><?= $s["fecha_solicitada"] ?></td>
                    <td><?= $s["fecha_programada"] ?></td>
                    <td><?= $s["cantidad"] ?></td>

                    <td>
                        <button class="btn-small btn-primary">
                            Actualizar
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>

        </table>
    </div>
</section>
