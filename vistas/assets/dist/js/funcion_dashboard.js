document.addEventListener("DOMContentLoaded", function () {
    cargarResumenGeneral();
    cargarEstadoTickets();
});





function cargarResumenGeneral() {
    fetch(`${BASE_URL}/controladores/dashboard/DashboardControlador.php?action=ResumenGeneral`, { method: 'GET' })
        .then(response => response.json())
        .then(data => {
            document.getElementById("total_trabajadores").textContent = data.total_trabajadores;
            document.getElementById("total_soporte").textContent = data.total_soporte;
            document.getElementById("total_roles").textContent = data.total_roles;
            document.getElementById("total_problemas").textContent = data.total_problemas;
            document.getElementById("total_tickets").textContent = data.total_tickets;
        })
        .catch(error => console.error("Error cargando resumen general:", error));
}





let dataticket = {};
function cargarEstadoTickets() {
    fetch(`${BASE_URL}/controladores/dashboard/DashboardControlador.php?action=EstadoTickets`, { method: 'GET' })
        .then(response => response.json())
        .then(data => {
            dataticket = data;
            document.getElementById("TicketAbiertos").textContent = data.TicketsAbiertos;
            document.getElementById("TicketEnAtencion").textContent = data.TicketsEnAtencion;
            document.getElementById("TicketResueltos").textContent = data.TicketsResueltos;
            document.getElementById("TicketReabiertos").textContent = data.TicketsReabiertos;
            document.getElementById("TicketCerrados").textContent = data.TicketsCerrados;
        })
        .catch(error => console.error("Error cargando estado de tickets:", error));
}





document.addEventListener("DOMContentLoaded", function () {
    let myChart = null;

    function renderChart() {
        if (myChart) {
            myChart.destroy();
        }
        const ctx = document.getElementById('tickets').getContext('2d');
        const donutData = {
            labels: ['Abiertos: ' + dataticket.TicketsAbiertos,
            'En Atención: ' + dataticket.TicketsEnAtencion,
            'Resuelto: ' + dataticket.TicketsResueltos,
            'Reabierto: ' + dataticket.TicketsReabiertos,
            'Cerrados: ' + dataticket.TicketsCerrados],
            datasets: [{
                data: [dataticket.TicketsAbiertos,
                dataticket.TicketsEnAtencion,
                dataticket.TicketsResueltos,
                dataticket.TicketsReabiertos,
                dataticket.TicketsCerrados],
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
            renderChart();
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