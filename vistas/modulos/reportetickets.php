<!-- C:\wamp64\www\Portal_MDQ\vistas\modulos\tickets.php -->
<script src="<?php echo BASE_URL; ?>/vistas/assets/dist/js/funcion_tickets.js"></script>
<script>
    const BASE_URL = "<?php echo BASE_URL; ?>";
    const Login_RolUsuario = <?php echo $_SESSION['Login_RolUsuario']; ?>;
    const Login_IdUsuario = <?php echo $_SESSION['Login_IdUsuario']; ?>;
</script>

<div class="container-fluid py-4">
    <div class="row g-4">
        <!-- Card por Código de Ticket -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">Por Código de Ticket</div>
                <div class="card-body">
                    <input type="text" class="form-control mb-2" placeholder="Ingrese código de ticket">
                    <div class="dropdown w-100">
                        <button class="btn btn-primary w-100 dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-file-export"></i> Reporte
                        </button>
                        <div class="dropdown-menu w-100">
                            <button class="btn dropdown-item text-danger bg-transparent"><i class="fas fa-file-pdf"></i>
                                PDF</button>
                            <button class="btn dropdown-item text-success bg-transparent"><i
                                    class="fas fa-file-excel"></i> Excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Card por Fecha - Rango de fechas -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">Por Fecha</div>
                <div class="card-body">
                    <input type="date" class="form-control mb-2" placeholder="Desde">
                    <input type="date" class="form-control mb-2" placeholder="Hasta">
                    <div class="dropdown w-100">
                        <button class="btn btn-primary w-100 dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-file-export"></i> Reporte
                        </button>
                        <div class="dropdown-menu w-100">
                            <button class="btn dropdown-item text-danger bg-transparent"><i class="fas fa-file-pdf"></i>
                                PDF</button>
                            <button class="btn dropdown-item text-success bg-transparent"><i
                                    class="fas fa-file-excel"></i> Excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card por Usuario Trabajador -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">Por Usuario Trabajador</div>
                <div class="card-body">
                    <select class="form-select mb-2">
                        <option value="">Seleccione un trabajador</option>
                        <option value="1">Trabajador 1</option>
                        <option value="2">Trabajador 2</option>
                    </select>
                    <div class="dropdown w-100">
                        <button class="btn btn-primary w-100 dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-file-export"></i> Reporte
                        </button>
                        <div class="dropdown-menu w-100">
                            <button class="btn dropdown-item text-danger bg-transparent"><i class="fas fa-file-pdf"></i>
                                PDF</button>
                            <button class="btn dropdown-item text-success bg-transparent"><i
                                    class="fas fa-file-excel"></i> Excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card por Soporte -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">Por Soporte</div>
                <div class="card-body">
                    <select class="form-select mb-2">
                        <option value="">Seleccione un soporte</option>
                        <option value="1">Soporte 1</option>
                        <option value="2">Soporte 2</option>
                    </select>
                    <div class="dropdown w-100">
                        <button class="btn btn-primary w-100 dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-file-export"></i> Reporte
                        </button>
                        <div class="dropdown-menu w-100">
                            <button class="btn dropdown-item text-danger bg-transparent"><i class="fas fa-file-pdf"></i>
                                PDF</button>
                            <button class="btn dropdown-item text-success bg-transparent"><i
                                    class="fas fa-file-excel"></i> Excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card por Rango de Fechas y Trabajador -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">Por Trabajador y Fecha</div>
                <div class="card-body">
                    <select class="form-select mb-2">
                        <option value="">Seleccione un trabajador</option>
                        <option value="1">Trabajador 1</option>
                        <option value="2">Trabajador 2</option>
                    </select>
                    <input type="date" class="form-control mb-2">
                    <input type="date" class="form-control mb-2">
                    <div class="dropdown w-100">
                        <button class="btn btn-primary w-100 dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-file-export"></i> Reporte
                        </button>
                        <div class="dropdown-menu w-100">
                            <button class="btn dropdown-item text-danger bg-transparent"><i class="fas fa-file-pdf"></i>
                                PDF</button>
                            <button class="btn dropdown-item text-success bg-transparent"><i
                                    class="fas fa-file-excel"></i> Excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card por Área -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">Por Departamento</div>
                <div class="card-body">
                    <select class="form-select mb-2" id="#DepartamentoTicket">
                        <option value="">Seleccione un área</option>
                    </select>
                    <div class="dropdown w-100">
                        <button class="btn btn-primary w-100 dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-file-export"></i> Reporte
                        </button>
                        <div class="dropdown-menu w-100">
                            <button class="btn dropdown-item text-danger bg-transparent"><i class="fas fa-file-pdf"></i>
                                PDF</button>
                            <button class="btn dropdown-item text-success bg-transparent"><i
                                    class="fas fa-file-excel"></i> Excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card por Problema y Subproblema -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">Por Problema y Subproblema</div>
                <div class="card-body">
                    <input type="text" class="form-control mb-2" placeholder="Problema">
                    <input type="text" class="form-control mb-2" placeholder="Subproblema">
                    <div class="dropdown w-100">
                        <button class="btn btn-primary w-100 dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-file-export"></i> Reporte
                        </button>
                        <div class="dropdown-menu w-100">
                            <button class="btn dropdown-item text-danger bg-transparent"><i class="fas fa-file-pdf"></i>
                                PDF</button>
                            <button class="btn dropdown-item text-success bg-transparent"><i
                                    class="fas fa-file-excel"></i> Excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card por Estado de Ticket -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light text-dark">Por Estado de Ticket</div>
                <div class="card-body">
                    <select class="form-select mb-2">
                        <option value="">Seleccione un estado</option>
                        <option value="0">Eliminado</option>
                        <option value="1">Abierto</option>
                        <option value="2">En Atención</option>
                        <option value="3">Resuelto</option>
                        <option value="4">Reabierto</option>
                        <option value="5">Cerrado</option>
                    </select>
                    <div class="dropdown w-100">
                        <button class="btn btn-primary w-100 dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-file-export"></i> Reporte
                        </button>
                        <div class="dropdown-menu w-100">
                            <button class="btn dropdown-item text-danger bg-transparent"><i class="fas fa-file-pdf"></i>
                                PDF</button>
                            <button class="btn dropdown-item text-success bg-transparent"><i
                                    class="fas fa-file-excel"></i> Excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>