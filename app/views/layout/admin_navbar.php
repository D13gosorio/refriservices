<!-- ===================== NAVBAR PRINCIPAL (ADMIN) ===================== -->
<div class="navbar-principal">
    <div class="contenedor navbar-contenido">

        <div class="logo">
            <a href="<?= BASE_URL ?>/index.php?controller=AdminController&method=index">
                <img src="<?= BASE_URL ?>/assets/img/logo/logo.png" alt="Logo del sitio">
            </a>
        </div>

        <nav class="menu" id="menu-principal">
            <ul>
                <li>
                    <a href="<?= BASE_URL ?>/index.php?controller=AdminController&method=index">
                        Panel de Administración
                    </a>
                </li>

                <li>
                    <a href="<?= BASE_URL ?>/index.php?controller=AdminController&method=servicios">
                        Gestión de Servicios
                    </a>
                </li>

                <li>
                    <a href="<?= BASE_URL ?>/index.php?controller=AdminController&method=repuestos">
                        Gestión de Repuestos
                    </a>
                </li>

                <li>
                    <a href="<?= BASE_URL ?>/index.php?controller=AdminController&method=solicitudes">
                        Gestión de Solicitudes
                    </a>
                </li>

                <li>
                    <a href="<?= BASE_URL ?>/index.php?controller=AdminController&method=mensajes">
                        Mensajes de Contacto
                    </a>
                </li>

                <li>
                    <form method="POST"
                          action="<?= BASE_URL ?>/index.php?controller=AuthController&method=logout"
                          class="form-salir">
                        <?= Csrf::field() ?>
                        <button type="submit" class="boton-login">Salir</button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Botón, no un div: así se puede enfocar y activar con el teclado, y
             aria-expanded le dice a un lector de pantalla si el menú está abierto. -->
        <button class="hamburguesa" type="button"
                aria-label="Abrir menú de navegación"
                aria-expanded="false"
                aria-controls="menu-principal">
            <span></span>
            <span></span>
            <span></span>
        </button>

    </div>
</div>

