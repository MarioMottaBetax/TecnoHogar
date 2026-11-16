
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-1">Marketing y Descuentos</h2>
            <p class="text-muted mb-0">
                Administración de cupones promocionales de TecnoHogar.
            </p>
        </div>

        <a href="<?= base_url('descuentos/crear'); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Crear cupón
        </a>
    </div>

    <?php if ($this->session->flashdata('exito')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= html_escape($this->session->flashdata('exito')); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= html_escape($this->session->flashdata('error')); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Cupones registrados</div>
                    <h3 class="fw-bold mb-0">
                        <?= count($descuentos); ?>
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Tipo de descuento</div>
                    <h3 class="fw-bold mb-0">Valor fijo</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Compra mínima</div>
                    <h3 class="fw-bold mb-0">10 veces el cupón</h3>
                </div>
            </div>
        </div>

    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <h5 class="mb-0 fw-semibold">Listado de cupones</h5>

                <div class="btn-group" role="group">
                    <a href="<?= base_url('descuentos?estado=0'); ?>"
                       class="btn btn-sm <?= $estado_filtro === 0 ? 'btn-primary' : 'btn-outline-primary'; ?>">
                        Todos
                    </a>

                    <a href="<?= base_url('descuentos?estado=1'); ?>"
                       class="btn btn-sm <?= $estado_filtro === 1 ? 'btn-primary' : 'btn-outline-primary'; ?>">
                        Vigentes
                    </a>

                    <a href="<?= base_url('descuentos?estado=2'); ?>"
                       class="btn btn-sm <?= $estado_filtro === 2 ? 'btn-primary' : 'btn-outline-primary'; ?>">
                        Usados
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table id="tablaDescuentos"
                       class="table table-hover table-striped align-middle w-100">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Valor del cupón</th>
                            <th>Compra mínima</th>
                            <th>Descuento</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($descuentos)): ?>

                            <?php foreach ($descuentos as $d): ?>
                                <tr>
                                    <td><?= (int) $d->id_descuento; ?></td>

                                    <td>
                                        <?= html_escape($d->nombre_usuario ?: 'Usuario no disponible'); ?>
                                    </td>

                                    <td>
                                        <?= html_escape($d->correo ?: 'Sin correo'); ?>
                                    </td>

                                    <td class="fw-semibold text-success">
                                        $<?= number_format($d->cupon, 0, ',', '.'); ?>
                                    </td>

                                    <td>
                                        $<?= number_format($d->rango, 0, ',', '.'); ?>
                                    </td>

                                    <td>
                                        <span class="badge bg-success">Valor fijo</span>
                                    </td>

                                    <td>
                                        <?php if ((int) $d->estado === 1): ?>
                                            <span class="badge bg-success">
                                                Vigente
                                            </span>
                                        <?php elseif ((int) $d->estado === 2): ?>
                                            <span class="badge bg-secondary">
                                                Usado
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">
                                                Sin estado
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if ((int) $d->estado === 1): ?>
                                            <a href="<?= base_url('descuentos/editar/' . $d->id_descuento); ?>"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Editar cupón">
                                                <i class="bi bi-pencil-square"></i>
                                                Editar
                                            </a>
                                        <?php else: ?>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-secondary"
                                                    disabled
                                                    title="Los cupones usados no se pueden editar">
                                                <i class="bi bi-lock"></i>
                                                Bloqueado
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php endif; ?>
                    </tbody>

                </table>
            </div>

            <?php if (empty($descuentos)): ?>
                <div class="text-center py-4">
                    <i class="bi bi-ticket-perforated text-muted fs-1"></i>
                    <p class="text-muted mb-0 mt-2">
                        No hay cupones registrados en esta categoría.
                    </p>
                </div>
            <?php endif; ?>

        </div>
    </div>

</div>
