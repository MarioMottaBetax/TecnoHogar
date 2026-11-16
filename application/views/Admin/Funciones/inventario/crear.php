
<main class="main-content">

    <div class="page-heading">
        <div>
            <h1>Registrar producto</h1>
            <p>Agrega un nuevo producto al inventario de TecnoHogar.</p>
        </div>

        <a href="<?= base_url('inventario'); ?>" class="btn btn-outline-secondary">
            ← Volver al inventario
        </a>
    </div>

    <?php if (validation_errors()): ?>
        <div class="alert alert-danger">
            <strong>Revisa los siguientes campos:</strong>
            <?= validation_errors(); ?>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <div class="mb-4">
                <h5 class="fw-bold mb-1">Información del producto</h5>
                <p class="text-muted mb-0">
                    Completa los datos para registrar el producto.
                </p>
            </div>

            <?= form_open('inventario/guardar'); ?>

                <div class="row g-3">

                    <!-- Nombre -->
                    <div class="col-md-6">
                        <label for="nombre_producto" class="form-label fw-semibold">
                            Nombre del producto *
                        </label>

                        <input
                            type="text"
                            name="nombre_producto"
                            id="nombre_producto"
                            class="form-control"
                            maxlength="100"
                            placeholder="Ej. Televisor Samsung 55 pulgadas"
                            value="<?= set_value('nombre_producto'); ?>"
                            required>
                    </div>

                    <!-- Categoría -->
                    <div class="col-md-6">
                        <label for="categoria" class="form-label fw-semibold">
                            Categoría *
                        </label>

                        <input
                            type="text"
                            name="categoria"
                            id="categoria"
                            class="form-control"
                            maxlength="60"
                            placeholder="Ej. Televisores"
                            value="<?= set_value('categoria'); ?>"
                            required>
                    </div>

                    <!-- Precio -->
                    <div class="col-md-6">
                        <label for="precio" class="form-label fw-semibold">
                            Precio de venta (COP) *
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input
                                type="number"
                                name="precio"
                                id="precio"
                                class="form-control"
                                min="0.01"
                                step="0.01"
                                placeholder="0.00"
                                value="<?= set_value('precio'); ?>"
                                required>
                        </div>
                    </div>

                    <!-- Garantía -->
                    <div class="col-md-6">
                        <label for="garantia" class="form-label fw-semibold">
                            Garantía (meses) *
                        </label>

                        <input
                            type="number"
                            name="garantia"
                            id="garantia"
                            class="form-control"
                            min="0"
                            step="1"
                            placeholder="Ej. 12"
                            value="<?= set_value('garantia', '0'); ?>"
                            required>
                    </div>

                    <!-- Cantidad -->
                    <div class="col-md-6">
                        <label for="cantidad" class="form-label fw-semibold">
                            Cantidad inicial *
                        </label>

                        <input
                            type="number"
                            name="cantidad"
                            id="cantidad"
                            class="form-control"
                            min="0"
                            step="1"
                            placeholder="Ej. 20"
                            value="<?= set_value('cantidad', '0'); ?>"
                            required>
                    </div>

                    <!-- Detalles -->
                    <div class="col-12">
                        <label for="modelo_detalle" class="form-label fw-semibold">
                            Modelo y detalles
                        </label>

                        <textarea
                            name="modelo_detalle"
                            id="modelo_detalle"
                            class="form-control"
                            rows="4"
                            placeholder="Marca, referencia, características y especificaciones..."><?= set_value('modelo_detalle'); ?></textarea>

                        <small class="text-muted">
                            Campo opcional. Puedes incluir información adicional del producto.
                        </small>
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">

                    <a href="<?= base_url('inventario'); ?>"
                       class="btn btn-light border">
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary px-4">
                        Guardar producto
                    </button>

                </div>

            <?= form_close(); ?>

        </div>
    </div>

</main>
