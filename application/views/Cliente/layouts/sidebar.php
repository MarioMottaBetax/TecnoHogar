
<aside class="client-sidebar">
    <div class="client-brand">
        <div class="brand-icon">
            <i class="bi bi-shop"></i>
        </div>
        <div>
            <h5>TecnoHogar</h5>
            <small>Portal del cliente</small>
        </div>
    </div>

    <div class="client-menu-title">MENÚ PRINCIPAL</div>

    <a href="<?= base_url('cliente'); ?>"
       class="client-link <?= $this->uri->segment(1) == 'cliente' && !$this->uri->segment(2) ? 'active' : ''; ?>">
        <i class="bi bi-grid"></i> Inicio
    </a>

    <a href="<?= base_url('cliente/productos'); ?>"
   class="sidebar-link <?= $this->uri->segment(2) == 'productos' ? 'active' : ''; ?>">
    <i class="bi bi-bag"></i>
    <span>Productos</span>
    </a>

    <a href="<?= base_url('cliente/carrito'); ?>" class="client-link <?= $this->uri->segment(2) == 'carrito' ? 'active' : ''; ?>">
        <i class="bi bi-cart3"></i> Mi carrito
    </a>

    <div class="client-menu-title">MI CUENTA</div>

    <a href="<?= base_url('cliente/pedidos'); ?>" class="client-link <?= $this->uri->segment(2) == 'pedidos' ? 'active' : ''; ?>">
        <i class="bi bi-receipt"></i> Mis pedidos
    </a>

    <a href="<?= base_url('cliente/pagos'); ?>" class="client-link <?= $this->uri->segment(2) == 'pagos' ? 'active' : ''; ?>">
        <i class="bi bi-credit-card"></i> Mis pagos
    </a>

    <a href="<?= base_url('cliente/creditos'); ?>" class="client-link <?= $this->uri->segment(2) == 'creditos' ? 'active' : ''; ?>">
        <i class="bi bi-cash-stack"></i> Mis créditos
    </a>

    <a href="<?= base_url('cliente/garantias'); ?>" class="client-link <?= $this->uri->segment(2) == 'garantias' ? 'active' : ''; ?>">
        <i class="bi bi-shield-check"></i> Mis garantías
    </a>

    <a href="<?= base_url('cliente/servicio_tecnico'); ?>" class="client-link <?= $this->uri->segment(2) == 'servicio_tecnico' ? 'active' : ''; ?>">
        <i class="bi bi-tools"></i> Servicio técnico
    </a>

    <div class="client-menu-title">CONFIGURACIÓN</div>

    <a href="<?= base_url('cliente/perfil'); ?>" class="client-link <?= $this->uri->segment(2) == 'perfil' ? 'active' : ''; ?>">
        <i class="bi bi-person-circle"></i> Mi perfil
    </a>

    <a href="<?= base_url('auth/cerrar_sesion'); ?>" class="client-link logout-link">
        <i class="bi bi-box-arrow-left"></i> Cerrar sesión
    </a>
</aside>

<main class="client-main">
    <header class="client-topbar">
        <div>
            <span class="text-muted">Portal de cliente</span>
        </div>
        <div class="client-user">
            <i class="bi bi-person-circle"></i>
            <span><?= html_escape(isset($nombre) ? $nombre : 'Cliente'); ?></span>
        </div>
    </header>
