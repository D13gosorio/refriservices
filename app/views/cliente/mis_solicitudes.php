<!-- ===================== TÍTULO ===================== -->
<section class="seccion-mis-solicitudes">
    <h1 class="titulo-principal texto-centrado">Mis Solicitudes</h1>

    <p class="texto-centrado descripcion-subtitulo">
        Aquí puedes revisar el historial de solicitudes y el estado actual de cada una.
    </p>
</section>

<!-- ===================== TABLA DE SOLICITUDES ===================== -->
<section class="tabla-solicitudes-container">
    
    <table class="tabla-solicitudes">
        <thead>
            <tr>
                <th>ID</th>
                <th>Servicio</th>
                <th>Cantidad</th>
                <th>Fecha Solicitud</th>
                <th>Fecha Programada</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <!-- 🔹 Ejemplo estático, luego será dinámico -->
            <tr>
                <td>001</td>
                <td>Instalación</td>
                <td>1</td>
                <td>2025-01-12</td>
                <td>2025-01-15</td>
                <td><span class="estado pendiente">Pendiente</span></td>
                <td><a href="#" class="btn-ver">Ver</a></td>
            </tr>

            <tr>
                <td>002</td>
                <td>Mantenimiento</td>
                <td>1</td>
                <td>2025-01-05</td>
                <td>2025-01-07</td>
                <td><span class="estado aprobado">Aprobado</span></td>
                <td><a href="#" class="btn-ver">Ver</a></td>
            </tr>
        </tbody>
    </table>

</section>
