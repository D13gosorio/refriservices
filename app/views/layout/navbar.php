<!-- ===================== BARRA PRINCIPAL ===================== -->
<div class="navbar-principal">
    <div class="contenedor navbar-contenido">

        <div class="logo">
            <a href="<?= BASE_URL ?>/"><img src="<?= BASE_URL ?>/assets/img/logo/logo.png"></a>
        </div>

        <nav class="menu">
            <ul>
                <li><a href="<?= BASE_URL ?>/">Inicio</a></li>
                <li><a href="<?= BASE_URL ?>/?controller=ServicioController&method=index">Servicios</a></li>
                <li><a href="<?= BASE_URL ?>/?controller=RepuestoController&method=index">Repuestos</a></li>
                <li><a href="<?= BASE_URL ?>/?controller=NosotrosController&method=index">Nosotros</a></li>
                <li><a href="<?= BASE_URL ?>/?controller=ContactoController&method=index">Contacto</a></li>
                <li><a href="<?= BASE_URL ?>/?controller=AuthController&method=login" class="boton-login">Ingresar</a></li>
            </ul>
        </nav>

        <!-- Ícono hamburguesa versión móvil -->
        <div class="hamburguesa">
            <span></span>
            <span></span>
            <span></span>
        </div>

    </div>
</div>

