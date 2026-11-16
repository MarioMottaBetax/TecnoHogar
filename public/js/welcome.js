document.addEventListener('DOMContentLoaded', function () {

    // Elementos del menú
    const menuToggle = document.getElementById('menuToggle');
    const navMenu = document.getElementById('navMenu');
    const navLinks = document.querySelectorAll('.nav-link');

    // Abrir y cerrar menú móvil
    if (menuToggle && navMenu) {

        menuToggle.addEventListener('click', function () {

            const isOpen = navMenu.classList.toggle('open');

            menuToggle.classList.toggle('active', isOpen);
            menuToggle.setAttribute('aria-expanded', isOpen);

        });

        // Cerrar menú al seleccionar una sección
        navLinks.forEach(function (link) {

            link.addEventListener('click', function () {

                navMenu.classList.remove('open');
                menuToggle.classList.remove('active');

                menuToggle.setAttribute('aria-expanded', 'false');

            });

        });

        // Cerrar menú si se cambia a pantalla grande
        window.addEventListener('resize', function () {

            if (window.innerWidth > 760) {

                navMenu.classList.remove('open');
                menuToggle.classList.remove('active');

                menuToggle.setAttribute('aria-expanded', 'false');

            }

        });

    }


    // Año automático del pie de página
    const currentYear = document.getElementById('currentYear');

    if (currentYear) {
        currentYear.textContent = new Date().getFullYear();
    }


    // Actualizar enlace activo de navegación
    const sections = document.querySelectorAll('main section[id]');

    if ('IntersectionObserver' in window) {

        const observer = new IntersectionObserver(function (entries) {

            entries.forEach(function (entry) {

                if (entry.isIntersecting) {

                    navLinks.forEach(function (link) {

                        link.classList.remove('active');

                        if (link.getAttribute('href') === '#' + entry.target.id) {
                            link.classList.add('active');
                        }

                    });

                }

            });

        }, {
            rootMargin: '-30% 0px -60% 0px'
        });

        sections.forEach(function (section) {
            observer.observe(section);
        });

    }

});