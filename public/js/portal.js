document.addEventListener('DOMContentLoaded', function () {

    // Efecto visual al seleccionar una tarjeta de acceso
    const accessCards = document.querySelectorAll('.access-card, .role-card');

    accessCards.forEach(function (card) {

        card.addEventListener('mouseenter', function () {
            card.classList.add('card-active');
        });

        card.addEventListener('mouseleave', function () {
            card.classList.remove('card-active');
        });

    });

});