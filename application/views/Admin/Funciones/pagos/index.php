
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Gestión de pagos</h2>
            <p class="text-muted mb-0">Historial y control de pagos registrados</p>
        </div>

        <a href="<?= base_url('pagos/crear'); ?>" class="btn btn-primary">
            + Registrar abono
        </a>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table id="tablaPagos" class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Pedido</th>
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th>Método</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($pagos)): ?>
                            <?php foreach ($pagos as $pago): ?>
                                <tr>
                                    <td>#<?= $pago->id_pago; ?></td>

                                    <td>
                                        <?= html_escape($pago->nombre ?? 'Sin cliente'); ?>
                                    </td>

                                    <td>
                                        #<?= $pago->id_pedido; ?>
                                    </td>

                                    <td>
                                        <?= !empty($pago->fecha)
                                            ? date('d/m/Y h:i A', strtotime($pago->fecha))
                                            : '—'; ?>
                                    </td>

                                    <td class="fw-semibold">
                                        $<?= number_format($pago->monto, 0, ',', '.'); ?>
                                    </td>

                                    <td>
                                        <?= html_escape($pago->metodo); ?>
                                    </td>

                                    <td>
                                        <?php if ($pago->estado == 'Aprobado'): ?>
                                            <span class="badge bg-success">Aprobado</span>
                                        <?php elseif ($pago->estado == 'Pendiente'): ?>
                                            <span class="badge bg-warning text-dark">Pendiente</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">
                                                <?= html_escape($pago->estado); ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <a href="<?= base_url('pagos/detalle/' . $pago->id_pago); ?>"
                                           class="btn btn-sm btn-outline-primary">
                                            Ver detalle
                                        </a>
                                        <?php if ($pago->estado === 'Pendiente' && empty($pago->id_cuota)): ?>
                                            <?= form_open('pagos/aprobar/' . $pago->id_pago, array('class' => 'd-inline')); ?>
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('¿Aprobar este pago?');">Aprobar</button>
                                            <?= form_close(); ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <?php if (empty($pagos)): ?>
                    <div class="text-center text-muted py-4">
                        No hay pagos registrados.
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

</div>

<script src="<?= base_url('public/js/pagos.js'); ?>"></script>
