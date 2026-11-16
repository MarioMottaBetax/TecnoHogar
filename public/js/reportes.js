
$(document).ready(function () {

    if (typeof Chart === 'undefined' || !window.datosReportes) {
        console.error('No se pudo cargar Chart.js o los datos del reporte.');
        return;
    }

    const ingresos = window.datosReportes.ingresos || [];
    const egresos = window.datosReportes.egresos || [];
    const categorias = window.datosReportes.categorias || [];

    const meses = [...new Set([
        ...ingresos.map(item => item.mes),
        ...egresos.map(item => item.mes)
    ])].sort();

    const obtenerValor = function (lista, mes) {
        const registro = lista.find(item => item.mes === mes);
        return registro ? Number(registro.total) : 0;
    };

    const nombresMeses = meses.map(mes => {
        const partes = mes.split('-');
        return partes[1] + '/' + partes[0];
    });

    new Chart(document.getElementById('graficoFinanciero'), {
        type: 'bar',
        data: {
            labels: nombresMeses,
            datasets: [
                {
                    label: 'Ingresos',
                    data: meses.map(mes => obtenerValor(ingresos, mes)),
                    backgroundColor: '#198754'
                },
                {
                    label: 'Egresos',
                    data: meses.map(mes => obtenerValor(egresos, mes)),
                    backgroundColor: '#dc3545'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    new Chart(document.getElementById('graficoCategorias'), {
        type: 'doughnut',
        data: {
            labels: categorias.map(item => item.categoria || 'Sin categoría'),
            datasets: [{
                data: categorias.map(item => Number(item.cantidad))
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });

});
