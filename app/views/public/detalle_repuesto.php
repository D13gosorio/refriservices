<section class="detalle-repuesto">
    <h1 class="titulo-principal texto-centrado"><?= $repuesto["nombre"] ?></h1>

    <div class="card-detalle">

        <img src="<?= BASE_URL ?>/assets/img/repuestos/<?= $repuesto['imagen'] ?>" class="img-detalle">

        <div class="info-detalle">
            <h2><?= $repuesto["nombre"] ?></h2>

            <p class="precio">$<?= $repuesto["precio"] ?></p>
            <p class="stock">Stock: <?= $repuesto["stock"] ?> unidades</p>

            <p class="descripcion"><?= $repuesto["descripcion"] ?></p>

            <a href="<?= BASE_URL ?>/?controller=RepuestoController&method=index"
               class="boton-secundario">
               ← Volver al catálogo
            </a>
        </div>

    </div>
</section>

