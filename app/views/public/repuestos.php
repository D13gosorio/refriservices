<!-- ===================== TÍTULO ===================== -->
<section class="seccion-repuestos">
    <h1 class="titulo-principal texto-centrado">Catálogo de Repuestos</h1>
    <p class="texto-centrado descripcion-subtitulo">
        Todas las piezas que necesitas para tu aire acondicionado.
    </p>
</section>

<!-- ===================== ORDENAMIENTOS ===================== -->
<section class="ordenamiento-repuestos">
    <label for="ordenar">Ordenar por:</label>

    <select id="ordenar">
        <option value="nombre_asc">Nombre (A-Z)</option>
        <option value="nombre_desc">Nombre (Z-A)</option>
        <option value="precio_asc">Precio (menor a mayor)</option>
        <option value="precio_desc">Precio (mayor a menor)</option>
        <option value="stock_asc">Stock (menor a mayor)</option>
        <option value="stock_desc">Stock (mayor a menor)</option>
    </select>
</section>

<script src="<?= BASE_URL ?>/assets/js/repuestos.js"></script>


<!-- ===================== CATÁLOGO (Simulacion por el momento) ===================== -->
<section class="grid-repuestos">

    <!-- Repuesto 1 -->
    <article class="card-repuesto">
        <img src="<?= BASE_URL ?>/assets/img/repuestos/default.jpg" alt="Repuesto" class="img-repuesto">

        <h3>Filtro Lavable Universal</h3>
        <p class="precio">$12.50</p>
        <p class="stock">Stock: 14 unidades</p>

        <a href="<?= BASE_URL ?>/?controller=RepuestoController&method=detalle&id=1" class="boton-detalle">
            Ver detalle
        </a>
    </article>

    <!-- Repuesto 2 -->
    <article class="card-repuesto">
        <img src="<?= BASE_URL ?>/assets/img/repuestos/default.jpg" alt="Repuesto" class="img-repuesto">

        <h3>Motor Ventilador 1/5 HP</h3>
        <p class="precio">$45.00</p>
        <p class="stock">Stock: 6 unidades</p>

        <a href="<?= BASE_URL ?>/?controller=RepuestoController&method=detalle&id=2" class="boton-detalle">
            Ver detalle
        </a>
    </article>

    <!-- Repuesto 3 -->
    <article class="card-repuesto">
        <img src="<?= BASE_URL ?>/assets/img/repuestos/default.jpg" alt="Repuesto" class="img-repuesto">

        <h3>Control Remoto Universal</h3>
        <p class="precio">$18.00</p>
        <p class="stock">Stock: 22 unidades</p>

        <a href="<?= BASE_URL ?>/?controller=RepuestoController&method=detalle&id=3" class="boton-detalle">
            Ver detalle
        </a>
    </article>

        <!-- Repuesto 4 -->
    <article class="card-repuesto">
        <img src="<?= BASE_URL ?>/assets/img/repuestos/default.jpg" alt="Repuesto" class="img-repuesto">

        <h3>Control Remoto Universal</h3>
        <p class="precio">$18.00</p>
        <p class="stock">Stock: 22 unidades</p>

        <a href="<?= BASE_URL ?>/?controller=RepuestoController&method=detalle&id=3" class="boton-detalle">
            Ver detalle
        </a>
    </article>

        <!-- Repuesto 5 -->
    <article class="card-repuesto">
        <img src="<?= BASE_URL ?>/assets/img/repuestos/default.jpg" alt="Repuesto" class="img-repuesto">

        <h3>Control Remoto Universal</h3>
        <p class="precio">$18.00</p>
        <p class="stock">Stock: 22 unidades</p>

        <a href="<?= BASE_URL ?>/?controller=RepuestoController&method=detalle&id=3" class="boton-detalle">
            Ver detalle
        </a>
    </article>

        <!-- Repuesto 6 -->
    <article class="card-repuesto">
        <img src="<?= BASE_URL ?>/assets/img/repuestos/default.jpg" alt="Repuesto" class="img-repuesto">

        <h3>Control Remoto Universal</h3>
        <p class="precio">$18.00</p>
        <p class="stock">Stock: 22 unidades</p>

        <a href="<?= BASE_URL ?>/?controller=RepuestoController&method=detalle&id=3" class="boton-detalle">
            Ver detalle
        </a>
    </article>

        <!-- Repuesto 7 -->
    <article class="card-repuesto">
        <img src="<?= BASE_URL ?>/assets/img/repuestos/default.jpg" alt="Repuesto" class="img-repuesto">

        <h3>Control Remoto Universal</h3>
        <p class="precio">$18.00</p>
        <p class="stock">Stock: 22 unidades</p>

        <a href="<?= BASE_URL ?>/?controller=RepuestoController&method=detalle&id=3" class="boton-detalle">
            Ver detalle
        </a>
    </article>

        <!-- Repuesto 8 -->
    <article class="card-repuesto">
        <img src="<?= BASE_URL ?>/assets/img/repuestos/default.jpg" alt="Repuesto" class="img-repuesto">

        <h3>Control Remoto Universal</h3>
        <p class="precio">$18.00</p>
        <p class="stock">Stock: 22 unidades</p>

        <a href="<?= BASE_URL ?>/?controller=RepuestoController&method=detalle&id=3" class="boton-detalle">
            Ver detalle
        </a>
    </article>

</section>
