
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
                <h2>$0</h2>
                <small>Ingresos registrados hoy</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">↗</div>
            <div>
                <span>Ingresos del mes</span>
                <h2>$0</h2>
                <small>Acumulado mensual</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">▣</div>
            <div>
                <span>Productos</span>
                <h2>0</h2>
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
                <h2>0</h2>
                <small>Productos por revisar</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">◷</div>
            <div>
                <span>Créditos pendientes</span>
                <h2>0</h2>
                <small>Obligaciones pendientes</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">⚙</div>
            <div>
                <span>Servicios técnicos</span>
                <h2>0</h2>
                <small>Servicios por atender</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">✓</div>
            <div>
                <span>Garantías</span>
                <h2>0</h2>
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

            <div class="empty-state">
                <div class="empty-icon">▤</div>
                <h4>Sin movimientos todavía</h4>
                <p>
                    Aquí aparecerán las ventas, pagos y operaciones
                    recientes de TecnoHogar.
                </p>
            </div>
        </div>

        <div class="dashboard-panel quick-panel">
            <div class="panel-heading">
                <div>
                    <h3>Accesos rápidos</h3>
                    <p>Funciones principales</p>
                </div>
            </div>

            <a href="#" class="quick-link">
                <span>＋</span>
                Registrar venta
            </a>

            <a href="#" class="quick-link">
                <span>▣</span>
                Agregar producto
            </a>

            <a href="#" class="quick-link">
                <span>♙</span>
                Registrar cliente
            </a>

            <a href="#" class="quick-link">
                <span>⚙</span>
                Gestionar servicio técnico
            </a>
        </div>

    </section>

        <footer class="dashboard-footer">
        TecnoHogar · Sistema de gestión empresarial ERP/CRM
    </footer>

