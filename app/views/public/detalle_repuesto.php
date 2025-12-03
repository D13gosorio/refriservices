<section class="detalle-repuesto">

    <div class="card-detalle">

        <?php
            // Detectar si es URL externa
            if (preg_match('/^https?:\/\//', $repuesto["imagen"])) {
                $rutaImagen = $repuesto["imagen"];
            } else {
                $rutaImagen = BASE_URL . "/assets/img/repuestos/" . $repuesto["imagen"];
            }
        ?>

        <img src="<?= htmlspecialchars($rutaImagen) ?>" 
             class="img-detalle" 
             alt="Imagen de <?= htmlspecialchars($repuesto['nombre']) ?>">

        <div class="info-detalle">
            <h2><?= htmlspecialchars($repuesto["nombre"]) ?></h2>

            <p class="precio">$<?= $repuesto["precio"] ?></p>
            <p class="stock">Stock: <?= $repuesto["stock"] ?> unidades</p>

            <p class="descripcion"><?= htmlspecialchars($repuesto["descripcion"]) ?></p>

            <a href="<?= BASE_URL ?>/?controller=RepuestoController&method=index"
               class="boton-secundario">
               ← Volver al catálogo
            </a>
        </div>

    </div>
</section>
