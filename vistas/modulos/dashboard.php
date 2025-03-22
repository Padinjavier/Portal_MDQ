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
    document.addEventListener("DOMContentLoaded", function () {
        // Hacer la solicitud fetch cada vez que se carga la página
        fetch("<?php echo BASE_URL; ?>/controladores/DashboardControlador.php")
            .then(response => response.json())
            .then(data => {
                updateDashboard(data); // Actualizar el dashboard con los datos obtenidos
            })
            .catch(error => console.error("Error cargando datos:", error));

        function updateDashboard(data) {
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

            // Actualizar gráficos
            updateCharts(data);
        }
    });
</script>

<section class="content">
    <div class="container-fluid">
        <!-- Contadores Generales -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-6">
            <div class="col">
                <div class="card text-center p-2 shadow-sm">
                    <i class="fas fa-users fa-2x"></i>
                    <p>Total Trabajadores</p>
                    <p id="total_trabajadores">0</p>
                </div>
            </div>
            <div class="col">
                <div class="card text-center p-2 shadow-sm">
                    <i class="fas fa-user-cog fa-2x"></i>
                    <p>Total Técnicos</p>
                    <p id="total_soporte">0</p>
                </div>
            </div>
            <div class="col">
                <div class="card text-center p-2 shadow-sm">
                    <i class="fas fa-briefcase fa-2x"></i>
                    <p>Total Roles</p>
                    <p id="total_roles">0</p>
                </div>
            </div>
            <div class="col">
                <div class="card text-center p-2 shadow-sm">
                    <i class="fas fa-box-open fa-2x"></i>
                    <p>Total Inventario</p>
                    <p id="total_inventario">0</p>
                </div>
            </div>
            <div class="col">
                <div class="card text-center p-2 shadow-sm">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                    <p>Total Problemas</p>
                    <p id="total_problemas">0</p>
                </div>
            </div>
            <div class="col">
                <div class="card text-center p-2 shadow-sm">
                    <i class="fas fa-ticket-alt fa-2x"></i>
                    <p>Total Tickets</p>
                    <p id="total_tickets">0</p>
                </div>
            </div>
        </div>

        <!-- Sección de Tickets -->
        <div class="card p-3 mt-3 bg-light">
            <h5 class="text-center">Gestión de Tickets</h5>
            <div class="row justify-content-center">
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center p-2 bg-danger text-white shadow-sm">
                        <p>Abiertos</p>
                        <p id="abiertos">0</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center p-2 bg-warning text-dark shadow-sm">
                        <p>En Atención</p>
                        <p id="en_atencion">0</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center p-2 bg-success text-white shadow-sm">
                        <p>Resueltos</p>
                        <p id="resueltos">0</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center p-2 bg-info text-white shadow-sm">
                        <p>Reabiertos</p>
                        <p id="reabiertos">0</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center p-2 bg-secondary text-white shadow-sm">
                        <p>Cerrados</p>
                        <p id="cerrados">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos inicio-->
        <!-- ----------------- Gráfico de Tickets inicio ----------------- -->
        <div class="col-md-6">
            <div class="card card-navy">
                <div class="card-header">
                    <h3 class="card-title">Gráfico de Tickets</h3>
                </div>
                <div class="mt-1 mb-1 d-flex align-items-center justify-content-around">
                    <button id="downloadPNG" class="btn btn-primary btn-sm">
                        <i class="bi bi-image"></i> PNG
                    </button>
                    <button id="downloadJPG" class="btn btn-success btn-sm">
                        <i class="bi bi-file-earmark-image"></i> JPG
                    </button>
                    <button id="downloadPDF" class="btn btn-danger btn-sm">
                        <i class="bi bi-file-earmark-pdf"></i> PDF
                    </button>
                </div>
                <div class="card-body text-center">
                    <canvas id="tickets" style="max-width: 100%; height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let myChart = null; // Variable para almacenar la instancia del gráfico

                function renderChart() {
                    if (myChart) {
                        myChart.destroy(); // Elimina el gráfico si ya existe
                    }

                    const ctx = document.getElementById('tickets').getContext('2d');
                    const donutData = {
                        labels: ['Abiertos: '+dataticket.abiertos, 
                        'En Atención: '+dataticket.en_atencion, 
                        'Resuelto: '+dataticket.resueltos, 
                        'Reabierto: '+dataticket.reabiertos, 
                        'Cerrados: '+dataticket.cerrados],
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
        </script>

        <!-- ----------------- Gráfico de Tickets fin ----------------- -->


        <!-- Gráficos fin-->




    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>