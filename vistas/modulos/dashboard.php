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

        
        
        
    </div>
</section>

