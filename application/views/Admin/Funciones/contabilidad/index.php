
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Contabilidad y Finanzas</h2>
            <p class="text-muted mb-0">Control de ingresos, egresos y balance financiero.</p>
        </div>

        <a href="<?= site_url('contabilidad/registrar_egreso'); ?>"
           class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Registrar egreso
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

    <!-- FILTROS -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="get" action="<?= site_url('contabilidad'); ?>"
                  class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label class="form-label">Desde</label>
                    <input type="date" name="desde" class="form-control"
                           value="<?= html_escape($desde); ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Hasta</label>
                    <input type="date" name="hasta" class="form-control"
                           value="<?= html_escape($hasta); ?>">
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Filtrar
                    </button>

                    <a href="<?= site_url('contabilidad'); ?>"
                       class="btn btn-outline-secondary">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- RESUMEN FINANCIERO -->
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted">Ingresos confirmados</div>
                    <h3 class="text-success mt-2">
                        $<?= number_format($total_ingresos, 0, ',', '.'); ?>
                    </h3>
                    <small class="text-muted">Pagos con estado Pagado</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted">Egresos registrados</div>
                    <h3 class="text-danger mt-2">
                        $<?= number_format($total_egresos, 0, ',', '.'); ?>
                    </h3>
                    <small class="text-muted">Gastos registrados manualmente</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted">Balance financiero</div>
                    <h3 class="mt-2 <?= $balance >= 0 ? 'text-success' : 'text-danger'; ?>">
                        $<?= number_format($balance, 0, ',', '.'); ?>
                    </h3>
                    <small class="text-muted">Ingresos menos egresos</small>
                </div>
            </div>
        </div>

    </div>

    <!-- INGRESOS -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Ingresos recibidos</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaIngresos" class="table table-striped table-hover align-middle w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pedido</th>
                            <th>Cuota</th>
                            <th>Fecha</th>
                            <th>Método</th>
                            <th>Estado</th>
                            <th>Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($movimientos)): ?>
                            <?php foreach ($movimientos as $m): ?>
                                <tr>
                                    <td><?= $m->id_pago; ?></td>
                                    <td><?= $m->id_pedido; ?></td>
                                    <td><?= $m->id_cuota ? $m->id_cuota : 'No aplica'; ?></td>
                                    <td><?= html_escape($m->fecha); ?></td>
                                    <td><?= html_escape($m->metodo); ?></td>
                                    <td>
                                        <span class="badge bg-success">
                                            <?= html_escape($m->estado); ?>
                                        </span>
                                    </td>
                                    <td>$<?= number_format($m->monto, 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <?php if (empty($movimientos)): ?>
                    <p class="text-center text-muted py-3">
                        No hay ingresos registrados en este periodo.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- EGRESOS -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Egresos registrados</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaEgresos" class="table table-striped table-hover align-middle w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Concepto</th>
                            <th>Categoría</th>
                            <th>Fecha</th>
                            <th>Método de pago</th>
                            <th>Valor</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($egresos)): ?>
                            <?php foreach ($egresos as $e): ?>
                                <tr>
                                    <td><?= $e->id_egreso; ?></td>
                                    <td><?= html_escape($e->concepto); ?></td>
                                    <td><?= html_escape($e->categoria); ?></td>
                                    <td><?= html_escape($e->fecha_egreso); ?></td>
                                    <td><?= html_escape($e->metodo_pago); ?></td>
                                    <td>$<?= number_format($e->valor, 0, ',', '.'); ?></td>
                                    <td>
                                        <form method="post"
                                              action="<?= site_url('contabilidad/eliminar_egreso/'.$e->id_egreso); ?>"
                                              class="form-eliminar-egreso">
                                            <input type="hidden"
                                                   name="<?= $this->security->get_csrf_token_name(); ?>"
                                                   value="<?= $this->security->get_csrf_hash(); ?>">
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Eliminar egreso">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <?php if (empty($egresos)): ?>
                    <p class="text-center text-muted py-3">
                        No hay egresos registrados en este periodo.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
