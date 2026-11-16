<div class="catalogo-container">

    <a href="<?= base_url('cliente/productos'); ?>"
       class="btn btn-light mb-4">

        <i class="bi bi-arrow-left"></i>
        Volver al catálogo

    </a>

    <div class="row g-4">

        <div class="col-md-5">

            <div class="producto-imagen"
                 style="height: 350px; border-radius: 12px;">

                <i class="bi bi-box-seam" style="font-size: 100px;"></i>

            </div>

        </div>

        <div class="col-md-7">

            <span class="producto-categoria">
                <?= html_escape($producto->categoria); ?>
            </span>

            <h2 class="mt-2">
                <?= html_escape($producto->nombre_producto); ?>
            </h2>

            <h3 class="producto-precio mt-3">
                $<?= number_format($producto->precio, 0, ',', '.'); ?>
            </h3>

            <hr>

            <p>
                <strong>Descripción:</strong><br>

                <?= !empty($producto->modelo_detalle)
                    ? nl2br(html_escape($producto->modelo_detalle))
                    : 'No hay descripción registrada.'; ?>
            </p>

            <p>
                <strong>Garantía:</strong>
                <?= (int) $producto->garantia; ?> meses
            </p>

            <p>
                <strong>Existencias:</strong>
                <?= (int) $producto->cantidad; ?>
            </p>

            <?php if ($producto->cantidad > 0): ?>

    <?= form_open('cliente/carrito/agregar', ['class' => 'detalle-comprar-form']); ?>

        <input
            type="hidden"
            name="id_producto"
            value="<?= (int) $producto->id_producto; ?>"
        >

        <label for="cantidad">Cantidad</label>

        <input
            type="number"
            name="cantidad"
            id="cantidad"
            class="form-control"
            value="1"
            min="1"
            max="<?= (int) $producto->cantidad; ?>"
            required
        >

        <button
            type="submit"
            name="destino"
            value="carrito"
            class="btn btn-primary"
        >
            <i class="bi bi-cart-plus"></i>
            Añadir al carrito
        </button>

        <button
            type="submit"
            name="destino"
            value="comprar"
            class="btn btn-success"
        >
            <i class="bi bi-bag-check"></i>
            Comprar ahora
        </button>

    <?= form_close(); ?>

<?php else: ?>

    <button class="btn btn-secondary" disabled>
        Producto agotado
    </button>

<?php endif; ?>

            <?php if ($producto->cantidad > 0): ?>

                <span class="badge bg-success">
                    Disponible
                </span>

            <?php else: ?>

                <span class="badge bg-danger">
                    Agotado
                </span>

            <?php endif; ?>

        </div>

    </div>

</div>