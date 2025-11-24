<section class="admin-module">
    <h1 class="titulo-admin">Mensajes de Contacto</h1>

    <div class="tabla-contenedor">
        <table class="tabla-admin">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                    <th>Opciones</th>
                </tr>
            </thead>

            <tbody>
                <?php
                // 🔧 Datos estáticos de prueba — Reemplazar cuando se conecte con la DB
                $mensajesPrueba = [
                    ["id" => 1, "nombre" => "Ana García", "correo" => "ana@gmail.com", "msg" => "Tengo una fuga en mi aire.", "fecha" => "2025-01-22"],
                    ["id" => 2, "nombre" => "Luis Ortega", "correo" => "luis@yahoo.com", "msg" => "Quiero cotizar una instalación.", "fecha" => "2025-01-23"],
                    ["id" => 3, "nombre" => "Rosa Chen", "correo" => "rosa@hotmail.com", "msg" => "Mi aire no enfría bien.", "fecha" => "2025-01-24"],
                ];
                ?>

                <?php foreach ($mensajesPrueba as $m): ?>
                <tr>
                    <td><?= $m["id"] ?></td>
                    <td><?= $m["nombre"] ?></td>
                    <td><?= $m["correo"] ?></td>
                    <td><?= $m["msg"] ?></td>
                    <td><?= $m["fecha"] ?></td>
                    <td>
                        <a href="#" class="btn-small btn-danger">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>
</section>
