
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 class="mb-1">Compras</h1>
            <p class="text-muted mb-0">
                Gestiona las compras y el abastecimiento de inventario.
            </p>
        </div>

        <a href="<?= base_url('compras/crear'); ?>" class="btn btn-primary">
            + Nueva compra
        </a>
    </div>

    <?php if ($this->session->flashdata('exito')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('exito'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table id="tablaCompras" class="table table-hover table-striped align-middle w-100">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Proveedor</th>
                            <th>Fecha</th>
                            <th>Responsable</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (!empty($compras)): ?>

                            <?php foreach ($compras as $compra): ?>

                                <tr>
                                    <td><?= $compra->id_compra; ?></td>

                                    <td>
                                        <?= html_escape($compra->nombre_proveedor); ?>
                                    </td>

                                    <td>
                                        <?= date('d/m/Y H:i', strtotime($compra->fecha_compra)); ?>
                                    </td>

                                    <td>
                                        <?= html_escape($compra->nombre1 . ' ' . $compra->apellido1); ?>
                                    </td>

                                    <td>
                                        $<?= number_format($compra->total, 0, ',', '.'); ?>
                                    </td>

                                    <td>
                                        <?php if ($compra->estado == 'Pendiente'): ?>
                                            <span class="badge bg-warning text-dark">
                                                Pendiente
                                            </span>

                                        <?php elseif ($compra->estado == 'Recibida'): ?>
                                            <span class="badge bg-success">
                                                Recibida
                                            </span>

                                        <?php else: ?>
                                            <span class="badge bg-danger">
                                                Cancelada
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2 flex-wrap">

                                            <a href="<?= base_url('compras/detalle/' . $compra->id_compra); ?>"
                                               class="btn btn-sm btn-outline-primary">
                                                Ver
                                            </a>

                                            <?php if ($compra->estado == 'Pendiente'): ?>

                                                <?= form_open('compras/recibir/' . $compra->id_compra, array('class' => 'd-inline')); ?>

                                                    <button type="submit"
                                                            class="btn btn-sm btn-success"
                                                            onclick="return confirm('¿Confirmas que recibiste todos los productos de esta compra?');">
                                                        Recibir
                                                    </button>

                                                <?= form_close(); ?>

                                                <?= form_open('compras/cancelar/' . $compra->id_compra, array('class' => 'd-inline')); ?>

                                                    <button type="submit"
                                                            class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('¿Seguro que deseas cancelar esta compra?');">
                                                        Cancelar
                                                    </button>

                                                <?= form_close(); ?>

                                            <?php endif; ?>

                                        </div>
                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </tbody>

                </table>
            </div>

            <?php if (empty($compras)): ?>
                <div class="text-center py-4">
                    <h5>No hay compras registradas</h5>
                    <p class="text-muted">
                        Cuando registres una compra, aparecerá en este listado.
                    </p>
                </div>
            <?php endif; ?>

        </div>
    </div>

