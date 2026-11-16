
$(document).ready(function () {

    // ==========================================
    // 1. DATATABLES - LISTADO DE PAGOS
    // ==========================================

    if ($('#tablaPagos').length && $.fn.DataTable) {

        if (!$.fn.DataTable.isDataTable('#tablaPagos')) {

            $('#tablaPagos').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
                },
                order: [[0, 'desc']],
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                responsive: true,
                autoWidth: false
            });

        }
    }


    // ==========================================
    // 2. FORMULARIO DE REGISTRO DE ABONOS
    // ==========================================

    const selectorCuota = $('#id_cuota');
    const campoMonto = $('#monto');
    const botonRegistrar = $('#btnRegistrar');
    const informacionCuota = $('#informacionCuota');


    // Formatear valores en pesos colombianos
    function formatoPesos(valor) {

        return '$' + Number(valor).toLocaleString('es-CO', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        });

    }


    // Validar que el abono no supere el saldo pendiente
    function validarMonto() {

        const monto = Number(campoMonto.val());
        const maximo = Number(campoMonto.attr('max'));

        const valido =
            campoMonto.val() !== '' &&
            Number.isFinite(monto) &&
            monto > 0 &&
            monto <= maximo;

        botonRegistrar.prop('disabled', !valido);

    }


    // Detectar selección de una cuota
    selectorCuota.on('change', function () {

        const opcion = $(this).find(':selected');

        if (!opcion.val()) {

            informacionCuota.hide();
            campoMonto.val('').removeAttr('max');
            botonRegistrar.prop('disabled', true);

            return;

        }

        const valor = Number(opcion.data('valor'));
        const abonado = Number(opcion.data('abonado'));
        const saldo = Number(opcion.data('saldo'));

        // Información del cliente y crédito
        $('#cliente').text(opcion.data('cliente'));
        $('#credito').text('#' + opcion.data('credito'));
        $('#numeroCuota').text(opcion.data('numero'));
        $('#fechaVencimiento').text(opcion.data('fecha'));

        // Información financiera
        $('#valorCuota').text(formatoPesos(valor));
        $('#totalAbonado').text(formatoPesos(abonado));
        $('#saldoPendiente').text(formatoPesos(saldo));

        // Establecer límite máximo del abono
        campoMonto.val('').attr('max', saldo);

        informacionCuota.show();

        botonRegistrar.prop('disabled', true);

    });


    // Validar el monto mientras se escribe
    campoMonto.on('input', validarMonto);


    // ==========================================
    // 3. PREVENIR DOBLE ENVÍO DEL FORMULARIO
    // ==========================================

    $('form[action*="pagos/guardar"]').on('submit', function () {

        if (botonRegistrar.prop('disabled')) {
            return false;
        }

        botonRegistrar
            .prop('disabled', true)
            .text('Registrando...');

    });

});
