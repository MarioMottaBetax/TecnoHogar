<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= html_escape($titulo); ?></title>

    <meta name="description" content="En TecnoHogar encuentras tecnología, electrodomésticos, garantías y servicio técnico en un solo lugar.">

    <link rel="stylesheet" href="<?= base_url('public/css/welcome.css'); ?>">
</head>

<body>

    <!-- ENCABEZADO -->
    <header class="header" id="inicio">
        <div class="container navbar">

            <a href="<?= base_url(); ?>" class="brand">
                <span class="brand-icon">T</span>
                <span class="brand-name">Tecno<span>Hogar</span></span>
            </a>

            <button class="menu-toggle" id="menuToggle"
                    aria-label="Abrir menú" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav class="nav-menu" id="navMenu">
                <a href="#inicio" class="nav-link active">Inicio</a>
                <a href="#categorias" class="nav-link">Categorías</a>
                <a href="#servicios" class="nav-link">Servicios</a>
                <a href="#nosotros" class="nav-link">Nosotros</a>

                <a href="<?= base_url('portal'); ?>" class="nav-login">
                    Iniciar sesión
                    <span>→</span>
                </a>
            </nav>

        </div>
    </header>


    <main>

        <!-- HERO / PRESENTACIÓN -->
        <section class="hero">
            <div class="hero-background"></div>

            <div class="container hero-content">

                <div class="hero-text">

                    <span class="eyebrow">
                        <span class="status-dot"></span>
                        TECNOLOGÍA Y SOLUCIONES PARA TI
                    </span>

                    <h1>
                        La tecnología que necesitas,
                        <span>más cerca de ti.</span>
                    </h1>

                    <p>
                        Descubre productos tecnológicos y electrodomésticos
                        que hacen tu vida más fácil. Compra con confianza
                        y disfruta de nuestro servicio posventa.
                    </p>

                    <div class="hero-actions">
                        <a href="#categorias" class="btn btn-primary">
                            Explorar productos
                            <span>→</span>
                        </a>

                        <a href="#servicios" class="btn btn-outline">
                            Conoce nuestros servicios
                        </a>
                    </div>

                    <div class="hero-benefits">
                        <div>
                            <span class="benefit-check">✓</span>
                            Productos de calidad
                        </div>

                        <div>
                            <span class="benefit-check">✓</span>
                            Garantía y respaldo
                        </div>

                        <div>
                            <span class="benefit-check">✓</span>
                            Atención personalizada
                        </div>
                    </div>

                </div>

                <div class="hero-visual">

                    <div class="visual-glow"></div>

                    <div class="visual-card visual-card-main">
                        <div class="visual-top">
                            <span class="visual-label">TECNOLOGÍA</span>
                            <span class="visual-dot-blue"></span>
                        </div>

                        <div class="device-display">
                            <div class="device-screen">
                                <div class="screen-circle"></div>
                                <div class="screen-line"></div>
                                <div class="screen-line short"></div>
                            </div>

                            <div class="device-stand"></div>
                        </div>

                        <div class="visual-caption">
                            <strong>Innovación para tu hogar</strong>
                            <span>Todo lo que necesitas en un solo lugar.</span>
                        </div>
                    </div>

                    <div class="floating-card floating-card-top">
                        <span class="floating-icon">✓</span>
                        <div>
                            <strong>Compra segura</strong>
                            <small>Confianza y respaldo</small>
                        </div>
                    </div>

                    <div class="floating-card floating-card-bottom">
                        <span class="floating-icon">⌂</span>
                        <div>
                            <strong>Servicio técnico</strong>
                            <small>Estamos para ayudarte</small>
                        </div>
                    </div>

                </div>

            </div>

            <div class="hero-bottom">
                <span>TECNOHOGAR</span>
                <span class="hero-bottom-line"></span>
                <span>TECNOLOGÍA PARA TU DÍA A DÍA</span>
            </div>

        </section>


        <!-- CATEGORÍAS -->
        <section class="categories section" id="categorias">

            <div class="container">

                <div class="section-heading">
                    <div>
                        <span class="section-tag">NUESTRO CATÁLOGO</span>
                        <h2>Explora nuestras <span>categorías</span></h2>
                    </div>

                    <p>
                        Encuentra soluciones tecnológicas para cada
                        espacio y necesidad de tu hogar.
                    </p>
                </div>

                <div class="category-grid">

                    <article class="category-card">
                        <div class="category-icon icon-tv">TV</div>
                        <span class="category-number">01</span>
                        <h3>Televisores</h3>
                        <p>Disfruta tus contenidos favoritos con una gran experiencia visual.</p>
                        <a href="<?= base_url('portal'); ?>" class="category-link">
                            Explorar <span>→</span>
                        </a>
                    </article>

                    <article class="category-card">
                        <div class="category-icon icon-phone">PH</div>
                        <span class="category-number">02</span>
                        <h3>Celulares</h3>
                        <p>Conecta con el mundo mediante tecnología a tu alcance.</p>
                        <a href="<?= base_url('portal'); ?>" class="category-link">
                            Explorar <span>→</span>
                        </a>
                    </article>

                    <article class="category-card">
                        <div class="category-icon icon-home">⌂</div>
                        <span class="category-number">03</span>
                        <h3>Electrodomésticos</h3>
                        <p>Haz que las tareas de tu hogar sean mucho más sencillas.</p>
                        <a href="<?= base_url('portal'); ?>" class="category-link">
                            Explorar <span>→</span>
                        </a>
                    </article>

                    <article class="category-card">
                        <div class="category-icon icon-tech">IT</div>
                        <span class="category-number">04</span>
                        <h3>Accesorios</h3>
                        <p>Complementa tus dispositivos con accesorios tecnológicos.</p>
                        <a href="<?= base_url('portal'); ?>" class="category-link">
                            Explorar <span>→</span>
                        </a>
                    </article>

                </div>

            </div>

        </section>


        <!-- SERVICIOS -->
        <section class="services section" id="servicios">

            <div class="container">

                <div class="section-heading centered">
                    <span class="section-tag">NUESTRO COMPROMISO</span>
                    <h2>Más que productos, <span>soluciones</span></h2>
                    <p>
                        Nuestro compromiso continúa después de tu compra.
                        Queremos acompañarte en cada etapa.
                    </p>
                </div>

                <div class="services-grid">

                    <article class="service-card">
                        <div class="service-icon">▣</div>
                        <h3>Compras y ventas</h3>
                        <p>
                            Encuentra productos para tu hogar con
                            información clara y atención personalizada.
                        </p>
                    </article>

                    <article class="service-card">
                        <div class="service-icon">◇</div>
                        <h3>Garantías</h3>
                        <p>
                            Consulta la cobertura de tus productos
                            y recibe acompañamiento cuando lo necesites.
                        </p>
                    </article>

                    <article class="service-card">
                        <div class="service-icon">⚙</div>
                        <h3>Servicio técnico</h3>
                        <p>
                            Gestionamos reparaciones y te mantenemos
                            informado sobre el estado de tu equipo.
                        </p>
                    </article>

                    <article class="service-card">
                        <div class="service-icon">$</div>
                        <h3>Facilidades de pago</h3>
                        <p>
                            Consulta las alternativas de pago y
                            financiación disponibles en TecnoHogar.
                        </p>
                    </article>

                </div>

            </div>

        </section>


        <!-- NOSOTROS -->
        <section class="about section" id="nosotros">

            <div class="container about-container">

                <div class="about-visual">
                    <div class="about-square"></div>

                    <div class="about-content">
                        <span class="about-symbol">T</span>
                        <strong>TecnoHogar</strong>
                        <span>TECNOLOGÍA PARA TU HOGAR</span>
                    </div>

                    <div class="about-decoration"></div>
                </div>

                <div class="about-text">

                    <span class="section-tag">SOBRE NOSOTROS</span>

                    <h2>
                        Tecnología, confianza
                        y atención en <span>un solo lugar.</span>
                    </h2>

                    <p>
                        En TecnoHogar trabajamos para ofrecer productos
                        tecnológicos y soluciones que respondan a las
                        necesidades de nuestros clientes.
                    </p>

                    <p>
                        Buscamos construir relaciones duraderas mediante
                        una atención cercana, seguimiento de compras,
                        garantías y servicio técnico.
                    </p>

                    <a href="<?= base_url('portal'); ?>" class="btn btn-primary">
                        Conoce nuestra plataforma <span>→</span>
                    </a>

                </div>

            </div>

        </section>


        <!-- LLAMADO A LA ACCIÓN -->
        <section class="cta-section">

            <div class="container cta-content">

                <div>
                    <span class="section-tag">TU EXPERIENCIA COMIENZA AQUÍ</span>
                    <h2>¿Listo para descubrir TecnoHogar?</h2>
                    <p>
                        Accede a nuestra plataforma y descubre
                        todo lo que tenemos para ofrecerte.
                    </p>
                </div>

                <a href="<?= base_url('portal'); ?>" class="btn btn-light">
                    Ingresar a la plataforma <span>→</span>
                </a>

            </div>

        </section>

    </main>


    <!-- PIE DE PÁGINA -->
    <footer class="footer">

        <div class="container footer-main">

            <div class="footer-brand">
                <a href="#inicio" class="brand footer-logo">
                    <span class="brand-icon">T</span>
                    <span class="brand-name">Tecno<span>Hogar</span></span>
                </a>

                <p>
                    Tecnología, productos y soluciones
                    para hacer tu vida más fácil.
                </p>
            </div>

            <div class="footer-column">
                <h4>Navegación</h4>
                <a href="#inicio">Inicio</a>
                <a href="#categorias">Categorías</a>
                <a href="#servicios">Servicios</a>
                <a href="#nosotros">Nosotros</a>
            </div>

            <div class="footer-column">
                <h4>Plataforma</h4>
                <a href="<?= base_url('portal'); ?>">Iniciar sesión</a>
                <a href="#servicios">Garantías</a>
                <a href="#servicios">Servicio técnico</a>
            </div>

            <div class="footer-column">
                <h4>Atención</h4>
                <p>Estamos para ayudarte.</p>
                <p>Consulta nuestros servicios y canales de atención.</p>
            </div>

        </div>

        <div class="footer-bottom">
            <div class="container footer-bottom-content">
                <p>
                    © <span id="currentYear"></span> TecnoHogar.
                    Todos los derechos reservados.
                </p>

                <span>TECNOLOGÍA PARA TU HOGAR</span>
            </div>
        </div>

    </footer>


    <script src="<?= base_url('public/js/welcome.js'); ?>"></script>

</body>
</html>