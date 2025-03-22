<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12 text-center">
                <h1>Resumen General</h1>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch("<?php echo BASE_URL; ?>/controladores/DashboardControlador.php")
        .then(response => response.json())
        .then(data => {
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

            // Actualizar gráficos
            updateCharts(data);
        })
        .catch(error => console.error("Error cargando datos:", error));
});

function updateCharts(data) {
    // Gráfico de Tickets por Estado
    new Chart(document.getElementById("ticketsChart"), {
        type: "doughnut",
        data: {
            labels: ["Abiertos", "En Atención", "Resueltos", "Reabiertos", "Cerrados"],
            datasets: [{
                data: [data.abiertos, data.en_atencion, data.resueltos, data.reabiertos, data.cerrados],
                backgroundColor: ["#dc3545", "#ffc107", "#28a745", "#17a2b8", "#6c757d"]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "bottom"
                }
            }
        }
    });

    // Gráfico de Técnicos vs Tickets Atendidos
    new Chart(document.getElementById("tecnicosChart"), {
        type: "bar",
        data: {
            labels: ["Técnico 1", "Técnico 2", "Técnico 3"],
            datasets: [{
                label: "Tickets Atendidos",
                data: data.tickets_tecnicos || [20, 35, 45], // Default si no hay datos
                backgroundColor: ["#007bff", "#28a745", "#ffc107"]
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}
</script>

<section class="content">
    <div class="container-fluid">
        <!-- Contadores Generales -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-6">
            <div class="col">
                <div class="card text-center p-2 shadow-sm">
                    <i class="fas fa-users fa-2x"></i>
                    <h6>Total Trabajadores</h6>
                    <h4 id="total_trabajadores">0</h4>
                </div>
            </div>
            <div class="col">
                <div class="card text-center p-2 shadow-sm">
                    <i class="fas fa-user-cog fa-2x"></i>
                    <h6>Total Técnicos</h6>
                    <h4 id="total_soporte">0</h4>
                </div>
            </div>
            <div class="col">
                <div class="card text-center p-2 shadow-sm">
                    <i class="fas fa-briefcase fa-2x"></i>
                    <h6>Total Roles</h6>
                    <h4 id="total_roles">0</h4>
                </div>
            </div>
            <div class="col">
                <div class="card text-center p-2 shadow-sm">
                    <i class="fas fa-box-open fa-2x"></i>
                    <h6>Total Inventario</h6>
                    <h4 id="total_inventario">0</h4>
                </div>
            </div>
            <div class="col">
                <div class="card text-center p-2 shadow-sm">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                    <h6>Total Problemas</h6>
                    <h4 id="total_problemas">0</h4>
                </div>
            </div>
            <div class="col">
                <div class="card text-center p-2 shadow-sm">
                    <i class="fas fa-ticket-alt fa-2x"></i>
                    <h6>Total Tickets</h6>
                    <h4 id="total_tickets">0</h4>
                </div>
            </div>
        </div>

        <!-- Sección de Tickets -->
        <div class="card p-3 mt-3 bg-light">
            <h5 class="text-center">Gestión de Tickets</h5>
            <div class="row justify-content-center">
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center p-2 bg-danger text-white shadow-sm">
                        <h6>Abiertos</h6>
                        <h4 id="abiertos">0</h4>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center p-2 bg-warning text-dark shadow-sm">
                        <h6>En Atención</h6>
                        <h4 id="en_atencion">0</h4>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center p-2 bg-success text-white shadow-sm">
                        <h6>Resueltos</h6>
                        <h4 id="resueltos">0</h4>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center p-2 bg-info text-white shadow-sm">
                        <h6>Reabiertos</h6>
                        <h4 id="reabiertos">0</h4>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center p-2 bg-secondary text-white shadow-sm">
                        <h6>Cerrados</h6>
                        <h4 id="cerrados">0</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row mt-4">
            <div class="col-md-6">
                <canvas id="ticketsChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="tecnicosChart"></canvas>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
