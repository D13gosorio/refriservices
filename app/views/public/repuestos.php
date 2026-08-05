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


<!-- ===================== CATÁLOGO  ===================== -->
<section class="grid-repuestos">

<?php foreach ($repuestos as $r): ?>

    <?php
        // Detectar si es URL completa
        if (preg_match('/^https?:\/\//', $r["imagen"])) {
            $rutaImagen = $r["imagen"]; // URL externa
        } else {
            $rutaImagen = BASE_URL . "/assets/img/repuestos/" . $r["imagen"]; // Imagen local
        }
    ?>

    <article class="card-repuesto">
        <img src="<?= htmlspecialchars($rutaImagen) ?>" 
             alt="Imagen repuesto" 
             class="img-repuesto">

        <h3><?= htmlspecialchars($r["nombre"]) ?></h3>

        <p class="precio">$<?= $r["precio"] ?></p>
        <p class="stock">Stock: <?= $r["stock"] ?> unidades</p>

        <a href="<?= BASE_URL ?>/?controller=RepuestoController&method=detalle&id=<?= $r['id'] ?>" 
           class="boton-detalle">
           Ver detalle
        </a>
    </article>

<?php endforeach; ?>

</section>
