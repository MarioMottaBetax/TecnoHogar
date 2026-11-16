
$(document).ready(function () {

    const idioma = {
        url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
    };

    if ($('#tablaIngresos').length) {
        $('#tablaIngresos').DataTable({
            language: idioma,
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            order: [[0, 'desc']],
            autoWidth: false
        });
    }

    if ($('#tablaEgresos').length) {
        $('#tablaEgresos').DataTable({
            language: idioma,
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            order: [[0, 'desc']],
            columnDefs: [
                {
                    targets: [6],
                    orderable: false,
                    searchable: false
                }
            ],
            autoWidth: false
        });
    }

    $('.form-eliminar-egreso').on('submit', function (e) {
        if (!confirm('¿Estás seguro de eliminar este egreso?')) {
            e.preventDefault();
        }
    });

});

$(document).ready(function () {

    if ($('#tablaEgresos').length && !$.fn.DataTable.isDataTable('#tablaEgresos')) {
        $('#tablaEgresos').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            pageLength: 10,
            order: [[0, 'desc']],
            columnDefs: [
                {
                    targets: [7],
                    orderable: false,
                    searchable: false
                }
            ]
        });
    }

    $('.form-eliminar-egreso').on('submit', function (e) {
        if (!confirm('¿Estás seguro de eliminar este egreso?')) {
            e.preventDefault();
        }
    });

});