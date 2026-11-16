
$(document).ready(function () {

    // ==========================================
    // DATATABLES - USUARIOS
    // ==========================================

    if ($('#tablaUsuarios').length && $.fn.DataTable) {

        if (!$.fn.DataTable.isDataTable('#tablaUsuarios')) {

            $('#tablaUsuarios').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
                },
                order: [[0, 'desc']],
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                responsive: true,
                autoWidth: false,
                columnDefs: [
                    {
                        targets: [7],
                        orderable: false,
                        searchable: false
                    }
                ]
            });

        }
    }

    // ==========================================
    // PREVENIR DOBLE ENVÍO
    // ==========================================

    $('#formUsuario').on('submit', function () {

        const boton = $(this).find('button[type="submit"]');

        if (this.checkValidity()) {
            boton.prop('disabled', true);
            boton.text('Procesando...');
        }

    });

});
