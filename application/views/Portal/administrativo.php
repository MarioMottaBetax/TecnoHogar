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

        <a href="<?= base_url('portal'); ?>" class="back-home">
            <span>←</span> Volver al portal
        </a>

        <section class="portal-content">

            <div class="portal-heading">

                <a href="<?= base_url(); ?>" class="brand">
                    <span class="brand-icon">T</span>
                    <span class="brand-name">Tecno<span>Hogar</span></span>
                </a>

                <span class="section-tag">PORTAL EMPRESARIAL</span>

                <h1>Selecciona tu <span>cargo</span></h1>

                <p>
                    Elige el perfil con el que estás autorizado
                    a ingresar al sistema.
                </p>

            </div>


            <div class="role-grid">

                <!-- ADMINISTRADOR -->
                <a href="<?= base_url('auth/administrativo/1'); ?>"
                   class="role-card">

                    <div class="role-icon">⚙</div>

                    <span class="role-number">01</span>

                    <h2>Administrador</h2>

                    <p>
                        Acceso a la gestión general de TecnoHogar,
                        usuarios, permisos y configuración.
                    </p>

                    <span class="role-action">
                        Continuar <span>→</span>
                    </span>

                </a>


                <!-- VENDEDOR -->
                <a href="<?= base_url('auth/administrativo/2'); ?>"
                   class="role-card">

                    <div class="role-icon">▣</div>

                    <span class="role-number">02</span>

                    <h2>Vendedor</h2>

                    <p>
                        Gestión de pedidos, ventas, clientes
                        y atención comercial.
                    </p>

                    <span class="role-action">
                        Continuar <span>→</span>
                    </span>

                </a>


                <!-- TECNICO -->
                <a href="<?= base_url('auth/administrativo/3'); ?>"
                   class="role-card">

                    <div class="role-icon">⚒</div>

                    <span class="role-number">03</span>

                    <h2>Técnico</h2>

                    <p>
                        Gestión de reparaciones, diagnósticos,
                        garantías y seguimiento de servicios.
                    </p>

                    <span class="role-action">
                        Continuar <span>→</span>
                    </span>

                </a>

            </div>


            <div class="portal-security">
                <span>▣</span>
                El sistema verificará que tu cuenta corresponda al cargo seleccionado.
            </div>

        </section>


        <footer class="portal-footer">
            © <?= date('Y'); ?> TecnoHogar. Todos los derechos reservados.
        </footer>

    </main>

    <script src="<?= base_url('public/js/portal.js'); ?>"></script>

</body>
</html>