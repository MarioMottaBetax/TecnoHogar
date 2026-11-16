
$(document).ready(function () {

    const tabla = $('#productosCompra');

    function formatoPesos(valor) {
        return '$' + Number(valor).toLocaleString('es-CO', {
            maximumFractionDigits: 2
        });
    }

    function calcularTotales() {
        let total = 0;

        tabla.find('.fila-producto').each(function () {

            const cantidad = parseFloat($(this).find('.cantidad-input').val()) || 0;
            const costo = parseFloat($(this).find('.costo-input').val()) || 0;

            const subtotal = cantidad * costo;

            $(this).find('.subtotal-input').val(formatoPesos(subtotal));

            total += subtotal;
        });

        $('#totalCompra').text(formatoPesos(total));
    }

    $('#agregarProducto').on('click', function () {

        const primeraFila = tabla.find('.fila-producto').first();
        const nuevaFila = primeraFila.clone();

        nuevaFila.find('select').val('');
        nuevaFila.find('input').val('');

        tabla.append(nuevaFila);

        calcularTotales();
    });

    tabla.on('input change', '.cantidad-input, .costo-input', function () {
        calcularTotales();
    });

    tabla.on('click', '.eliminar-producto', function () {

        if (tabla.find('.fila-producto').length > 1) {
            $(this).closest('tr').remove();
        } else {
            const fila = $(this).closest('tr');
            fila.find('select').val('');
            fila.find('input').val('');
        }

        calcularTotales();
    });

    $('#formCompra').on('submit', function (e) {

        let valido = true;
        let productosSeleccionados = [];

        tabla.find('.fila-producto').each(function () {

            const producto = $(this).find('.producto-select').val();
            const cantidad = parseInt($(this).find('.cantidad-input').val(), 10);
            const costo = parseFloat($(this).find('.costo-input').val());

            if (!producto || !Number.isInteger(cantidad) || cantidad <= 0 ||
                !Number.isFinite(costo) || costo <= 0) {
                valido = false;
            }

            if (productosSeleccionados.includes(producto)) {
                valido = false;
                alert('No puedes agregar el mismo producto dos veces.');
                return false;
            }

            productosSeleccionados.push(producto);
        });

        if (!valido) {
            e.preventDefault();
            alert('Revisa que todos los productos tengan una cantidad y un costo válido.');
        }

    });

});
