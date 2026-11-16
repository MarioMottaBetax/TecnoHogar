
<div class="carrito-container">

    <div class="carrito-encabezado">
        <div>
            <h2>Mi carrito</h2>
            <p>Revisa tus productos antes de continuar con tu compra.</p>
        </div>

        <a href="<?= base_url('cliente/productos'); ?>" class="btn btn-outline-primary">
            <i class="bi bi-plus-lg"></i> Seguir comprando
        </a>
    </div>

    <?php if ($this->session->flashdata('exito')): ?>
        <div class="alert alert-success">
            <?= html_escape($this->session->flashdata('exito')); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?= html_escape($this->session->flashdata('error')); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($productos)): ?>

        <div class="carrito-contenido">

            <div class="carrito-lista">

                <?php foreach ($productos as $producto): ?>

                    <div class="carrito-producto">

                        <div class="carrito-producto-icono">
                            <i class="bi bi-box-seam"></i>
                        </div>

                        <div class="carrito-producto-info">
                            <h5><?= html_escape($producto->nombre_producto); ?></h5>
                            <span><?= html_escape($producto->categoria); ?></span>

                            <p class="carrito-precio-unitario">
                                $<?= number_format($producto->precio_unitario, 0, ',', '.'); ?>
                                por unidad
                            </p>

                            <div class="carrito-existencias">
                                Existencias: <?= (int) $producto->existencias; ?>
                            </div>
                        </div>

                        <div class="carrito-producto-acciones">

                            <?= form_open('cliente/carrito/actualizar', array('class' => 'carrito-form-cantidad')); ?>

                                <input type="hidden"
                                       name="id_detalle"
                                       value="<?= (int) $producto->id_detalle; ?>">

                                <input type="number"
                                       name="cantidad"
                                       min="1"
                                       max="<?= (int) $producto->existencias; ?>"
                                       value="<?= (int) $producto->cantidad; ?>"
                                       required>

                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    Actualizar
                                </button>

                            <?= form_close(); ?>

                            <strong class="carrito-subtotal">
                                $<?= number_format($producto->subtotal, 0, ',', '.'); ?>
                            </strong>

                            <?= form_open('cliente/carrito/eliminar'); ?>

                                <input type="hidden"
                                       name="id_detalle"
                                       value="<?= (int) $producto->id_detalle; ?>">

                                <button type="submit"
                                        class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('¿Deseas eliminar este producto del carrito?');">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>

                            <?= form_close(); ?>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

            <div class="carrito-resumen">

                <h4>Resumen de compra</h4>

                <div class="carrito-resumen-fila">
                    <span>Productos</span>
                    <strong><?= count($productos); ?></strong>
                </div>

                <div class="carrito-resumen-fila">
                    <span>Subtotal</span>
                    <strong>
                        $<?= number_format($total, 0, ',', '.'); ?>
                    </strong>
                </div>

                <hr>

                <?= form_open_multipart('cliente/carrito/confirmar', array('id' => 'formCheckout')); ?>

                    <div class="mb-3">
                        <label for="id_descuento" class="form-label fw-semibold">
                            <i class="bi bi-ticket-perforated"></i>
                            Cupón de descuento
                        </label>

                        <select name="id_descuento"
                                id="id_descuento"
                                class="form-select">

                            <option value="">Comprar sin cupón</option>

                            <?php if (!empty($cupones)): ?>
                                <?php foreach ($cupones as $cupon): ?>

                                    <option value="<?= (int) $cupon->id_descuento; ?>"
                                            data-rango="<?= (float) $cupon->rango; ?>">
                                        Cupón #<?= (int) $cupon->id_descuento; ?>
                                        - 10% de descuento
                                        (Compra mínima:
                                        $<?= number_format($cupon->rango, 0, ',', '.'); ?>)
                                    </option>

                                <?php endforeach; ?>
                            <?php endif; ?>

                        </select>

                        <?php if (empty($cupones)): ?>
                            <small class="text-muted">
                                No tienes cupones disponibles actualmente.
                            </small>
                        <?php else: ?>
                            <small class="text-muted">
                                Tu cupón aplica un 10% de descuento si cumples la compra mínima.
                            </small>
                        <?php endif; ?>
                    </div>

                    <div class="carrito-resumen-fila">
                        <span>Descuento</span>
                        <strong id="valorDescuento">$0</strong>
                    </div>

                    <div class="carrito-resumen-fila carrito-total">
                        <span>Total a pagar</span>
                        <strong id="totalFinal">
                            $<?= number_format($total, 0, ',', '.'); ?>
                        </strong>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label for="metodo" class="form-label fw-semibold">
                            <i class="bi bi-credit-card"></i>
                            Método de pago
                        </label>

                        <select name="metodo"
                                id="metodo"
                                class="form-select"
                                required>

                            <option value="">Selecciona un método</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia / Consignación">Transferencia / consignación</option>
                            <option value="Débito">Débito</option>
                            <option value="Crédito">Crédito</option>

                        </select>
                    </div>

                    <div class="mb-3" id="contenedorCuotas" hidden>
                        <label for="numero_cuotas" class="form-label fw-semibold">
                            <i class="bi bi-calendar3"></i>
                            Número de cuotas
                        </label>

                        <select name="numero_cuotas"
                                id="numero_cuotas"
                                class="form-select">
                            <option value="">Selecciona las cuotas</option>
                            <option value="3">3 cuotas</option>
                            <option value="6">6 cuotas</option>
                            <option value="9">9 cuotas</option>
                            <option value="12">12 cuotas</option>
                            <option value="18">18 cuotas</option>
                            <option value="24">24 cuotas</option>
                        </select>

                        <small class="text-muted">
                            Las cuotas se crearán automáticamente al confirmar la compra.
                        </small>
                    </div>

                    <div class="mb-3" id="contenedorComprobante">

                        <label for="comprobante" class="form-label fw-semibold">
                            <i class="bi bi-file-earmark-arrow-up"></i>
                            Comprobante de pago
                        </label>

                        <input type="file"
                               name="comprobante"
                               id="comprobante"
                               class="form-control"
                               accept=".jpg,.jpeg,.png,.pdf">

                        <small class="text-muted">
                            Obligatorio para transferencia o consignación.
                            Formatos: JPG, PNG o PDF. Máximo 5 MB.
                        </small>

                    </div>

                    <button type="submit"
                            class="btn btn-primary w-100"
                            onclick="return confirm('¿Deseas confirmar tu compra?');">

                        <i class="bi bi-check-circle"></i>
                        Confirmar compra

                    </button>

                <?= form_close(); ?>

                <div class="alert alert-info mt-3 mb-0">
                    <small>
                        Tu pedido quedará pendiente de revisión.
                        Si seleccionas transferencia o consignación,
                        deberás adjuntar el comprobante.
                    </small>
                </div>

            </div>

        </div>

    <?php else: ?>

        <div class="carrito-vacio">
            <i class="bi bi-cart-x"></i>
            <h3>Tu carrito está vacío</h3>
            <p>¡Explora nuestro catálogo y encuentra algo que te guste!</p>

            <a href="<?= base_url('cliente/productos'); ?>" class="btn btn-primary">
                Explorar productos
            </a>
        </div>

    <?php endif; ?>

</div>  

<script>
document.addEventListener('DOMContentLoaded', function () {
    var metodo = document.getElementById('metodo');
    var comprobante = document.getElementById('comprobante');
    var contenedorComprobante = document.getElementById('contenedorComprobante');
    var contenedorCuotas = document.getElementById('contenedorCuotas');
    var cuotas = document.getElementById('numero_cuotas');

    function actualizarCheckout() {
        var esTransferencia = metodo.value === 'Transferencia / Consignación';
        var esCredito = metodo.value === 'Crédito';

        contenedorComprobante.hidden = !esTransferencia;
        comprobante.required = esTransferencia;
        contenedorCuotas.hidden = !esCredito;
        cuotas.required = esCredito;

        if (!esCredito) {
            cuotas.value = '';
        }
    }

    metodo.addEventListener('change', actualizarCheckout);
    actualizarCheckout();
});
</script>
