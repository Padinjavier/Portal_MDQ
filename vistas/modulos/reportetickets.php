<!-- C:\wamp64\www\Portal_MDQ\vistas\modulos\tickets.php -->
<script src="<?php echo BASE_URL; ?>/vistas/assets/dist/js/funcion_reportetickets.js"></script>
<script>
    const BASE_URL = "<?php echo BASE_URL; ?>";
    const Login_RolUsuario = <?php echo $_SESSION['Login_RolUsuario']; ?>;
    const Login_IdUsuario = <?php echo $_SESSION['Login_IdUsuario']; ?>;
</script>

<div class="container-fluid py-4">
    <div class="row">
        <!-- Card por Código de Ticket -->
        <!-- Card por Código de Ticket -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">Por Código de Ticket</div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm" id="codigoTicket"
                                    placeholder="Ingrese código de ticket">
                            </div>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <div class="dropdown w-100">
                            <button class="btn btn-primary w-100 dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-file-export"></i> Reporte
                            </button>
                            <div class="dropdown-menu w-100">
                                <a href="#" class="dropdown-item text-danger" onclick="CodigoTicketPDF('PDF')">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>
                                <a href="#" class="dropdown-item text-success" onclick="CodigoTicketPDF('EXCEL')">
                                    <i class="fas fa-file-excel"></i> Excel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card por Fecha - Rango de fechas -->
        <div class="col-md-4 mb-2">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-secondary text-white">Por Fecha</div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <input type="datetime-local" class="form-control mb-3" placeholder="Desde" id="fechaDesde">
                        <input type="datetime-local" class="form-control mb-3" placeholder="Hasta" id="fechaHasta">
                    </div>
                    <div class="mt-auto">
                        <div class="dropdown w-100">
                            <button class="btn btn-primary w-100 dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-file-export"></i> Reporte
                            </button>
                            <div class="dropdown-menu w-100">
                                <!-- PDF Reporte -->
                                <a href="#" class="dropdown-item text-danger"
                                    onclick="generarReportePorFechaHora('PDF')">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>
                                <!-- Excel Reporte -->
                                <a href="#" class="dropdown-item text-success"
                                    onclick="generarReportePorFechaHora('EXCEL')">
                                    <i class="fas fa-file-excel"></i> Excel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card por Usuario Trabajador -->
        <div class="col-md-4 mb-2">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white">Por Usuario Trabajador</div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <select class="form-control form-control-sm" id="IdUsuarioCreadorTicketReporte"
                                    required>
                                    <option value="">Seleccione un trabajador</option>
                                    <option value="1">Trabajador 1</option>
                                    <option value="2">Trabajador 2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <div class="dropdown w-100">
                            <button class="btn btn-primary w-100 dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-file-export"></i> Reporte
                            </button>
                            <div class="dropdown-menu w-100">
                                <button class="btn dropdown-item text-danger bg-transparent"><i
                                        class="fas fa-file-pdf"></i>
                                    PDF</button>
                                <button class="btn dropdown-item text-success bg-transparent"><i
                                        class="fas fa-file-excel"></i> Excel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card por Soporte -->
        <div class="col-md-4 mb-2">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-white">Por Soporte</div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <select class="form-control form-control-sm" id="IdUsuarioSoporteTicketReporte"
                                    required>
                                    <option value="">Seleccione un soporte</option>
                                    <option value="1">Soporte 1</option>
                                    <option value="2">Soporte 2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <div class="dropdown w-100">
                            <button class="btn btn-primary w-100 dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-file-export"></i> Reporte
                            </button>
                            <div class="dropdown-menu w-100">
                                <button class="btn dropdown-item text-danger bg-transparent"><i
                                        class="fas fa-file-pdf"></i>
                                    PDF</button>
                                <button class="btn dropdown-item text-success bg-transparent"><i
                                        class="fas fa-file-excel"></i> Excel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card por Rango de Fechas y Trabajador -->
        <div class="col-md-4 mb-2">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-warning text-white">Por Estado de Ticket</div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <select class="form-control form-control-sm" required>
                                    <option value="">Seleccione un estado</option>
                                    <option value="1">Abierto</option>
                                    <option value="2">En Atención</option>
                                    <option value="3">Resuelto</option>
                                    <option value="4">Reabierto</option>
                                    <option value="5">Cerrado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <div class="dropdown w-100">
                            <button class="btn btn-primary w-100 dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-file-export"></i> Reporte
                            </button>
                            <div class="dropdown-menu w-100">
                                <button class="btn dropdown-item text-danger bg-transparent"><i
                                        class="fas fa-file-pdf"></i>
                                    PDF</button>
                                <button class="btn dropdown-item text-success bg-transparent"><i
                                        class="fas fa-file-excel"></i> Excel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card por Área -->
        <div class="col-md-4 mb-2">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white">Por Departamento</div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <select class="form-control form-control-sm" id="IdDepartamentosTicketReporte" required>
                                    <option value="">Seleccione un trabajador</option>
                                    <option value="1">Trabajador 1</option>
                                    <option value="2">Trabajador 2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <div class="dropdown w-100">
                            <button class="btn btn-primary w-100 dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-file-export"></i> Reporte
                            </button>
                            <div class="dropdown-menu w-100">
                                <button class="btn dropdown-item text-danger bg-transparent"><i
                                        class="fas fa-file-pdf"></i>
                                    PDF</button>
                                <button class="btn dropdown-item text-success bg-transparent"><i
                                        class="fas fa-file-excel"></i> Excel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card por Problema y Subproblema -->
        <div class="col-md-4 mb-2">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-danger text-white">Por Problema y Subproblema</div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <select id="IdProblemaTicketReporte" class="form-control mb-3" onchange="CargarSubproblemas()">
                            <option value="">Seleccione un problema</option>
                        </select>
                        <select id="IdSubproblemaTicketReporte" class="form-control mb-3">
                            <option value="">Seleccione un subproblema</option>
                        </select>
                    </div>
                    <div class="mt-auto">
                        <div class="dropdown w-100">
                            <button class="btn btn-primary w-100 dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-file-export"></i> Reporte
                            </button>
                            <div class="dropdown-menu w-100">
                                <button class="btn dropdown-item text-danger bg-transparent"><i
                                        class="fas fa-file-pdf"></i> PDF</button>
                                <button class="btn dropdown-item text-success bg-transparent"><i
                                        class="fas fa-file-excel"></i> Excel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>