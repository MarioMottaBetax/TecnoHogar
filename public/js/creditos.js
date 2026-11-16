
$(document).ready(function () {

    // ==========================================
    // DATATABLES - CRÉDITOS
    // ==========================================

    if ($('#tablaCreditos').length && $.fn.DataTable) {

        if (!$.fn.DataTable.isDataTable('#tablaCreditos')) {

            $('#tablaCreditos').DataTable({
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
                        targets: [9],
                        orderable: false,
                        searchable: false
                    }
                ]
            });

        }
    }

});
