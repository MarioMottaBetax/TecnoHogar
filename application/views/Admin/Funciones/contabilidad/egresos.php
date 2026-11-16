
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Gestión de egresos</h3>
            <p class="text-muted">Control y administración de gastos de TecnoHogar.</p>
        </div>

        <a href="<?= base_url('contabilidad/registrar_egreso'); ?>"
           class="btn btn-primary">
            + Registrar egreso
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

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?= base_url('contabilidad/egresos'); ?>"
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

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <a href="<?= base_url('contabilidad/egresos'); ?>"
                       class="btn btn-secondary">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total de egresos</h6>
                    <h3 class="text-danger">
                        $<?= number_format($total_egresos, 0, ',', '.'); ?>
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Gastos registrados</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaEgresos" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Concepto</th>
                            <th>Categoría</th>
                            <th>Fecha</th>
                            <th>Método de pago</th>
                            <th>Valor</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($egresos)): ?>
                            <?php foreach ($egresos as $egreso): ?>
                                <tr>
                                    <td><?= $egreso->id_egreso; ?></td>
                                    <td><?= html_escape($egreso->concepto); ?></td>
                                    <td><?= html_escape($egreso->categoria); ?></td>
                                    <td><?= date('d/m/Y', strtotime($egreso->fecha_egreso)); ?></td>
                                    <td><?= html_escape($egreso->metodo_pago); ?></td>
                                    <td class="text-danger fw-bold">
                                        $<?= number_format($egreso->valor, 0, ',', '.'); ?>
                                    </td>
                                    <td><?= html_escape($egreso->descripcion); ?></td>
                                    <td>
                                        <form method="POST"
                                              action="<?= base_url('contabilidad/eliminar_egreso/'.$egreso->id_egreso); ?>"
                                              class="form-eliminar-egreso">

                                            <input type="hidden"
                                                   name="<?= $this->security->get_csrf_token_name(); ?>"
                                                   value="<?= $this->security->get_csrf_hash(); ?>">

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="<?= base_url('contabilidad'); ?>" class="btn btn-secondary">
            Volver a contabilidad
        </a>
    </div>

</div>
