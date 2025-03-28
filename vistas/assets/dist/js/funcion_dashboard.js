// C:\wamp64\www\helpmdq\vistas\assets\dist\js\funcion_dashboard.js
var dataticket = {}; // Variable para almacenar los datos de los tickets
document.addEventListener("DOMContentLoaded", function () {
    // Hacer la solicitud fetch cada vez que se carga la página
    fetch(`${BASE_URL}/controladores/dashboard/DashboardControlador.php`)
        .then(response => response.json())
        .then(data => {
            updateDashboard(data); // Actualizar el dashboard con los datos obtenidos
        })
        .catch(error => console.error("Error cargando datos:", error));

    function updateDashboard(data) {
        dataticket = data;
        // Actualizar los valores en la interfaz
        document.getElementById("total_trabajadores").textContent = data.total_trabajadores;
        document.getElementById("total_soporte").textContent = data.total_soporte;
        document.getElementById("total_roles").textContent = data.total_roles;
        document.getElementById("total_inventario").textContent = data.total_inventario;
        document.getElementById("total_problemas").textContent = data.total_problemas;
        document.getElementById("total_tickets").textContent = data.total_tickets;
        document.getElementById("abiertos").textContent = data.abiertos;
        document.getElementById("en_atencion").textContent = data.en_atencion;
        document.getElementById("resueltos").textContent = data.resueltos;
        document.getElementById("reabiertos").textContent = data.reabiertos;
        document.getElementById("cerrados").textContent = data.cerrados;

        
    }
});




document.addEventListener("DOMContentLoaded", function () {
    let myChart = null; // Variable para almacenar la instancia del gráfico

    function renderChart() {
        if (myChart) {
            myChart.destroy(); // Elimina el gráfico si ya existe
        }

        const ctx = document.getElementById('tickets').getContext('2d');
        const donutData = {
            labels: ['Abiertos: ' + dataticket.abiertos,
            'En Atención: ' + dataticket.en_atencion,
            'Resuelto: ' + dataticket.resueltos,
            'Reabierto: ' + dataticket.reabiertos,
            'Cerrados: ' + dataticket.cerrados],
            datasets: [{
                data: [dataticket.abiertos,
                dataticket.en_atencion,
                dataticket.resueltos,
                dataticket.reabiertos,
                dataticket.cerrados],
                backgroundColor: ['#dc3545', '#ffc107', '#28a745', '#17a2b8', '#6c757d'],
                borderColor: '#fff',
                borderWidth: 2,
                hoverOffset: 10
            }]
        };

        const donutOptions = {
            maintainAspectRatio: false,
            responsive: true,
            animation: { animateRotate: true, animateScale: true },
            plugins: {
                legend: { display: true, position: 'bottom' },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function (tooltipItem) {
                            let value = donutData.datasets[0].data[tooltipItem.dataIndex];
                            return `${donutData.labels[tooltipItem.dataIndex]}: ${value} Tickets`;
                        }
                    }
                }
            }
        };

        myChart = new Chart(ctx, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
        });
    }

    setTimeout(() => {
        if (Object.keys(dataticket).length > 0) {
            renderChart(); // Renderiza el gráfico una sola vez
        } else {
            console.error("Los datos de tickets no están disponibles aún.");
        }
    }, 500);

    // 📷 Descargar como PNG
    document.getElementById('downloadPNG').addEventListener('click', function () {
        const link = document.createElement('a');
        link.href = document.getElementById('tickets').toDataURL('image/png');
        link.download = 'grafico.png';
        link.click();
    });

    // 📷 Descargar como JPG
    document.getElementById('downloadJPG').addEventListener('click', function () {
        const link = document.createElement('a');
        link.href = document.getElementById('tickets').toDataURL('image/jpeg');
        link.download = 'grafico.jpg';
        link.click();
    });

    // 📄 Descargar como PDF
    document.getElementById('downloadPDF').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const imgData = document.getElementById('tickets').toDataURL('image/png');

        doc.text("Reporte de Tickets", 80, 10);
        doc.addImage(imgData, 'PNG', 40, 30, 130, 100);
        doc.save("grafico.pdf");
    });

});