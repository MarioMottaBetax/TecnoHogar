
<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Gestión de Servicio Técnico</h2>
            <p class="text-muted mb-0">
                Administra los servicios técnicos, asignaciones y reparaciones.
            </p>
        </div>

        <a href="<?= site_url('servicio_tecnico/crear'); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Registrar servicio
        </a>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= html_escape($this->session->flashdata('success')); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= html_escape($this->session->flashdata('error')); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Servicios registrados</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaServicios" class="table table-hover table-striped align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Equipo</th>
                            <th>Tipo</th>
                            <th>Técnico asignado</th>
                            <th>Estado</th>
                            <th>Fecha de ingreso</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($mantenimientos)): ?>
                            <?php foreach ($mantenimientos as $m): ?>
                                <tr>
                                    <td>#<?= (int) $m->id_mantenimiento; ?></td>

                                    <td>
                                        <?= html_escape(
                                            $m->cliente_nombre . ' ' . $m->cliente_apellido
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= html_escape($m->nombre_equipo); ?>
                                    </td>

                                    <td>
                                        <?php if ((int) $m->tipo_servicio === 1): ?>
                                            <span class="badge bg-info text-dark">Garantía</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Externo</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if (!empty($m->tecnico_nombre)): ?>
                                            <?= html_escape(
                                                $m->tecnico_nombre . ' ' . $m->tecnico_apellido
                                            ); ?>
                                        <?php else: ?>
                                            <span class="text-muted">Sin asignar</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php
                                        $estado = !empty($m->estado_actual)
                                            ? $m->estado_actual
                                            : 'Recibido';

                                        $clases = array(
                                            'Recibido' => 'bg-primary',
                                            'En diagnóstico' => 'bg-warning text-dark',
                                            'Esperando repuestos' => 'bg-info text-dark',
                                            'En reparación' => 'bg-warning text-dark',
                                            'Reparado' => 'bg-success',
                                            'Entregado' => 'bg-secondary',
                                            'No reparable' => 'bg-danger'
                                        );

                                        $clase = isset($clases[$estado])
                                            ? $clases[$estado]
                                            : 'bg-secondary';
                                        ?>

                                        <span class="badge <?= $clase; ?>">
                                            <?= html_escape($estado); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?= !empty($m->fecha_ingreso)
                                            ? date('d/m/Y H:i', strtotime($m->fecha_ingreso))
                                            : '—'; ?>
                                    </td>

                                    <td>
                                        $<?= number_format((float) $m->total, 0, ',', '.'); ?>
                                    </td>

                                    <td>
                                        <a href="<?= site_url('servicio_tecnico/detalle/' . $m->id_mantenimiento); ?>"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Gestionar servicio">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if (empty($mantenimientos)): ?>
                <div class="text-center py-4">
                    <i class="fas fa-tools fa-2x text-muted mb-3"></i>
                    <p class="text-muted mb-0">
                        No hay servicios técnicos registrados.
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>
