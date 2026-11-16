<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= html_escape($titulo); ?></title>

    <link rel="stylesheet" href="<?= base_url('public/css/portal.css'); ?>">
</head>

<body>

    <main class="portal-container">

        <a href="<?= base_url(); ?>" class="back-home">
            <span>←</span> Volver al inicio
        </a>

        <section class="portal-content">

            <div class="portal-heading">

                <a href="<?= base_url(); ?>" class="brand">
                    <span class="brand-icon">T</span>
                    <span class="brand-name">Tecno<span>Hogar</span></span>
                </a>

                <span class="section-tag">PLATAFORMA TECNOHOGAR</span>

                <h1>Bienvenido a nuestro <span>portal</span></h1>

                <p>
                    Selecciona el tipo de acceso que deseas utilizar
                    para continuar.
                </p>

            </div>


            <div class="access-options">

                <!-- ACCESO CLIENTES -->
                <article class="access-card">

                    <div class="access-icon">
                        <span>♙</span>
                    </div>

                    <span class="card-label">PORTAL DE CLIENTES</span>

                    <h2>Usuario</h2>

                    <p>
                        Accede a tu cuenta para consultar tus compras,
                        pagos, garantías y servicios técnicos.
                    </p>

                    <ul>
                        <li>Historial de compras</li>
                        <li>Seguimiento de reparaciones</li>
                        <li>Consulta de garantías</li>
                        <li>Información de pagos</li>
                    </ul>

                    <a href="<?= base_url('auth/cliente'); ?>"
                       class="access-button primary-button">
                        Ingresar como usuario
                        <span>→</span>
                    </a>

                    <div class="card-footer">
                        ¿Todavía no tienes cuenta?
                        <a href="<?= base_url('auth/registro'); ?>">Regístrate aquí</a>
                    </div>

                </article>


                <!-- ACCESO ADMINISTRATIVO -->
                <article class="access-card administrative-card">

                    <div class="access-icon">
                        <span>▣</span>
                    </div>

                    <span class="card-label">PORTAL EMPRESARIAL</span>

                    <h2>Administrativo</h2>

                    <p>
                        Accede a las herramientas de gestión empresarial
                        de TecnoHogar según tu cargo y permisos.
                    </p>

                    <ul>
                        <li>Gestión de ventas e inventario</li>
                        <li>Contabilidad y finanzas</li>
                        <li>CRM y atención al cliente</li>
                        <li>Administración y reportes</li>
                    </ul>

                    <a href="<?= base_url('portal/administrativo'); ?>"
                       class="access-button secondary-button">
                        Ingresar al portal administrativo
                        <span>→</span>
                    </a>

                    <div class="card-footer">
                        Acceso exclusivo para personal autorizado.
                    </div>

                </article>

            </div>


            <div class="portal-security">
                <span>▣</span>
                Acceso protegido y personalizado según el tipo de cuenta.
            </div>

        </section>


        <footer class="portal-footer">
            © <?= date('Y'); ?> TecnoHogar. Todos los derechos reservados.
        </footer>

    </main>

    <script src="<?= base_url('public/js/portal.js'); ?>"></script>

</body>
</html>