<section class="admin-module">
    <h1 class="titulo-admin form-titulo">
        <?= isset($repuesto) ? "Editar Repuesto" : "Agregar Nuevo Repuesto" ?>
    </h1>

    <div class="form-contenedor">
        <form action="<?= BASE_URL ?>/index.php?controller=AdminController&method=<?= isset($repuesto) ? 'actualizarRepuesto' : 'guardarRepuesto' ?>"
              method="POST">

            <?php if (isset($repuesto)): ?>
                <input type="hidden" name="id" value="<?= $repuesto['id'] ?>">
            <?php endif; ?>

            <div class="form-grupo">
                <label for="nombre">Nombre del repuesto:</label>
                <input type="text" id="nombre" name="nombre"
                       value="<?= $repuesto['nombre'] ?? '' ?>" required>
            </div>

            <div class="form-grupo">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" required><?= $repuesto['descripcion'] ?? '' ?></textarea>
            </div>

            <div class="form-grupo">
                <label for="precio">Precio (USD):</label>
                <input type="number" id="precio" name="precio" step="0.01" min="0"
                       value="<?= $repuesto['precio'] ?? '' ?>" required>
            </div>

            <div class="form-grupo">
                <label for="stock">Cantidad en stock:</label>
                <input type="number" id="stock" name="stock" min="0"
                       value="<?= $repuesto['stock'] ?? '' ?>" required>
            </div>

            <div class="form-grupo">
                <label for="imagen">Nombre de imagen:</label>
                <input type="text" id="imagen" name="imagen"
                       value="<?= $repuesto['imagen'] ?? '' ?>">
            </div>

            <div class="form-acciones">
                <button type="submit" class="btn-form-guardar">
                    <?= isset($repuesto) ? "Actualizar" : "Crear" ?>
                </button>

                <a href="<?= BASE_URL ?>/?controller=AdminController&method=repuestos"
                   class="btn-form-cancelar">
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</section>
