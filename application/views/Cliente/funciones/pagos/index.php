
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Mis pagos</h3>
            <p class="text-muted mb-0">
                Consulta el historial de tus pagos realizados.
            </p>
        </div>
    </div>

    <?php if ($this->session->flashdata('mensaje')): ?>
        <div class="alert alert-info">
            <?= $this->session->flashdata('mensaje'); ?>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tablaPagos">

                    <thead class="table-light">
                        <tr>
                            <th>Pago</th>
                            <th>Pedido</th>
                            <th>Fecha</th>
                            <th>Método</th>
                            <th>Monto</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($pagos)): ?>

                            <?php foreach ($pagos as $pago): ?>

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

                                <tr>
                                    <td>#<?= $pago->id_pago; ?></td>

                                    <td>#<?= $pago->id_pedido; ?></td>

                                    <td>
                                        <?= date('d/m/Y H:i', strtotime($pago->fecha)); ?>
                                    </td>

                                    <td>
                                        <?= html_escape($pago->metodo); ?>
                                    </td>

                                    <td class="fw-semibold">
                                        $<?= number_format($pago->monto, 0, ',', '.'); ?>
                                    </td>

                                    <td>
                                        <span class="badge <?= $clase; ?>">
                                            <?= html_escape($pago->estado); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <a href="<?= base_url('cliente/pagos/detalle/'.$pago->id_pago); ?>"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                            Ver detalle
                                        </a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>
                    </tbody>

                </table>
            </div>

            <?php if (empty($pagos)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-wallet2 fs-1 text-muted"></i>
                    <h5 class="mt-3">Todavía no tienes pagos registrados</h5>
                    <p class="text-muted">
                        Aquí aparecerán los pagos asociados a tus pedidos.
                    </p>
                    <a href="<?= base_url('cliente/pedidos'); ?>"
                       class="btn btn-primary">
                        Ver mis pedidos
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>

</div>
