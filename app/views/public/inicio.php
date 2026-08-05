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


<!-- ===================== BARRA DE CONFIANZA ===================== -->
<section class="barra-confianza">
    <div class="grid-confianza">
        <div class="dato-confianza">
            <span class="dato-numero">+10</span>
            <span class="dato-texto">Años de experiencia</span>
        </div>
        <div class="dato-confianza">
            <span class="dato-numero">100%</span>
            <span class="dato-texto">Técnicos certificados</span>
        </div>
        <div class="dato-confianza">
            <span class="dato-numero">24-48h</span>
            <span class="dato-texto">Tiempo de respuesta</span>
        </div>
        <div class="dato-confianza">
            <span class="dato-numero">📍</span>
            <span class="dato-texto">Aguadulce y alrededores</span>
        </div>
    </div>
</section>


<!-- ===================== SECCIÓN: ¿QUÉ HACEMOS? ===================== -->
<section class="seccion-servicios">
    <h2 class="titulo-seccion">¿Qué hacemos?</h2>
    <p class="subtitulo-seccion texto-centrado">
        Soluciones completas de climatización, desde la primera instalación hasta el mantenimiento periódico.
    </p>

    <div class="grid-3-tarjetas">
        <article class="tarjeta-servicio">
            <div class="icono">🛠️</div>
            <h3>Instalación</h3>
            <p>Instalación profesional de sistemas de aire acondicionado y refrigeración, residencial y comercial.</p>
        </article>

        <article class="tarjeta-servicio">
            <div class="icono">🔧</div>
            <h3>Reparación</h3>
            <p>Diagnóstico y reparación de fallas eléctricas y mecánicas en equipos domésticos y comerciales.</p>
        </article>

        <article class="tarjeta-servicio">
            <div class="icono">⚙️</div>
            <h3>Mantenimiento</h3>
            <p>Mantenimiento preventivo y correctivo para alargar la vida útil de tus sistemas y bajar el consumo eléctrico.</p>
        </article>
    </div>
</section>


<!-- ===================== SECCIÓN: CÓMO TRABAJAMOS ===================== -->
<section class="seccion-proceso">
    <h2 class="titulo-seccion">¿Cómo funciona?</h2>
    <p class="subtitulo-seccion texto-centrado">
        De la solicitud al servicio completado, en cuatro pasos simples.
    </p>

    <div class="grid-proceso">
        <div class="paso-proceso">
            <span class="paso-numero">1</span>
            <h3>Solicita tu servicio</h3>
            <p>Crea tu cuenta y elige el servicio que necesitas desde el catálogo.</p>
        </div>

        <div class="paso-proceso">
            <span class="paso-numero">2</span>
            <h3>Confirmamos la cita</h3>
            <p>Nuestro equipo revisa tu solicitud y coordina la fecha de visita contigo.</p>
        </div>

        <div class="paso-proceso">
            <span class="paso-numero">3</span>
            <h3>Visita del técnico</h3>
            <p>Un técnico certificado llega a tu domicilio o negocio con el equipo necesario.</p>
        </div>

        <div class="paso-proceso">
            <span class="paso-numero">4</span>
            <h3>Servicio completado</h3>
            <p>Revisas el estado de tu solicitud en todo momento desde "Mis solicitudes".</p>
        </div>
    </div>
</section>


<!-- ===================== SECCIÓN VIDEO ===================== -->
<section class="seccion-video">
    <div class="contenedor-video">
        <h2 class="titulo-seccion">Conócenos en acción</h2>
        <p class="subtitulo-seccion texto-centrado">
            Así trabajamos: rápido, ordenado y con equipo profesional.
        </p>

        <div class="video-wrapper">
            <video controls preload="metadata">
                <source src="<?= BASE_URL ?>/assets/videos/inicio.mp4" type="video/mp4">
            </video>
        </div>
    </div>
</section>


<!-- ===================== SECCIÓN: ¿POR QUÉ ELEGIRNOS? ===================== -->
<section class="seccion-ventajas">
    <h2 class="titulo-seccion">¿Por qué elegirnos?</h2>

    <div class="grid-3-ventajas">
        <div class="ventaja">
            <div class="icono">🎓</div>
            <h3>Técnicos Certificados</h3>
            <p>Personal capacitado en las últimas tecnologías de refrigeración.</p>
        </div>

        <div class="ventaja">
            <div class="icono">🤝</div>
            <h3>Atención Personalizada</h3>
            <p>Soluciones adaptadas a cada cliente con un trato profesional.</p>
        </div>

        <div class="ventaja">
            <div class="icono">⚡</div>
            <h3>Respuesta Rápida</h3>
            <p>Atención ágil a solicitudes dentro del horario establecido.</p>
        </div>

        <div class="ventaja">
            <div class="icono">✅</div>
            <h3>Garantía en el Servicio</h3>
            <p>Respaldamos cada instalación y reparación que realizamos.</p>
        </div>
    </div>
</section>


<!-- ===================== SECCIÓN: ZONA DE COBERTURA ===================== -->
<section class="seccion-cobertura">
    <div class="cobertura-contenido">
        <h2 class="titulo-seccion">Zona de cobertura</h2>
        <p>
            Atendemos Aguadulce y sus alrededores, con visitas
            programadas a domicilios, comercios, escuelas y oficinas.
        </p>

        <ul class="lista-cobertura">
            <li>📍 Aguadulce y alrededores</li>
        </ul>

        <p class="texto-pequeno">¿No ves tu zona en la lista? Escríbenos y confirmamos disponibilidad.</p>
    </div>
</section>
