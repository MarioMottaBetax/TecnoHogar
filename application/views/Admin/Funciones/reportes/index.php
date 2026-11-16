
<div class="container-fluid py-4">

    <div class="mb-4">
        <h3>Reportes y Estadísticas</h3>
        <p class="text-muted">
            Indicadores generales y comportamiento de TecnoHogar.
        </p>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?= base_url('reportes'); ?>"
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
                    <button class="btn btn-primary">Generar reporte</button>
                    <a href="<?= base_url('reportes'); ?>"
                       class="btn btn-secondary">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Ingresos confirmados</h6>
                    <h4 class="text-success">
                        $<?= number_format($ingresos, 0, ',', '.'); ?>
                    </h4>
                    <small>Pagos aprobados</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Egresos registrados</h6>
                    <h4 class="text-danger">
                        $<?= number_format($egresos, 0, ',', '.'); ?>
                    </h4>
                    <small>Gastos registrados</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Balance operacional</h6>
                    <h4 class="<?= $balance >= 0 ? 'text-success' : 'text-danger'; ?>">
                        $<?= number_format($balance, 0, ',', '.'); ?>
                    </h4>
                    <small>Ingresos menos egresos</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Valor del inventario</h6>
                    <h4 class="text-primary">
                        $<?= number_format((float) $inventario->valor_inventario, 0, ',', '.'); ?>
                    </h4>
                    <small>
                        <?= (int) $inventario->unidades; ?> unidades disponibles
                    </small>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-3 mb-4">

        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <strong>Ingresos y egresos por mes</strong>
                </div>
                <div class="card-body">
                    <canvas id="graficoFinanciero"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <strong>Productos por categoría</strong>
                </div>
                <div class="card-body">
                    <canvas id="graficoCategorias"></canvas>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-3 mb-4">

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Compras realizadas</h6>
                    <h3><?= (int) $compras->cantidad; ?></h3>
                    <small>
                        Total:
                        $<?= number_format((float) $compras->total_compras, 0, ',', '.'); ?>
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Productos registrados</h6>
                    <h3><?= (int) $inventario->productos; ?></h3>
                    <small>Referencias en inventario</small>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    window.datosReportes = {
        ingresos: <?= json_encode($ingresos_mensuales); ?>,
        egresos: <?= json_encode($egresos_mensuales); ?>,
        categorias: <?= json_encode($categorias); ?>
    };
</script>
