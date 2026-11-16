
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Gestión de ventas</h3>
            <p class="text-muted mb-0">Consulta y administra las ventas de TecnoHogar.</p>
        </div>

        <a href="<?= base_url('ventas/crear'); ?>" class="btn btn-primary">
            + Registrar venta
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table id="tablaVentas" class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Cédula</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Cupón</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($ventas)): ?>
                            <?php foreach ($ventas as $venta): ?>
                                <tr>
                                    <td><?= (int) $venta->id_pedido; ?></td>

                                    <td>
                                        <?= html_escape($venta->nombre1 . ' ' . $venta->apellido1); ?>
                                    </td>

                                    <td><?= html_escape($venta->cedula); ?></td>

                                    <td>
                                        <?= date('d/m/Y H:i', strtotime($venta->fecha)); ?>
                                    </td>

                                    <td class="fw-semibold">
                                        $<?= number_format($venta->total, 0, ',', '.'); ?>
                                    </td>

                                    <td>
                                        <?php if (!empty($venta->id_descuento)): ?>
                                            <span class="badge bg-success">
                                                Cupón #<?= (int) $venta->id_descuento; ?>
                                            </span>
                                            <div class="small text-success mt-1">
                                                -$<?= number_format($venta->descuento_aplicado, 0, ',', '.'); ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">
                                                Sin cupón
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php
                                            $estados = array(1 => 'Carrito', 2 => 'Pendiente', 3 => 'En revisión', 4 => 'Aprobado', 5 => 'Rechazado', 6 => 'Finalizado', 7 => 'Cancelado');
                                            $clases = array(1 => 'secondary', 2 => 'warning text-dark', 3 => 'info', 4 => 'success', 5 => 'danger', 6 => 'primary', 7 => 'danger');
                                            $estado = isset($estados[(int) $venta->estado]) ? $estados[(int) $venta->estado] : 'Desconocido';
                                            $clase = isset($clases[(int) $venta->estado]) ? $clases[(int) $venta->estado] : 'secondary';
                                        ?>

                                        <span class="badge bg-<?= $clase; ?>">
                                            <?= html_escape($estado); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <a href="<?= base_url('ventas/detalle/' . $venta->id_pedido); ?>"
                                           class="btn btn-sm btn-outline-primary">
                                            Ver detalle
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>
