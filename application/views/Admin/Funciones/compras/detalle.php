
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<main class="main-content">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1>Detalle de compra #<?= $compra->id_compra; ?></h1>
            <p class="text-muted mb-0">
                Información de los productos y del proveedor.
            </p>
        </div>

        <a href="<?= base_url('compras'); ?>" class="btn btn-secondary">
            Volver a compras
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="text-muted">Proveedor</label>
                    <h6><?= html_escape($nombre_proveedor); ?></h6>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="text-muted">Fecha de compra</label>
                    <h6><?= date('d/m/Y H:i', strtotime($compra->fecha_compra)); ?></h6>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="text-muted">Estado</label>
                    <h6>
                        <?php if ($compra->estado == 'Pendiente'): ?>
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        <?php elseif ($compra->estado == 'Recibida'): ?>
                            <span class="badge bg-success">Recibida</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Cancelada</span>
                        <?php endif; ?>
                    </h6>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="text-muted">Fecha de recepción</label>
                    <h6>
                        <?= $compra->fecha_recepcion
                            ? date('d/m/Y H:i', strtotime($compra->fecha_recepcion))
                            : 'Sin recibir'; ?>
                    </h6>
                </div>

                <div class="col-12">
                    <label class="text-muted">Observaciones</label>
                    <p>
                        <?= $compra->observaciones
                            ? html_escape($compra->observaciones)
                            : 'Sin observaciones'; ?>
                    </p>
                </div>

            </div>

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-3">Productos adquiridos</h5>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">

                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Cantidad</th>
                            <th>Costo unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($detalles as $detalle): ?>

                            <tr>
                                <td><?= html_escape($detalle->nombre_producto); ?></td>

                                <td><?= html_escape($detalle->categoria); ?></td>

                                <td><?= number_format($detalle->cantidad, 0, ',', '.'); ?></td>

                                <td>
                                    $<?= number_format($detalle->costo_unitario, 0, ',', '.'); ?>
                                </td>

                                <td>
                                    $<?= number_format($detalle->subtotal, 0, ',', '.'); ?>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">TOTAL:</th>
                            <th>
                                $<?= number_format($compra->total, 0, ',', '.'); ?>
                            </th>
                        </tr>
                    </tfoot>

                </table>
            </div>

        </div>
    </div>

</main>
