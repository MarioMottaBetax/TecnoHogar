
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detalle del pago</h2>
            <p class="text-muted mb-0">
                Información del pago registrado #<?= $pago->id_pago; ?>
            </p>
        </div>

        <a href="<?= base_url('pagos'); ?>" class="btn btn-outline-secondary">
            Volver a pagos
        </a>
    </div>

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">Información del pago</h5>

                        <?php if ($pago->estado == 'Aprobado'): ?>
                            <span class="badge bg-success">Aprobado</span>
                        <?php elseif ($pago->estado == 'Pendiente'): ?>
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">
                                <?= html_escape($pago->estado); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="row g-4">

                        <div class="col-md-6">
                            <small class="text-muted">Número de pago</small>
                            <p class="fw-semibold mb-0">
                                #<?= $pago->id_pago; ?>
                            </p>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Fecha de registro</small>
                            <p class="fw-semibold mb-0">
                                <?= date('d/m/Y h:i A', strtotime($pago->fecha)); ?>
                            </p>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Cliente</small>
                            <p class="fw-semibold mb-0">
                                <?= html_escape($pago->nombre_cliente); ?>
                            </p>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Pedido relacionado</small>
                            <p class="fw-semibold mb-0">
                                #<?= $pago->id_pedido; ?>
                            </p>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Método de pago</small>
                            <p class="fw-semibold mb-0">
                                <?= html_escape($pago->metodo); ?>
                            </p>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Comprobante</small>
                            <p class="fw-semibold mb-0">
                                <?= !empty($pago->comprobante)
                                    ? html_escape($pago->comprobante)
                                    : 'No registrado'; ?>
                            </p>
                        </div>

                    </div>

                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">Información relacionada</h5>

                    <?php if (!empty($pago->id_cuota)): ?>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <small class="text-muted">Crédito</small>
                                <p class="fw-semibold mb-0">
                                    #<?= $pago->id_credito; ?>
                                </p>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted">Número de cuota</small>
                                <p class="fw-semibold mb-0">
                                    <?= $pago->numero_cuota; ?>
                                </p>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted">Fecha de vencimiento</small>
                                <p class="fw-semibold mb-0">
                                    <?= date('d/m/Y', strtotime($pago->fecha_vencimiento)); ?>
                                </p>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted">Identificador de cuota</small>
                                <p class="fw-semibold mb-0">
                                    #<?= $pago->id_cuota; ?>
                                </p>
                            </div>

                        </div>

                    <?php else: ?>

                        <div class="alert alert-info mb-0">
                            Este pago no está asociado a una cuota específica.
                            Puede corresponder a un pago inicial o a una venta de contado.
                        </div>

                    <?php endif; ?>

                </div>
            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">

                    <small class="text-muted">Valor del pago</small>

                    <h2 class="fw-bold text-primary my-3">
                        $<?= number_format($pago->monto, 0, ',', '.'); ?>
                    </h2>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Pedido</span>
                        <strong>#<?= $pago->id_pedido; ?></strong>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Estado</span>
                        <strong><?= html_escape($pago->estado); ?></strong>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>
