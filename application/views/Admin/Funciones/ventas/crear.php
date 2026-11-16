
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Registrar venta</h3>
            <p class="text-muted mb-0">Selecciona el cliente y agrega los productos.</p>
        </div>

        <a href="<?= base_url('ventas'); ?>" class="btn btn-outline-secondary">
            Volver
        </a>
    </div>

    <form action="<?= base_url('ventas/guardar'); ?>" method="POST" id="formVenta">

        <!-- INFORMACIÓN DEL CLIENTE -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Información del cliente</h5>

                <label class="form-label">Cliente</label>
                <select name="id_usuario" id="clienteVenta" class="form-select" required>
                    <option value="">Selecciona un cliente</option>

                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?= $cliente->id_usuario; ?>">
                            <?= html_escape($cliente->nombre1 . ' ' . $cliente->apellido1 . ' - ' . $cliente->cedula); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- PRODUCTOS DE LA VENTA -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Productos de la venta</h5>

                    <button type="button" class="btn btn-outline-primary btn-sm" id="agregarProducto">
                        + Agregar producto
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="min-width:220px;">Producto</th>
                                <th>Precio</th>
                                <th>Existencias</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody id="productosVenta">
                            <tr class="fila-producto">
                                <td>
                                    <select name="productos[]" class="form-select producto-select" required>
                                        <option value="">Seleccionar</option>

                                        <?php foreach ($productos as $producto): ?>
                                            <option
                                                value="<?= $producto->id_producto; ?>"
                                                data-precio="<?= $producto->precio; ?>"
                                                data-stock="<?= $producto->cantidad; ?>">
                                                <?= html_escape($producto->nombre_producto); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>

                                <td class="precio">$0</td>
                                <td class="stock">0</td>

                                <td>
                                    <input type="number"
                                           name="cantidades[]"
                                           class="form-control cantidad"
                                           min="1"
                                           value="1"
                                           required>
                                </td>

                                <td class="subtotal">$0</td>

                                <td>
                                    <button type="button" class="btn btn-outline-danger btn-sm eliminarProducto">
                                        X
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- TOTALES -->
                <div class="text-end mt-4">
                    <h5>Subtotal: <span id="subtotalGeneral">$0</span></h5>
                    <h5 class="text-success">
                        Descuento: <span id="descuentoGeneral">$0</span>
                    </h5>
                    <h4 class="fw-bold">
                        Total: <span id="totalGeneral">$0</span>
                    </h4>
                </div>

            </div>
        </div>

        <!-- CUPÓN -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">

                <h5 class="fw-bold mb-3">Cupón de descuento</h5>

                <label class="form-label">Seleccionar cupón</label>

                <select name="id_descuento" id="cuponVenta" class="form-select" disabled>
                    <option value="">Selecciona primero un cliente</option>
                </select>

                <small class="text-muted d-block mt-2" id="informacionCupon">
                    Los cupones disponibles del cliente aparecerán aquí.
                </small>

                <div class="alert alert-info mt-3 mb-0">
                    El valor de compra debe ser igual o superior a 10 veces el valor del cupón.
                </div>

            </div>
        </div>

        <!-- MODALIDAD DE PAGO -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">

                <h5 class="fw-bold mb-3">Modalidad de pago</h5>

                <div class="mb-3">
                    <label class="form-label">Tipo de pago</label>

                    <select name="modalidad_pago" id="modalidadPago" class="form-select" required>
                        <option value="contado">Contado</option>
                        <option value="credito">Crédito</option>
                    </select>
                </div>

                <div id="camposCredito" style="display: none;">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cuota inicial</label>

                            <input
                                type="number"
                                name="cuota_inicial"
                                id="cuotaInicial"
                                class="form-control"
                                min="0"
                                step="100"
                                value="0"
                            >

                            <small class="text-muted">
                                Dinero que el cliente entrega inicialmente.
                            </small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Número de cuotas</label>

                            <input
                                type="number"
                                name="numero_cuotas"
                                id="numeroCuotas"
                                class="form-control"
                                min="1"
                                max="60"
                                value="1"
                            >
                        </div>

                    </div>

                    <div class="alert alert-info mb-0">
                        El saldo restante se financiará y se dividirá entre las cuotas seleccionadas.
                    </div>

                </div>

            </div>
        </div>

        <!-- BOTONES -->
        <div class="d-flex justify-content-end gap-2">

            <a href="<?= base_url('ventas'); ?>" class="btn btn-light">
                Cancelar
            </a>

            <button type="submit" class="btn btn-primary">
                Registrar venta
            </button>

        </div>

    </form>
</div>
