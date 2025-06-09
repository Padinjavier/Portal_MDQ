document.addEventListener("DOMContentLoaded", function () {
    cargarResumenGeneral();
    cargarEstadoTickets();
    cargarTicketsPorDia();
    cargarTicketsPorTecnico();
    cargarTicketsPorProblema();


});

// 📊 Resumen General
function cargarResumenGeneral() {
    fetch(`${BASE_URL}/controladores/dashboard/DashboardControlador.php?action=ResumenGeneral`)
        .then(res => res.json())
        .then(data => {
            document.getElementById("total_trabajadores").textContent = data.total_trabajadores;
            document.getElementById("total_soporte").textContent = data.total_soporte;
            document.getElementById("total_roles").textContent = data.total_roles;
            document.getElementById("total_problemas").textContent = data.total_problemas;
            document.getElementById("total_tickets").textContent = data.total_tickets;
        })
        .catch(error => console.error("Error cargando resumen general:", error));
}



// 📌 Variables globales para guardar datos
let dataticket = {};


// 📊 Estado de Tickets (Dona)
function cargarEstadoTickets() {
    fetch(`${BASE_URL}/controladores/dashboard/DashboardControlador.php?action=EstadoTickets`)
        .then(res => res.json())
        .then(data => {
            dataticket = data;
            document.getElementById("TicketAbiertos").textContent = data.TicketsAbiertos;
            document.getElementById("TicketEnAtencion").textContent = data.TicketsEnAtencion;
            document.getElementById("TicketResueltos").textContent = data.TicketsResueltos;
            document.getElementById("TicketReabiertos").textContent = data.TicketsReabiertos;
            document.getElementById("TicketCerrados").textContent = data.TicketsCerrados;

    
    renderDonutChart();
    renderApexEstadoTickets();

        })
        .catch(error => console.error("Error cargando estado de tickets:", error));
}

function renderDonutChart() {
    const ctx = document.getElementById('tickets').getContext('2d');
    const donutData = {
        labels: [
            'Abiertos: ' + dataticket.TicketsAbiertos,
            'En Atención: ' + dataticket.TicketsEnAtencion,
            'Resuelto: ' + dataticket.TicketsResueltos,
            'Reabierto: ' + dataticket.TicketsReabiertos,
            'Cerrados: ' + dataticket.TicketsCerrados
        ],
        datasets: [{
            data: [
                dataticket.TicketsAbiertos,
                dataticket.TicketsEnAtencion,
                dataticket.TicketsResueltos,
                dataticket.TicketsReabiertos,
                dataticket.TicketsCerrados
            ],
            backgroundColor: ['#dc3545', '#ffc107', '#28a745', '#17a2b8', '#6c757d'],
            borderColor: '#fff',
            borderWidth: 2,
            hoverOffset: 10
        }]
    };
    const donutOptions = {
        maintainAspectRatio: false,
        responsive: true,
        plugins: {
            legend: { display: true, position: 'bottom' },
            tooltip: {
                callbacks: {
                    label: function (tooltipItem) {
                        let value = donutData.datasets[0].data[tooltipItem.dataIndex];
                        return `${donutData.labels[tooltipItem.dataIndex]}: ${value} Tickets`;
                    }
                }
            }
        }
    };
    new Chart(ctx, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
    });
}




let dataticketsPorDia = [];
// 📈 Tickets por Día (Línea)
function cargarTicketsPorDia() {
    fetch(`${BASE_URL}/controladores/dashboard/DashboardControlador.php?action=TicketsPorDia`)
        .then(res => res.json())
        .then(data => {
            dataticketsPorDia = data.reverse(); // Reversa para orden ascendente por fecha
            renderLineChart();
        })
        .catch(error => console.error("Error cargando gráfico de tickets por día:", error));
}

function renderLineChart() {
    const fechas = dataticketsPorDia.map(item => item.fecha);
    const cantidades = dataticketsPorDia.map(item => item.total);

    const ctx = document.getElementById('ticketsPorDiaChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: fechas,
            datasets: [{
                label: 'Tickets por Día',
                data: cantidades,
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                fill: true,
                tension: 0.3,
                pointRadius: 4,
                pointBackgroundColor: '#007bff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                tooltip: { mode: 'index', intersect: false }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: true
            },
            scales: {
                x: { display: true, title: { display: true, text: 'Fecha' } },
                y: { display: true, title: { display: true, text: 'Cantidad de Tickets' }, beginAtZero: true }
            }
        }
    });
}


function cargarTicketsPorTecnico() {
    fetch(`${BASE_URL}/controladores/dashboard/DashboardControlador.php?action=TicketsPorTecnico`)
        .then(res => res.json())
        .then(data => {
            dataticketsPorTecnico = data;
            renderBarChart();
        })
        .catch(error => console.error("Error cargando gráfico de tickets por técnico:", error));
}
function renderBarChart() {
    const tecnicos = dataticketsPorTecnico.map(item => item.tecnico);
    const cantidades = dataticketsPorTecnico.map(item => item.total);

    const ctx = document.getElementById('ticketsPorTecnicoChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: tecnicos,
            datasets: [{
                label: 'Tickets Asignados',
                data: cantidades,
                backgroundColor: '#17a2b8'
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                x: { beginAtZero: true, title: { display: true, text: 'Cantidad de Tickets' } },
                y: { title: { display: true, text: 'Técnico' } }
            }
        }
    });
}


function cargarTicketsPorProblema() {
    fetch(`${BASE_URL}/controladores/dashboard/DashboardControlador.php?action=TicketsPorProblema`)
        .then(res => res.json())
        .then(data => {
            dataticketsPorProblema = data;
            renderProblemaChart();
        })
        .catch(error => console.error("Error cargando gráfico de tickets por problema:", error));
}

function renderProblemaChart() {
    const problemas = dataticketsPorProblema.map(item => item.problema);
    const cantidades = dataticketsPorProblema.map(item => item.total);

    const ctx = document.getElementById('ticketsPorProblemaChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: problemas,
            datasets: [{
                label: 'Tickets por Problema',
                data: cantidades,
                backgroundColor: '#ffc107'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                x: { title: { display: true, text: 'Problema' } },
                y: { beginAtZero: true, title: { display: true, text: 'Cantidad de Tickets' } }
            }
        }
    });
}

function renderApexEstadoTickets() {
    const options = {
        chart: {
            type: 'bar',
            height: 350,
            toolbar: { show: true }
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            }
        },
        dataLabels: {
            enabled: true
        },
        colors: ['#dc3545', '#ffc107', '#28a745', '#17a2b8', '#6c757d'],
        series: [{
            name: 'Tickets',
            data: [
                dataticket.TicketsAbiertos,
                dataticket.TicketsEnAtencion,
                dataticket.TicketsResueltos,
                dataticket.TicketsReabiertos,
                dataticket.TicketsCerrados
            ]
        }],
        xaxis: {
            categories: ['Abiertos', 'En Atención', 'Resueltos', 'Reabiertos', 'Cerrados'],
            title: {
                text: 'Estado'
            }
        },
        yaxis: {
            title: {
                text: 'Cantidad de Tickets'
            }
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return `${val} tickets`;
                }
            }
        }
    };

    const chart = new ApexCharts(document.querySelector("#apexEstadoTickets"), options);
    chart.render();
}
