
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Detalle de venta #<?= $venta->id_pedido; ?></h3>
            <p class="text-muted mb-0">Información completa de la venta.</p>
        </div>

        <a href="<?= base_url('ventas'); ?>" class="btn btn-outline-secondary">
            Volver a ventas
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-4">
                    <small class="text-muted">Cliente</small>
                    <h6 class="fw-bold">
                        <?= html_escape($venta->nombre1 . ' ' . $venta->apellido1); ?>
                    </h6>
                </div>

                <div class="col-md-4">
                    <small class="text-muted">Cédula</small>
                    <h6><?= html_escape($venta->cedula); ?></h6>
                </div>

                <div class="col-md-4">
                    <small class="text-muted">Correo</small>
                    <h6><?= html_escape($venta->correo); ?></h6>
                </div>

                <div class="col-md-4">
                    <small class="text-muted">Fecha</small>
                    <h6><?= date('d/m/Y H:i', strtotime($venta->fecha)); ?></h6>
                </div>

                <div class="col-md-4">
                    <small class="text-muted">Estado</small>
                    <h6>
                        <span class="badge bg-success">
                            <?= html_escape(ucfirst($venta->estado)); ?>
                        </span>
                    </h6>
                </div>

                <div class="col-md-4">
                    <small class="text-muted">Total</small>
                    <h5 class="fw-bold text-primary">
                        $<?= number_format($venta->total, 0, ',', '.'); ?>
                    </h5>
                </div>

            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Productos vendidos</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th>Precio unitario</th>
                            <th>Cantidad</th>
                            <th>Garantía</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($detalles as $detalle): ?>
                            <tr>
                                <td><?= html_escape($detalle->nombre_producto); ?></td>

                                <td>
                                    $<?= number_format($detalle->precio_unitario, 0, ',', '.'); ?>
                                </td>

                                <td><?= $detalle->cantidad; ?></td>

                                <td><?= (int) $detalle->garantia; ?> meses</td>

                                <td class="fw-bold">
                                    $<?= number_format($detalle->subtotal, 0, ',', '.'); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-end mt-3">
                <h4 class="fw-bold">
                    Total: $<?= number_format($venta->total, 0, ',', '.'); ?>
                </h4>
            </div>
        </div>
    </div>

</div>
