<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= html_escape($titulo); ?> | TecnoHogar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<main class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h1 class="h3 mb-1">Servicio #<?= (int) $mantenimiento->id_mantenimiento; ?></h1><p class="text-muted mb-0">Cliente: <?= html_escape($mantenimiento->cliente_nombre . ' ' . $mantenimiento->cliente_apellido); ?></p></div>
        <a class="btn btn-outline-secondary" href="<?= site_url('servicio_tecnico'); ?>">Volver</a>
    </div>
    <?php if ($this->session->flashdata('exito')): ?><div class="alert alert-success"><?= html_escape($this->session->flashdata('exito')); ?></div><?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?><div class="alert alert-danger"><?= html_escape($this->session->flashdata('error')); ?></div><?php endif; ?>
    <div class="row g-4">
        <div class="col-lg-6"><div class="card shadow-sm"><div class="card-body"><h2 class="h5">Equipo y solicitud</h2><dl class="row mb-0"><dt class="col-sm-4">Equipo</dt><dd class="col-sm-8"><?= html_escape($mantenimiento->nombre_equipo); ?></dd><dt class="col-sm-4">Problema</dt><dd class="col-sm-8"><?= nl2br(html_escape($mantenimiento->descripcion_problema)); ?></dd><dt class="col-sm-4">Diagnóstico</dt><dd class="col-sm-8"><?= $mantenimiento->diagnostico ? nl2br(html_escape($mantenimiento->diagnostico)) : 'Pendiente'; ?></dd><dt class="col-sm-4">Total</dt><dd class="col-sm-8">$<?= number_format($mantenimiento->total, 0, ',', '.'); ?></dd></dl></div></div></div>
        <div class="col-lg-6"><div class="card shadow-sm"><div class="card-body"><h2 class="h5">Actualizar diagnóstico</h2><?= form_open('servicio_tecnico/actualizar_diagnostico'); ?><input type="hidden" name="id_mantenimiento" value="<?= (int) $mantenimiento->id_mantenimiento; ?>"><div class="mb-3"><label class="form-label">Diagnóstico</label><textarea class="form-control" name="diagnostico" rows="3"><?= html_escape($mantenimiento->diagnostico); ?></textarea></div><div class="row"><div class="col"><label class="form-label">Mano de obra</label><input class="form-control" name="mano_obra" type="number" min="0" step="0.01" value="<?= (float) $mantenimiento->mano_obra; ?>"></div><div class="col"><label class="form-label">Repuestos</label><input class="form-control" name="costo_repuestos" type="number" min="0" step="0.01" value="<?= (float) $mantenimiento->costo_repuestos; ?>"></div></div><button class="btn btn-primary mt-3">Guardar diagnóstico</button><?= form_close(); ?></div></div></div>
        <div class="col-12"><div class="card shadow-sm"><div class="card-body"><h2 class="h5">Registrar avance</h2><?= form_open('servicio_tecnico/actualizar_estado', array('class' => 'row g-3')); ?><input type="hidden" name="id_mantenimiento" value="<?= (int) $mantenimiento->id_mantenimiento; ?>"><div class="col-md-4"><select class="form-select" name="estado" required><option value="">Selecciona un estado</option><?php foreach (array('En diagnóstico','Esperando repuestos','En reparación','Reparado','Entregado','No reparable') as $estado): ?><option value="<?= $estado; ?>"><?= $estado; ?></option><?php endforeach; ?></select></div><div class="col-md-6"><input class="form-control" name="detalle" placeholder="Describe el avance" required></div><div class="col-md-2"><button class="btn btn-success w-100">Registrar</button></div><?= form_close(); ?><hr><h3 class="h6">Historial</h3><?php if ($seguimientos): ?><ul class="list-group list-group-flush"><?php foreach ($seguimientos as $seguimiento): ?><li class="list-group-item"><strong><?= html_escape($seguimiento->estado); ?></strong> — <?= html_escape($seguimiento->detalle); ?><small class="text-muted d-block"><?= html_escape($seguimiento->fecha_registro); ?></small></li><?php endforeach; ?></ul><?php else: ?><p class="text-muted mb-0">No hay avances registrados.</p><?php endif; ?></div></div></div>
    </div>
</main>
</body></html>
