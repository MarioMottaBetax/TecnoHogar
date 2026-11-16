

$(document).ready(function () {

    // Tabla de descuentos
    if ($('#tablaDescuentos').length && $.fn.DataTable) {
        if (!$.fn.DataTable.isDataTable('#tablaDescuentos')) {
            $('#tablaDescuentos').DataTable({
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

    // Calcular compra mínima
    function calcularCompraMinima() {
        const valor = parseFloat($('#valorCupon').val()) || 0;
        const minimo = valor * 10;

        $('#compraMinima').val(
            '$' + minimo.toLocaleString('es-CO', {
                maximumFractionDigits: 2
            })
        );
    }

    $('#valorCupon').on('input', calcularCompraMinima);

    // Calcular al abrir edición
    calcularCompraMinima();

    // Evitar envíos repetidos
    $('#formDescuento').on('submit', function () {
        if (this.checkValidity()) {
            const boton = $(this).find('button[type="submit"]');
            boton.prop('disabled', true);
            boton.text('Procesando...');
        }
    });

});
