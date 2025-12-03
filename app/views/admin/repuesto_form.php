<section class="admin-module">
    <h1 class="titulo-admin">
        <?= $repuesto ? "Editar Repuesto" : "Agregar Repuesto" ?>
    </h1>

    <div class="form-contenedor">
        <form action="<?= BASE_URL ?>/?controller=AdminController&method=<?= $repuesto ? "actualizarRepuesto" : "guardarRepuesto" ?>"
              method="POST">

            <?php if ($repuesto): ?>
                <input type="hidden" name="id" value="<?= $repuesto['id'] ?>">
            <?php endif; ?>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre"
                   value="<?= $repuesto['nombre'] ?? '' ?>" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" rows="4" required><?= $repuesto['descripcion'] ?? '' ?></textarea>

            <label for="precio">Precio:</label>
            <input type="number" step="0.01" name="precio" id="precio"
                   value="<?= $repuesto['precio'] ?? '' ?>" required>

            <label for="stock">Cantidad en stock:</label>
            <input type="number" name="stock" id="stock"
                   value="<?= $repuesto['stock'] ?? '' ?>" required>

            <label for="imagen">Nombre del archivo de imagen:</label>
            <input type="text" name="imagen" id="imagen"
                   value="<?= $repuesto['imagen'] ?? 'default.jpg' ?>">

            <button type="submit" class="btn-primary">
                <?= $repuesto ? "Actualizar" : "Crear" ?>
            </button>

        </form>
    </div>
</section>
