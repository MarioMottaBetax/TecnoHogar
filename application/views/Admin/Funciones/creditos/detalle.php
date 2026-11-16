
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Detalle del crédito #<?= $credito->id_credito; ?></h3>
            <p class="text-muted mb-0">Información de financiación y estado de las cuotas.</p>
        </div>

        <a href="<?= base_url('creditos'); ?>" class="btn btn-outline-secondary">
            Volver
        </a>
    </div>

    <!-- INFORMACIÓN DEL CLIENTE -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">

            <h5 class="fw-bold mb-3">Información del cliente</h5>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <small class="text-muted">Cliente</small>
                    <p class="fw-semibold mb-0">
                        <?= html_escape($credito->nombre1 . ' ' . $credito->apellido1); ?>
                    </p>
                </div>

                <div class="col-md-4 mb-3">
                    <small class="text-muted">Cédula</small>
                    <p class="fw-semibold mb-0">
                        <?= html_escape($credito->cedula); ?>
                    </p>
                </div>

                <div class="col-md-4 mb-3">
                    <small class="text-muted">Correo</small>
                    <p class="fw-semibold mb-0">
                        <?= html_escape($credito->correo); ?>
                    </p>
                </div>

                <div class="col-md-4 mb-3">
                    <small class="text-muted">Pedido asociado</small>
                    <p class="fw-semibold mb-0">#<?= $credito->id_pedido; ?></p>
                </div>

                <div class="col-md-4 mb-3">
                    <small class="text-muted">Fecha de venta</small>
                    <p class="fw-semibold mb-0">
                        <?= date('d/m/Y', strtotime($credito->fecha)); ?>
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- RESUMEN FINANCIERO -->
    <div class="row mb-4">

        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Valor financiado</small>
                    <h4 class="fw-bold mt-2">
                        $<?= number_format($credito->monto_total, 0, ',', '.'); ?>
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Total abonado</small>
                    <h4 class="fw-bold text-success mt-2">
                        $<?= number_format($credito->total_abonado, 0, ',', '.'); ?>
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Saldo pendiente</small>
                    <h4 class="fw-bold text-danger mt-2">
                        $<?= number_format(max(0, $credito->saldo_pendiente), 0, ',', '.'); ?>
                    </h4>
                </div>
            </div>
        </div>

    </div>

    <!-- CUOTAS -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <h5 class="fw-bold mb-3">Plan de cuotas</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tablaCuotas">

                    <thead class="table-light">
                        <tr>
                            <th>N.º</th>
                            <th>Fecha de vencimiento</th>
                            <th>Valor de cuota</th>
                            <th>Abonado</th>
                            <th>Saldo de cuota</th>
                            <th>Estado</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($cuotas as $cuota): ?>

                            <?php
                                $saldo_cuota = max(0, (float) $cuota->saldo_cuota);
                                $estado = (int) $cuota->estado;

                                if ($saldo_cuota <= 0) {
                                    $texto_estado = 'Pagada';
                                    $clase_estado = 'success';
                                } elseif ($estado === 3 || ($estado === 1 && strtotime($cuota->fecha_vencimiento) < strtotime(date('Y-m-d')))) {
                                    $texto_estado = 'Vencida';
                                    $clase_estado = 'danger';
                                } elseif ($estado === 4 || (float) $cuota->total_abonado > 0) {
                                    $texto_estado = 'Abonada';
                                    $clase_estado = 'info';
                                } else {
                                    $texto_estado = 'Pendiente';
                                    $clase_estado = 'warning text-dark';
                                }
                            ?>

                            <tr>
                                <td><?= $cuota->numero_cuota; ?></td>

                                <td>
                                    <?= date('d/m/Y', strtotime($cuota->fecha_vencimiento)); ?>
                                </td>

                                <td>
                                    $<?= number_format($cuota->monto_cuota, 0, ',', '.'); ?>
                                </td>

                                <td>
                                    $<?= number_format($cuota->total_abonado, 0, ',', '.'); ?>
                                </td>

                                <td class="fw-semibold">
                                    $<?= number_format($saldo_cuota, 0, ',', '.'); ?>
                                </td>

                                <td>
                                    <span class="badge bg-<?= $clase_estado; ?>">
                                        <?= $texto_estado; ?>
                                    </span>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
