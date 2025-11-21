<!-- ===================== TÍTULO ===================== -->
<section class="seccion-servicios-principal">
    <h1 class="titulo-principal">Servicios Disponibles</h1>
    <p class="descripcion-subtitulo">
        Ofrecemos instalación, mantenimiento y reparación profesional para hogares y negocios.
    </p>
</section>

<!-- ===================== ACCESO A MIS SOLICITUDES ===================== -->
<section class="bloque-mis-solicitudes">
    <p>¿Ya has solicitado un servicio anteriormente?</p>
    <a href="<?= BASE_URL ?>/?controller=MisSolicitudesController&method=index"
        class="btn-mis-solicitudes">
        Ver historial de mis solicitudes
    </a>

</section>

<!-- ===================== LISTADO DE SERVICIOS ===================== -->
<section class="lista-servicios">
    
    <!-- Servicio 1 -->
    <article class="item-servicio">
        <div class="contenido-servicio">
            <h3>Instalación de Aires Acondicionados</h3>
            <p>Instalación profesional, segura y garantizada para equipos domésticos y comerciales.</p>
            <p class="precio-servicio">$60.00</p>
        </div>

        <div class="boton-servicio">
            <a href="<?= BASE_URL ?>/?controller=SolicitudController&method=formulario&id_servicio=1"
                class="boton-accion">
                Solicitar
            </a>        
        </div>
    </article>

    <!-- Servicio 2 -->
    <article class="item-servicio">
        <div class="contenido-servicio">
            <h3>Mantenimiento Preventivo</h3>
            <p>Limpieza general, revisión de filtros y optimización del rendimiento del equipo.</p>
            <p class="precio-servicio">$30.00</p>
        </div>

        <div class="boton-servicio">
            <a href="<?= BASE_URL ?>/?controller=SolicitudController&method=formulario&id_servicio=2"
                class="boton-accion">
                Solicitar
            </a>
        </div>
    </article>

    <!-- Servicio 3 -->
    <article class="item-servicio">
        <div class="contenido-servicio">
            <h3>Reparación de Equipos</h3>
            <p>Diagnóstico completo, reemplazo de piezas, corrección de fugas y más.</p>
            <p class="precio-servicio">$45.00</p>
        </div>

        <div class="boton-servicio">
            <a href="<?= BASE_URL ?>/?controller=SolicitudController&method=formulario&id_servicio=3"
                class="boton-accion">
                Solicitar
            </a>
        </div>
    </article>

</section>
