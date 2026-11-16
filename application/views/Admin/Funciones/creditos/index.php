
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Gestión de créditos</h3>
            <p class="text-muted mb-0">Consulta los créditos y saldos de tus clientes.</p>
        </div>

        <a href="<?= base_url('ventas'); ?>" class="btn btn-outline-secondary">
            <i class="bi bi-receipt"></i> Ver ventas
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tablaCreditos">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Cédula</th>
                            <th>Fecha</th>
                            <th>Valor financiado</th>
                            <th>Cuotas</th>
                            <th>Abonado</th>
                            <th>Saldo pendiente</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($creditos)): ?>

                            <?php foreach ($creditos as $credito): ?>
                                <?php
                                    $saldo = max(0, (float) $credito->saldo_pendiente);
                                    $pagado = (float) $credito->total_abonado;
                                ?>

                                <tr>
                                    <td><?= $credito->id_credito; ?></td>

                                    <td>
                                        <?= html_escape($credito->nombre1 . ' ' . $credito->apellido1); ?>
                                    </td>

                                    <td><?= html_escape($credito->cedula); ?></td>

                                    <td>
                                        <?= date('d/m/Y', strtotime($credito->fecha)); ?>
                                    </td>

                                    <td>
                                        $<?= number_format($credito->monto_total, 0, ',', '.'); ?>
                                    </td>

                                    <td><?= $credito->numero_cuotas; ?></td>

                                    <td>
                                        $<?= number_format($pagado, 0, ',', '.'); ?>
                                    </td>

                                    <td class="fw-bold">
                                        $<?= number_format($saldo, 0, ',', '.'); ?>
                                    </td>

                                    <td>
                                        <?php if ($saldo <= 0): ?>
                                            <span class="badge bg-success">Pagado</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Pendiente</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <a href="<?= base_url('creditos/detalle/' . $credito->id_credito); ?>"
                                           class="btn btn-sm btn-outline-primary">
                                            Ver detalle
                                        </a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    No hay créditos registrados.
                                </td>
                            </tr>

                        <?php endif; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
