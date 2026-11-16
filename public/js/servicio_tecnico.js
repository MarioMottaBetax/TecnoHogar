
$(document).ready(function () {

    console.log('Servicio técnico JS cargado correctamente.');

    // Verificar que DataTables esté disponible
    if (typeof $.fn.DataTable === 'undefined') {
        console.error('Error: DataTables no está cargado.');
        return;
    }

    // TABLA DE SERVICIOS TÉCNICOS
    if ($('#tablaServicios').length) {

        if (!$.fn.DataTable.isDataTable('#tablaServicios')) {

            $('#tablaServicios').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },

                pageLength: 10,

                lengthMenu: [
                    [5, 10, 25, 50, 100],
                    [5, 10, 25, 50, 100]
                ],

                order: [[0, 'desc']],

                columnDefs: [
                    {
                        targets: 8,
                        orderable: false,
                        searchable: false
                    }
                ],

                autoWidth: false,
                stateSave: false
            });

            console.log('DataTables de servicios técnicos inicializado.');
        }
    }

    // TABLA DE GESTIÓN DE TÉCNICOS
    if ($('#tablaTecnicos').length) {

        if (!$.fn.DataTable.isDataTable('#tablaTecnicos')) {

            $('#tablaTecnicos').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },

                pageLength: 10,

                lengthMenu: [
                    [5, 10, 25, 50],
                    [5, 10, 25, 50]
                ],

                order: [[0, 'asc']],

                columnDefs: [
                    {
                        targets: -1,
                        orderable: false,
                        searchable: false
                    }
                ],

                autoWidth: false,
                stateSave: false
            });

            console.log('DataTables de técnicos inicializado.');
        }
    }

});
