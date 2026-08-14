<!-- ===================== BARRA PRINCIPAL ===================== -->
<div class="navbar-principal">
    <div class="contenedor navbar-contenido">

        <!-- LOGO -->
        <div class="logo">
            <a href="<?= BASE_URL ?>/">
                <img src="<?= BASE_URL ?>/assets/img/logo/logo.png" alt="Logo del sitio">
            </a>
        </div>

        <!-- MENU -->
        <nav class="menu" id="menu-principal">
            <ul>
                <li><a href="<?= BASE_URL ?>/">Inicio</a></li>
                <li><a href="<?= BASE_URL ?>/?controller=ServicioController&method=index">Servicios</a></li>
                <li><a href="<?= BASE_URL ?>/?controller=RepuestoController&method=index">Repuestos</a></li>
                <li><a href="<?= BASE_URL ?>/?controller=NosotrosController&method=index">Nosotros</a></li>
                <li><a href="<?= BASE_URL ?>/?controller=ContactoController&method=index">Contacto</a></li>

                <?php if (!isset($_SESSION['usuario_id'])): ?>

                    <!-- 🔹 Usuario NO ha iniciado sesión -->
                    <li>
                        <a href="<?= BASE_URL ?>/?controller=AuthController&method=login" class="boton-login">
                            Ingresar
                        </a>
                    </li>

                <?php else: ?>
                    
                    <!-- 🔹 Cerrar sesión (POST: ver nota en navbar.css) -->
                    <li>
                        <form method="POST"
                              action="<?= BASE_URL ?>/?controller=AuthController&method=logout"
                              class="form-salir">
                            <?= Csrf::field() ?>
                            <button type="submit" class="boton-login">Salir</button>
                        </form>
                    </li>
                    
                     <!-- 🔹 Texto de bienvenida -->
                    <li class="texto-bienvenida">
                        Bienvenido, <?= htmlspecialchars($_SESSION['usuario_nombre']) ?>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

        <!-- Ícono hamburguesa (móvil) -->
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
