<!-- ===================== HERO BANNER ===================== -->
<section class="banner-hero">
    <div class="contenedor-texto-banner">
        <h1>Expertos en refrigeración y aire acondicionado en Aguadulce</h1>
        <p>Instalación, mantenimiento y reparación con técnicos certificados. Solicita tu servicio en minutos.</p>

        <div class="botones-banner">
            <a href="<?= BASE_URL ?>/?controller=ServicioController&method=index" class="boton-naranja">
                Ver servicios
            </a>
            <a href="<?= BASE_URL ?>/?controller=AuthController&method=registro" class="boton-outline">
                Crear cuenta gratis
            </a>
        </div>
    </div>
</section>


<!-- ===================== SECCIÓN: ¿QUÉ HACEMOS? ===================== -->
<section class="seccion-servicios">
    <h2 class="titulo-seccion">¿Qué hacemos?</h2>

    <div class="grid-3-tarjetas">
        <article class="tarjeta-servicio">
            <div class="icono">🛠️</div>
            <h3>Instalación</h3>
            <p>Instalación profesional de sistemas de aire acondicionado y refrigeración.</p>
        </article>

        <article class="tarjeta-servicio">
            <div class="icono">🔧</div>
            <h3>Reparación</h3>
            <p>Reparación de equipos domésticos y comerciales para un funcionamiento óptimo.</p>
        </article>

        <article class="tarjeta-servicio">
            <div class="icono">⚙️</div>
            <h3>Mantenimiento</h3>
            <p>Mantenimiento preventivo y correctivo para alargar la vida útil de los sistemas.</p>
        </article>
    </div>
</section>


<!-- ===================== SECCIÓN: SERVICIOS DESTACADOS (dinámico) ===================== -->
<?php if (!empty($serviciosDestacados)): ?>
<section class="seccion-destacados">
    <h2 class="titulo-seccion">Servicios más solicitados</h2>

    <div class="grid-destacados">
        <?php foreach ($serviciosDestacados as $servicio): ?>
            <article class="tarjeta-destacado">
                <h3><?= htmlspecialchars($servicio['nombre']) ?></h3>
                <p><?= htmlspecialchars($servicio['descripcion']) ?></p>
                <p class="precio-destacado">$<?= number_format($servicio['precio'], 2) ?></p>

                <a href="<?= BASE_URL ?>/?controller=SolicitudController&method=formulario&id_servicio=<?= $servicio['id'] ?>"
                   class="boton-secundario">
                    Solicitar
                </a>
            </article>
        <?php endforeach; ?>
    </div>

    <p class="texto-centrado ver-todo">
        <a href="<?= BASE_URL ?>/?controller=ServicioController&method=index">Ver todos los servicios →</a>
    </p>
</section>
<?php endif; ?>


<!-- ===================== SECCIÓN: REPUESTOS DESTACADOS (dinámico) ===================== -->
<?php if (!empty($repuestosDestacados)): ?>
<section class="seccion-destacados seccion-destacados-alterna">
    <h2 class="titulo-seccion">Catálogo de repuestos</h2>

    <div class="grid-destacados grid-destacados-repuestos">
        <?php foreach ($repuestosDestacados as $r): ?>
            <?php
                $rutaImagen = preg_match('/^https?:\/\//', $r["imagen"])
                    ? $r["imagen"]
                    : BASE_URL . "/assets/img/repuestos/" . $r["imagen"];
            ?>
            <article class="tarjeta-destacado tarjeta-repuesto-destacado">
                <img src="<?= htmlspecialchars($rutaImagen) ?>" alt="Imagen de <?= htmlspecialchars($r['nombre']) ?>">
                <h3><?= htmlspecialchars($r['nombre']) ?></h3>
                <p class="precio-destacado">$<?= number_format($r['precio'], 2) ?></p>

                <a href="<?= BASE_URL ?>/?controller=RepuestoController&method=detalle&id=<?= $r['id'] ?>"
                   class="boton-secundario">
                    Ver detalle
                </a>
            </article>
        <?php endforeach; ?>
    </div>

    <p class="texto-centrado ver-todo">
        <a href="<?= BASE_URL ?>/?controller=RepuestoController&method=index">Ver catálogo completo →</a>
    </p>
</section>
<?php endif; ?>


<!-- ===================== SECCIÓN: ¿POR QUÉ ELEGIRNOS? ===================== -->
<section class="seccion-ventajas">
    <h2 class="titulo-seccion">¿Por qué elegirnos?</h2>

    <div class="grid-3-ventajas">
        <div class="ventaja">
            <h3>Técnicos Certificados</h3>
            <p>Personal capacitado en las últimas tecnologías de refrigeración.</p>
        </div>

        <div class="ventaja">
            <h3>Atención Personalizada</h3>
            <p>Soluciones adaptadas a cada cliente con un trato profesional.</p>
        </div>

        <div class="ventaja">
            <h3>Respuesta Rápida</h3>
            <p>Atención ágil a solicitudes dentro del horario establecido.</p>
        </div>
    </div>
</section>


<!-- ===================== SECCIÓN VIDEO + CTA FINAL ===================== -->
<section class="seccion-cta-final">
    <div class="cta-final-video">
        <video controls poster="<?= BASE_URL ?>/assets/img/logo/logo.png">
            <source src="<?= BASE_URL ?>/assets/videos/inicio.mp4" type="video/mp4">
        </video>
    </div>

    <div class="cta-final-texto">
        <h2>¿Calor insoportable? Ya vamos en camino.</h2>
        <p>Regístrate y solicita tu servicio en minutos, o escríbenos si tienes alguna duda.</p>

        <div class="botones-banner">
            <a href="<?= BASE_URL ?>/?controller=AuthController&method=registro" class="boton-naranja">
                ¡Regístrate ahora!
            </a>
            <a href="<?= BASE_URL ?>/?controller=ContactoController&method=index" class="boton-outline boton-outline-oscuro">
                Contáctanos
            </a>
        </div>
    </div>
</section>
