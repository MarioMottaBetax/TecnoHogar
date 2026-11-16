
<div class="container-fluid client-dashboard">

    <div class="welcome-banner">
        <div>
            <span class="welcome-label">BIENVENIDO A TECNOHOGAR</span>
            <h2>¡Hola, <?= html_escape($nombre); ?>!</h2>
            <p>Estamos aquí para ayudarte con tus compras y servicios.</p>
            <a href="<?= base_url('cliente/productos'); ?>" class="btn btn-light">
                Explorar productos <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="welcome-icon">
            <i class="bi bi-house-heart"></i>
        </div>
    </div>

    <div class="section-heading">
        <div>
            <h4>Tu espacio personal</h4>
            <p>Accede rápidamente a los servicios de tu cuenta.</p>
        </div>
    </div>

    <div class="row g-3">

        <div class="col-md-6 col-xl-3">
            <a href="<?= base_url('cliente/productos'); ?>" class="dashboard-card">
                <div class="dashboard-icon blue">
                    <i class="bi bi-bag"></i>
                </div>
                <h5>Productos</h5>
                <p>Explora nuestro catálogo y encuentra lo que necesitas.</p>
                <span>Ver catálogo <i class="bi bi-arrow-right"></i></span>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="<?= base_url('cliente/pedidos'); ?>" class="dashboard-card">
                <div class="dashboard-icon green">
                    <i class="bi bi-receipt"></i>
                </div>
                <h5>Mis pedidos</h5>
                <p>Consulta tus compras y el estado de tus pedidos.</p>
                <span>Ver pedidos <i class="bi bi-arrow-right"></i></span>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="<?= base_url('cliente/creditos'); ?>" class="dashboard-card">
                <div class="dashboard-icon orange">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <h5>Mis créditos</h5>
                <p>Revisa tus cuotas, abonos y saldos pendientes.</p>
                <span>Ver créditos <i class="bi bi-arrow-right"></i></span>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="<?= base_url('cliente/garantias'); ?>" class="dashboard-card">
                <div class="dashboard-icon purple">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h5>Mis garantías</h5>
                <p>Consulta la cobertura de tus productos.</p>
                <span>Ver garantías <i class="bi bi-arrow-right"></i></span>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="<?= base_url('cliente/pagos'); ?>" class="dashboard-card">
                <div class="dashboard-icon teal">
                    <i class="bi bi-credit-card"></i>
                </div>
                <h5>Mis pagos</h5>
                <p>Consulta el historial y estado de tus pagos.</p>
                <span>Ver pagos <i class="bi bi-arrow-right"></i></span>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="<?= base_url('cliente/servicio_tecnico'); ?>" class="dashboard-card">
                <div class="dashboard-icon red">
                    <i class="bi bi-tools"></i>
                </div>
                <h5>Servicio técnico</h5>
                <p>Solicita mantenimiento y consulta reparaciones.</p>
                <span>Ver servicios <i class="bi bi-arrow-right"></i></span>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="<?= base_url('cliente/carrito'); ?>" class="dashboard-card">
                <div class="dashboard-icon yellow">
                    <i class="bi bi-cart3"></i>
                </div>
                <h5>Mi carrito</h5>
                <p>Revisa los productos que deseas comprar.</p>
                <span>Ir al carrito <i class="bi bi-arrow-right"></i></span>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="<?= base_url('cliente/perfil'); ?>" class="dashboard-card">
                <div class="dashboard-icon gray">
                    <i class="bi bi-person"></i>
                </div>
                <h5>Mi perfil</h5>
                <p>Administra tus datos personales y dirección.</p>
                <span>Ver perfil <i class="bi bi-arrow-right"></i></span>
            </a>
        </div>

    </div>

    <div class="client-information mt-4">
        <i class="bi bi-info-circle"></i>
        <div>
            <strong>¿Necesitas ayuda?</strong>
            <p>Desde este portal puedes consultar tus compras, pagos, garantías y servicios técnicos.</p>
        </div>
    </div>

</div>
