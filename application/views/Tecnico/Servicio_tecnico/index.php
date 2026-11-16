<table id="tablaServicios" class="table table-hover table-striped align-middle w-100">
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis servicios | TecnoHogar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">

    <div class="mb-4">
        <h2>Mis servicios técnicos</h2>
        <p class="text-muted">Consulta y gestiona los servicios que tienes asignados.</p>
    </div>

    <?php if (!empty($mantenimientos)): ?>

        <div class="row g-3">

            <?php foreach ($mantenimientos as $m): ?>

                <div class="col-md-6 col-xl-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-3">
                                <span class="badge bg-primary">
                                    Servicio #<?= $m->id_mantenimiento; ?>
                                </span>

                                <span class="badge bg-secondary">
                                    <?= html_escape($m->estado_actual ?: 'Recibido'); ?>
                                </span>
                            </div>

                            <h5><?= html_escape($m->nombre_equipo); ?></h5>

                            <p class="text-muted">
                                Cliente:
                                <?= html_escape($m->cliente_nombre . ' ' . $m->cliente_apellido); ?>
                            </p>

                            <p>
                                <?= html_escape($m->descripcion_problema); ?>
                            </p>

                            <small class="text-muted">
                                Ingreso: <?= html_escape($m->fecha_ingreso); ?>
                            </small>

                            <div class="mt-3">
                                <a href="<?= site_url('servicio_tecnico/detalle/' . $m->id_mantenimiento); ?>"
                                   class="btn btn-primary w-100">
                                    Gestionar servicio
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="alert alert-info">
            No tienes servicios técnicos asignados actualmente.
        </div>

    <?php endif; ?>

    <a href="<?= site_url('tecnico/dashboard'); ?>"
       class="btn btn-outline-secondary mt-4">
        Volver al panel
    </a>

</div>

</body>
</html>
