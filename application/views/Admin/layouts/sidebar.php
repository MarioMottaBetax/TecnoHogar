
<aside class="sidebar" id="sidebar">

    <div class="sidebar-brand">
        <div class="brand-icon">TH</div>
        <div>
            <h2>TecnoHogar</h2>
            <span>ERP / CRM</span>
        </div>
    </div>

    <div class="sidebar-section">GENERAL</div>

    <a href="<?= base_url('admin/dashboard'); ?>"
       class="sidebar-link active">
        <span class="nav-icon">▦</span>
        Dashboard
    </a>

    <div class="sidebar-section">GESTIÓN EMPRESARIAL</div>

    <a href="<?= base_url('ventas'); ?>"
    class="sidebar-link <?= $this->uri->segment(1) == 'ventas' ? 'active' : ''; ?>">
        <span class="nav-icon">💰</span>
        Ventas
    </a>

    <a href="<?= base_url('inventario'); ?>"
   class="sidebar-link <?= $this->uri->segment(1) == 'inventario' ? 'active' : ''; ?>">
    <span class="nav-icon">📦</span>
    Inventario
    </a>

    <a href="<?= base_url('proveedores'); ?>"
   class="sidebar-link <?= $this->uri->segment(1) == 'proveedores' ? 'active' : ''; ?>">
    <span class="nav-icon">🚚</span>
    Proveedores
    </a>

    
    <a href="<?= base_url('compras'); ?>"
    class="sidebar-link <?= $this->uri->segment(1) == 'compras' ? 'active' : ''; ?>">
        <span class="nav-icon">🛒</span>
        Compras
    </a>

    <a href="<?= base_url('pagos'); ?>"
   class="sidebar-link <?= $this->uri->segment(1) == 'pagos' ? 'active' : ''; ?>">
    <span class="nav-icon">💵</span>
    Pagos
</a>

    <a href="<?= base_url('creditos'); ?>"
   class="sidebar-link <?= $this->uri->segment(1) == 'creditos' ? 'active' : ''; ?>">
    <span class="nav-icon">💳</span>
    Créditos
    </a>

    <a href="<?= base_url('contabilidad'); ?>"
    class="sidebar-link <?= $this->uri->segment(1) == 'contabilidad' ? 'active' : ''; ?>">
    <span class="nav-icon">🏦</span>
    Contabilidad y Finanzas
    </a>

    <a href="<?= base_url('contabilidad/egresos'); ?>"
   class="sidebar-link <?= $this->uri->segment(2) == 'egresos' ? 'active' : ''; ?>">
    <span class="nav-icon">💸</span>
    Gestión de egresos
    </a>

    <div class="sidebar-section">CLIENTES Y SERVICIOS</div>

    
    <a href="<?= base_url('usuarios'); ?>"
    class="sidebar-link <?= $this->uri->segment(1) == 'usuarios' ? 'active' : ''; ?>">

        <span class="nav-icon">👥</span>
        Usuarios y Roles

    </a>


    <a href="<?= base_url('garantias'); ?>"
   class="sidebar-link <?= $this->uri->segment(1) == 'garantias' ? 'active' : ''; ?>">
    <span class="nav-icon">🛡️</span>
    Garantías
    </a>


    <a href="<?= base_url('servicio_tecnico'); ?>"
   class="sidebar-link <?= $this->uri->segment(1) == 'servicio_tecnico' ? 'active' : ''; ?>">
    <span class="nav-icon">🛠️</span>
    Servicio Técnico
    </a>

    <div class="sidebar-section">ADMINISTRACIÓN</div>

    
    <a href="<?= base_url('descuentos'); ?>"
    class="sidebar-link <?= $this->uri->segment(1) == 'descuentos' ? 'active' : ''; ?>">
        <span class="nav-icon">🏷️</span>
        Marketing y Descuentos
    </a>

    <a href="<?= base_url('reportes'); ?>"
    class="sidebar-link <?= $this->uri->segment(1) == 'reportes' ? 'active' : ''; ?>">
    <span class="nav-icon">📊</span>
    Reportes y Estadísticas
    </a>

</aside>

<main class="main-content">