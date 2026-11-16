
document.addEventListener('DOMContentLoaded', function () {

    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');

    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function () {
            sidebar.classList.toggle('show');
        });
    }

});

// Tabla de proveedores
$(document).ready(function () {

    if ($('#tablaProveedores').length) {

        $('#tablaProveedores').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            ordering: true,
            searching: true,
            paging: true,
            info: true
        });

    }

});


$(document).ready(function () {
    if ($('#tablaCompras').length) {
        $('#tablaCompras').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            ordering: true,
            searching: true,
            paging: true,
            info: true
        });
    }
});


$(document).ready(function () {

    if ($('#tablaClientes').length) {

        $('#tablaClientes').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            ordering: true,
            searching: true,
            paging: true,
            info: true
        });

    }

});

// Tabla de ventas
$(document).ready(function () {

    if ($('#tablaVentas').length) {

        $('#tablaVentas').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            ordering: true,
            searching: true,
            paging: true,
            info: true
        });

    }

});

// Tabla de garantías
$(document).ready(function () {

    if ($('#tablaGarantias').length) {

        $('#tablaGarantias').DataTable({
            language: {
                url: 'https://cdn.datatables.net/1.13.6/i18n/es-ES.json'
            },
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            ordering: true,
            searching: true,
            paging: true,
            info: true
        });

    }

});