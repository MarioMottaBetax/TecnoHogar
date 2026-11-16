
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Detalle del pago</h3>
            <p class="text-muted mb-0">
                Información del pago seleccionado.
            </p>
        </div>

        <a href="<?= base_url('cliente/pagos'); ?>"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <?php
    $estado = strtolower(trim($pago->estado));

    $clase = 'bg-secondary';

    if ($estado == 'aprobado') {
        $clase = 'bg-success';
    } elseif ($estado == 'pendiente') {
        $clase = 'bg-warning text-dark';
    } elseif ($estado == 'rechazado') {
        $clase = 'bg-danger';
    }
    ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">
                    Pago #<?= $pago->id_pago; ?>
                </h5>

                <span class="badge <?= $clase; ?> fs-6">
                    <?= html_escape($pago->estado); ?>
                </span>
            </div>

            <div class="row g-4">

                <div class="col-md-6">
                    <small class="text-muted">Número de pedido</small>
                    <h6>#<?= $pago->id_pedido; ?></h6>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Número de cuota</small>
                    <h6>
                        <?= $pago->id_cuota
                            ? '#'.$pago->id_cuota
                            : 'No aplica'; ?>
                    </h6>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Fecha del pago</small>
                    <h6>
                        <?= date('d/m/Y H:i', strtotime($pago->fecha)); ?>
                    </h6>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Método de pago</small>
                    <h6><?= html_escape($pago->metodo); ?></h6>
                </div>

                <div class="col-md-12">
                    <small class="text-muted">Monto</small>
                    <h3 class="fw-bold text-primary">
                        $<?= number_format($pago->monto, 0, ',', '.'); ?>
                    </h3>
                </div>

                <div class="col-md-12">
                    <small class="text-muted">Comprobante</small>

                    <?php if (!empty($pago->comprobante)): ?>

                        <div class="mt-2">
                            <a href="<?= base_url($pago->comprobante); ?>"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="btn btn-outline-primary">
                                <i class="bi bi-file-earmark-text"></i>
                                Ver comprobante
                            </a>
                        </div>

                    <?php else: ?>

                        <p class="text-muted mb-0">
                            No hay comprobante adjunto.
                        </p>

                    <?php endif; ?>
                </div>

            </div>

        </div>
    </div>

</div>
