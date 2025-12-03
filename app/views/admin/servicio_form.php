<section class="admin-module">
    <h1 class="titulo-admin form-titulo">
        <?= isset($servicio) ? "Editar Servicio" : "Agregar Nuevo Servicio" ?>
    </h1>

    <div class="form-contenedor">
        <form action="<?= BASE_URL ?>/index.php?controller=AdminController&method=<?= isset($servicio) ? 'actualizarServicio' : 'guardarServicio' ?>"
              method="POST">

            <?php if (isset($servicio)): ?>
                <input type="hidden" name="id" value="<?= $servicio['id'] ?>">
            <?php endif; ?>

            <!-- Nombre -->
            <div class="form-grupo">
                <label for="nombre">Nombre del servicio:</label>
                <input type="text" id="nombre" name="nombre"
                       value="<?= isset($servicio) ? htmlspecialchars($servicio['nombre']) : '' ?>"
                       required>
            </div>

            <!-- Descripción -->
            <div class="form-grupo">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" required><?= isset($servicio) ? htmlspecialchars($servicio['descripcion']) : '' ?></textarea>
            </div>

            <!-- Precio -->
            <div class="form-grupo">
                <label for="precio">Precio (USD):</label>
                <input type="number" step="0.01" min="0"
                       id="precio" name="precio"
                       value="<?= isset($servicio) ? $servicio['precio'] : '' ?>"
                       required>
            </div>

            <!-- Botones -->
            <div class="form-acciones">
                <button type="submit" class="btn-form-guardar">
                    <?= isset($servicio) ? "Actualizar" : "Crear" ?>
                </button>

                <a href="<?= BASE_URL ?>/index.php?controller=AdminController&method=servicios"
                   class="btn-form-cancelar">
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</section>
