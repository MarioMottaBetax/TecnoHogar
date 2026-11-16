
<div class="content-header">
    <div>
        <h1>Gestión de técnicos</h1>
        <p>Personal técnico y seguimiento de sus servicios asignados.</p>
    </div>
    <a href="<?= base_url('servicio_tecnico'); ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver a servicios
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Técnicos registrados</h6>
                <h3><?= count($tecnicos); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Servicios asignados</h6>
                <h3>
                    <?php
                    $total = 0;
                    foreach ($tecnicos as $t) {
                        $total += (int) $t->total_servicios;
                    }
                    echo $total;
                    ?>
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Servicios activos</h6>
                <h3>
                    <?php
                    $activos = 0;
                    foreach ($tecnicos as $t) {
                        $activos += (int) $t->servicios_activos;
                    }
                    echo $activos;
                    ?>
                </h3>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="mb-3">Personal técnico</h5>

        <div class="table-responsive">
            <table id="tablaTecnicos" class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Técnico</th>
                        <th>Cédula</th>
                        <th>Celular</th>
                        <th>Correo</th>
                        <th>Asignados</th>
                        <th>Activos</th>
                        <th>Finalizados</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tecnicos as $tecnico): ?>
                        <tr>
                            <td><?= $tecnico->id_usuario; ?></td>
                            <td>
                                <strong>
                                    <?= html_escape(
                                        trim(
                                            $tecnico->nombre1 . ' ' .
                                            $tecnico->nombre2 . ' ' .
                                            $tecnico->apellido1 . ' ' .
                                            $tecnico->apellido2
                                        )
                                    ); ?>
                                </strong>
                            </td>
                            <td><?= html_escape($tecnico->cedula); ?></td>
                            <td><?= html_escape($tecnico->celular); ?></td>
                            <td><?= html_escape($tecnico->correo); ?></td>
                            <td><?= (int) $tecnico->total_servicios; ?></td>
                            <td>
                                <span class="badge bg-primary">
                                    <?= (int) $tecnico->servicios_activos; ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success">
                                    <?= (int) $tecnico->servicios_finalizados; ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
