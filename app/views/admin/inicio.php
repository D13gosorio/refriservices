<section class="admin-inicio">
    <h1 class="titulo-admin">Panel de Administración</h1>

    <p class="subtitulo-admin">
        Selecciona un módulo para gestionar la información del sistema.
    </p>

    <div class="grid-modulos-admin">
        
        <a href="<?= BASE_URL ?>/index.php?controller=AdminController&method=servicios" class="card-admin">
            <h3>Gestión de Servicios</h3>
            <p>Crear, editar y administrar actividades y servicios.</p>
        </a>

        <a href="<?= BASE_URL ?>/index.php?controller=AdminController&method=repuestos" class="card-admin">
            <h3>Gestión de Repuestos</h3>
            <p>Registrar, actualizar y controlar repuestos disponibles.</p>
        </a>

        <a href="<?= BASE_URL ?>/index.php?controller=AdminController&method=solicitudes" class="card-admin">
            <h3>Gestión de Solicitudes</h3>
            <p>Revisar solicitudes de clientes y asignaciones.</p>
        </a>

        <a href="<?= BASE_URL ?>/index.php?controller=AdminController&method=mensajes" class="card-admin">
            <h3>Mensajes de Contacto</h3>
            <p>Leer y responder mensajes enviados desde la página pública.</p>
        </a>

    </div>
</section>
