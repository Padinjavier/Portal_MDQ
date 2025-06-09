<!-- C:\wamp64\www\helpmdq\vistas\modulos\dashboard.php -->
<script src="<?php echo BASE_URL; ?>/vistas/assets/dist/js/funcion_dashboard.js"></script>
<script>
    const BASE_URL = "<?php echo BASE_URL; ?>";
</script>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12 text-center">
                <h1>Resumen General</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <!-- Contadores Generales -->
        <div class="row justify-content-center row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6">
            <div class="col">
                <div class="card text-center p-2 shadow-sm">
                    <i class="fas fa-users fa-2x"></i>
                    <p>Trabajadores</p>
                    <p id="total_trabajadores">0</p>
                </div>
            </div>
            <div class="col">
                <div class="card text-center p-2 shadow-sm">
                    <i class="fas fa-user-cog fa-2x"></i>
                    <p>Técnicos</p>
                    <p id="total_soporte">0</p>
                </div>
            </div>
            <div class="col">
                <div class="card text-center p-2 shadow-sm">
                    <i class="fas fa-briefcase fa-2x"></i>
                    <p>Roles</p>
                    <p id="total_roles">0</p>
                </div>
            </div>
            <div class="col">
                <div class="card text-center p-2 shadow-sm">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                    <p>Problemas</p>
                    <p id="total_problemas">0</p>
                </div>
            </div>
            <div class="col">
                <div class="card text-center p-2 shadow-sm">
                    <i class="fas fa-ticket-alt fa-2x"></i>
                    <p>Tickets</p>
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
                        <p id="TicketAbiertos">0</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center p-2 bg-warning text-dark shadow-sm">
                        <p>En Atención</p>
                        <p id="TicketEnAtencion">0</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center p-2 bg-success text-white shadow-sm">
                        <p>Resueltos</p>
                        <p id="TicketResueltos">0</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center p-2 bg-info text-white shadow-sm">
                        <p>Reabiertos</p>
                        <p id="TicketReabiertos">0</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="card text-center p-2 bg-secondary text-white shadow-sm">
                        <p>Cerrados</p>
                        <p id="TicketCerrados">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos inicio-->
        <!-- ----------------- Gráfico de Tickets inicio ----------------- -->
        <div class="row">
            <!-- Gráfico de Donut -->
            <div class="col-md-6  mt-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Gráfico de Tickets</h3>
                    </div>
                    <div class="card-body text-center">
                        <canvas id="tickets"></canvas>
                    </div>
                </div>
            </div>

            <!-- Gráfico de Líneas -->
            <div class="col-md-6  mt-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tickets por Día (últimos 30 días)</h3>
                    </div>
                    <div class="card-body text-center">
                        <canvas id="ticketsPorDiaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-6 mt-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Tickets por Técnico</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="ticketsPorTecnicoChart" style="max-width: 100%; height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-4">
                <div class="card card-warning">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Tickets por Tipo de Problema</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="ticketsPorProblemaChart" style="max-width: 100%; height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>


       

        </div>
    </div>
</section>