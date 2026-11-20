
    <div class="page-heading">
        <div>
            <h1>Dashboard</h1>
            <p>Resumen general de la operación de TecnoHogar.</p>
        </div>

        <div class="date-label">
            Panel de administración
        </div>
    </div>

    <!-- INDICADORES PRINCIPALES -->
    <section class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon blue">＄</div>
            <div>
                <span>Ventas del día</span>
                <h2>$<?= number_format($ventas_hoy, 0, ',', '.'); ?></h2>
                <small>Ingresos registrados hoy</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">↗</div>
            <div>
                <span>Ingresos del mes</span>
                <h2>$<?= number_format($ventas_mes, 0, ',', '.'); ?></h2>
                <small>Acumulado mensual</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">▣</div>
            <div>
                <span>Productos</span>
                <h2><?= number_format($total_productos); ?></h2>
                <small>Productos registrados</small>
            </div>
        </div>

                <div class="stat-card">
            <div class="stat-icon purple">♙</div>
            <div>
                <span>Clientes</span>
                <h2><?= number_format($total_clientes); ?></h2>
                <small>Clientes registrados</small>
            </div>
        </div>

    </section>

    <!-- SEGUNDA FILA -->
    <section class="stats-grid secondary-stats">

        <div class="stat-card">
            <div class="stat-icon red">!</div>
            <div>
                <span>Inventario bajo</span>
                <h2><?= number_format($inventario_bajo); ?></h2>
                <small>Productos por revisar</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">◷</div>
            <div>
                <span>Créditos pendientes</span>
                <h2><?= number_format($creditos_pendientes); ?></h2>
                <small>Obligaciones pendientes</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">⚙</div>
            <div>
                <span>Servicios técnicos</span>
                <h2><?= number_format($servicios_activos); ?></h2>
                <small>Servicios por atender</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">✓</div>
            <div>
                <span>Garantías</span>
                <h2><?= number_format($garantias_vigentes); ?></h2>
                <small>Solicitudes registradas</small>
            </div>
        </div>

    </section>

    <!-- CONTENIDO INFERIOR -->
    <section class="dashboard-bottom">

        <div class="dashboard-panel">
            <div class="panel-heading">
                <div>
                    <h3>Actividad reciente</h3>
                    <p>Movimientos registrados en el sistema</p>
                </div>
            </div>

            <?php if (!empty($actividad_reciente)): ?>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead><tr><th>Pago</th><th>Cliente</th><th>Fecha</th><th class="text-end">Monto</th><th>Estado</th></tr></thead>
                        <tbody>
                        <?php foreach ($actividad_reciente as $actividad): ?>
                            <tr>
                                <td>#<?= (int) $actividad->id_pago; ?></td>
                                <td><?= html_escape(trim($actividad->nombre1 . ' ' . $actividad->apellido1)); ?></td>
                                <td><?= !empty($actividad->fecha) ? date('d/m/Y H:i', strtotime($actividad->fecha)) : '—'; ?></td>
                                <td class="text-end">$<?= number_format($actividad->monto, 0, ',', '.'); ?></td>
                                <td><?= html_escape($actividad->estado); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state"><div class="empty-icon">▤</div><h4>Sin movimientos todavía</h4><p>Aquí aparecerán los pagos y operaciones recientes de TecnoHogar.</p></div>
            <?php endif; ?>
        </div>

        <div class="dashboard-panel quick-panel">
            <div class="panel-heading">
                <div>
                    <h3>Accesos rápidos</h3>
                    <p>Funciones principales</p>
                </div>
            </div>

            <a href="<?= base_url('ventas/crear'); ?>" class="quick-link">
                <span>＋</span>
                Registrar venta
            </a>

            <a href="<?= base_url('inventario/crear'); ?>" class="quick-link">
                <span>▣</span>
                Agregar producto
            </a>

            <a href="<?= base_url('clientes/crear'); ?>" class="quick-link">
                <span>♙</span>
                Registrar cliente
            </a>

            <a href="<?= base_url('servicio_tecnico'); ?>" class="quick-link">
                <span>⚙</span>
                Gestionar servicio técnico
            </a>
        </div>

    </section>

        <footer class="dashboard-footer">
        TecnoHogar · Sistema de gestión empresarial ERP/CRM
    </footer>

