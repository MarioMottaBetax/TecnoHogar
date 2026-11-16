
$(document).ready(function () {

    // ==========================================
    // CONFIGURACIÓN
    // ==========================================

    function formatoPesos(valor) {
        return '$' + Number(valor).toLocaleString('es-CO', {
            maximumFractionDigits: 0
        });
    }

    let subtotalActual = 0;
    let descuentoActual = 0;
    let cuponesDisponibles = [];

    // ==========================================
    // CÁLCULO DE TOTALES Y CUPONES
    // ==========================================

    function calcularTotales() {

        let subtotal = 0;

        $('#productosVenta .fila-producto').each(function () {

            const fila = $(this);
            const opcion = fila.find('.producto-select option:selected');

            const precio = Number(opcion.data('precio')) || 0;
            const stock = Number(opcion.data('stock')) || 0;
            const cantidad = Number(fila.find('.cantidad').val()) || 0;

            const importe = precio * cantidad;

            fila.find('.precio').text(formatoPesos(precio));
            fila.find('.stock').text(stock);
            fila.find('.subtotal').text(formatoPesos(importe));

            subtotal += importe;
        });

        subtotalActual = subtotal;

        const cuponSeleccionado = $('#cuponVenta').val();

        descuentoActual = 0;

        if (cuponSeleccionado) {

            const cupon = cuponesDisponibles.find(function (item) {
                return String(item.id_descuento) === String(cuponSeleccionado);
            });

            if (cupon) {

                if (subtotal >= Number(cupon.rango)) {
                    descuentoActual = Number(cupon.cupon);
                } else {
                    $('#informacionCupon').text(
                        'Este cupón requiere una compra mínima de ' +
                        formatoPesos(cupon.rango) + '.'
                    );
                }
            }
        }

        $('#subtotalGeneral').text(formatoPesos(subtotal));
        $('#descuentoGeneral').text(formatoPesos(descuentoActual));
        $('#totalGeneral').text(formatoPesos(subtotal - descuentoActual));

        if (cuponSeleccionado && descuentoActual === 0) {
            $('#informacionCupon').text(
                'No cumples todavía la compra mínima para utilizar este cupón.'
            );
        } else if (cuponSeleccionado && descuentoActual > 0) {
            $('#informacionCupon').text(
                '¡Cupón aplicado correctamente! Descuento de ' +
                formatoPesos(descuentoActual) + '.'
            );
        }

        return subtotal - descuentoActual;
    }

    // ==========================================
    // CARGAR CUPONES DEL CLIENTE
    // ==========================================

    function cargarCupones(idUsuario) {

        const selector = $('#cuponVenta');

        cuponesDisponibles = [];
        descuentoActual = 0;

        selector.empty();

        if (!idUsuario) {

            selector.append(
                '<option value="">Selecciona primero un cliente</option>'
            );

            selector.prop('disabled', true);

            $('#informacionCupon').text(
                'Los cupones disponibles del cliente aparecerán aquí.'
            );

            calcularTotales();
            return;
        }

        selector.append(
            '<option value="">Cargando cupones...</option>'
        );

        selector.prop('disabled', true);

        $.ajax({

            url: BASE_URL + 'ventas/cupones/' + encodeURIComponent(idUsuario),
            type: 'GET',
            dataType: 'json',

            success: function (respuesta) {

                selector.empty();

                if (
                    respuesta.success &&
                    Array.isArray(respuesta.cupones) &&
                    respuesta.cupones.length > 0
                ) {

                    cuponesDisponibles = respuesta.cupones;

                    selector.append(
                        '<option value="">No aplicar cupón</option>'
                    );

                    cuponesDisponibles.forEach(function (cupon) {

                        const texto =
                            'Cupón de ' + formatoPesos(cupon.cupon) +
                            ' - Compra mínima: ' + formatoPesos(cupon.rango);

                        selector.append(
                            $('<option>', {
                                value: cupon.id_descuento,
                                text: texto
                            })
                        );
                    });

                    selector.prop('disabled', false);

                    $('#informacionCupon').text(
                        'Se encontraron ' +
                        cuponesDisponibles.length +
                        ' cupones para este cliente.'
                    );

                } else {

                    selector.append(
                        '<option value="">Este cliente no tiene cupones</option>'
                    );

                    selector.prop('disabled', true);

                    $('#informacionCupon').text(
                        'No hay cupones asignados a este cliente.'
                    );
                }

                calcularTotales();
            },

            error: function (xhr) {

                console.error('Error al cargar cupones:', xhr.responseText);

                selector.empty().append(
                    '<option value="">Error al consultar cupones</option>'
                );

                selector.prop('disabled', true);

                $('#informacionCupon').text(
                    'No fue posible consultar los cupones. Intenta nuevamente.'
                );
            }

        });
    }

    // Seleccionar cliente
    $('#clienteVenta').on('change', function () {
        cargarCupones($(this).val());
    });

    // Seleccionar cupón
    $('#cuponVenta').on('change', function () {
        calcularTotales();
    });

    // ==========================================
    // PRODUCTOS
    // ==========================================

    function actualizarOpciones() {

        const seleccionados = [];

        $('.producto-select').each(function () {

            if ($(this).val()) {
                seleccionados.push($(this).val());
            }
        });

        $('.producto-select').each(function () {

            const actual = $(this).val();

            $(this).find('option').each(function () {

                const valor = $(this).val();

                if (
                    valor &&
                    seleccionados.includes(valor) &&
                    valor !== actual
                ) {
                    $(this).prop('disabled', true);
                } else {
                    $(this).prop('disabled', false);
                }
            });
        });
    }

    $('#agregarProducto').on('click', function () {

        const primeraFila = $('#productosVenta .fila-producto').first();
        const nuevaFila = primeraFila.clone();

        nuevaFila.find('select').val('');
        nuevaFila.find('.cantidad').val(1);
        nuevaFila.find('.precio, .subtotal').text('$0');
        nuevaFila.find('.stock').text('0');

        $('#productosVenta').append(nuevaFila);

        actualizarOpciones();
        calcularTotales();
    });

    $(document).on('change', '.producto-select', function () {

        actualizarOpciones();
        calcularTotales();
    });

    $(document).on('input', '.cantidad', function () {

        const fila = $(this).closest('.fila-producto');
        const opcion = fila.find('.producto-select option:selected');

        const stock = Number(opcion.data('stock')) || 0;

        let cantidad = Number($(this).val()) || 0;

        if (cantidad < 1) {
            cantidad = 1;
            $(this).val(1);
        }

        if (cantidad > stock && stock > 0) {
            cantidad = stock;
            $(this).val(stock);
        }

        calcularTotales();
    });

    $(document).on('click', '.eliminarProducto', function () {

        const filas = $('#productosVenta .fila-producto');

        if (filas.length > 1) {

            $(this).closest('.fila-producto').remove();

            actualizarOpciones();
            calcularTotales();
        }
    });

    // ==========================================
    // MODALIDAD DE PAGO
    // ==========================================

    const modalidad = $('#modalidadPago');
    const camposCredito = $('#camposCredito');
    const cuotaInicial = $('#cuotaInicial');
    const numeroCuotas = $('#numeroCuotas');

    function actualizarModalidad() {

        if (modalidad.val() === 'credito') {

            camposCredito.show();

            cuotaInicial.prop('required', true);
            numeroCuotas.prop('required', true);

        } else {

            camposCredito.hide();

            cuotaInicial.prop('required', false).val(0);
            numeroCuotas.prop('required', false).val(1);
        }
    }

    modalidad.on('change', actualizarModalidad);

    actualizarModalidad();

    // ==========================================
    // INICIALIZACIÓN
    // ==========================================

    calcularTotales();
    actualizarOpciones();

});
