<section class="admin-inicio">
    <h1 class="titulo-admin">Panel de Administración</h1>

    <p class="subtitulo-admin">
        Selecciona un módulo para gestionar la información del sistema.
    </p>

    <div class="grid-modulos-admin">
        
        <!-- Gestión de Servicios -->
        <a href="<?= BASE_URL ?>/?controller=AdminController&method=servicios" class="card-admin">
            <h3>Gestión de Servicios</h3>
            <p>Crear, editar y administrar servicios.</p>
        </a>

        <!-- Gestión de Repuestos -->
        <a href="<?= BASE_URL ?>/?controller=AdminController&method=repuestos" class="card-admin">
            <h3>Gestión de Repuestos</h3>
            <p>Agregar, actualizar y controlar repuestos disponibles.</p>
        </a>

        <!-- Gestión de Solicitudes -->
        <a href="<?= BASE_URL ?>/?controller=AdminController&method=solicitudes" class="card-admin">
            <h3>Gestión de Solicitudes</h3>
            <p>Revisar solicitudes de clientes y asignaciones.</p>
        </a>

        <!-- Mensajes de contacto -->
        <a href="<?= BASE_URL ?>/?controller=AdminController&method=mensajes" class="card-admin">
            <h3>Mensajes de Contacto</h3>
            <p>Leer mensajes enviados desde la página pública.</p>
        </a>

    </div>
</section>
