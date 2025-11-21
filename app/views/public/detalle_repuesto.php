<section class="detalle-repuesto">
    <h1 class="titulo-principal texto-centrado">Detalle del Repuesto</h1>

    <div class="card-detalle">

        <img src="<?= BASE_URL ?>/assets/img/repuestos/default.jpg" class="img-detalle">

        <div class="info-detalle">
            <h2>Nombre del Repuesto (Estático por ahora)</h2>

            <p class="precio">$00.00</p>
            <p class="stock">Stock: X unidades</p>

            <p class="descripcion">
                Aquí irá la descripción completa del repuesto.
                Por ahora este texto es de prueba.
            </p>

            <a href="<?= BASE_URL ?>/?controller=RepuestoController&method=index"
               class="boton-secundario">
               ← Volver al catálogo
            </a>
        </div>

    </div>
</section>
