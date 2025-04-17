<!-- C:\wamp64\www\Portal_MDQ\vistas\modulos\tickets.php -->
<script src="<?php echo BASE_URL; ?>/vistas/assets/dist/js/funcion_tickets.js"></script>
<script>
    const BASE_URL = "<?php echo BASE_URL; ?>";
</script>

<section class="content-header ml-3 mr-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm d-flex justify-content-between align-items-center flex-row p-3"
                style="border-radius: 30px;">
                <h1 class="mb-0">Tickets
                    <small></small>
                    <button class="btn btn-success btn-sm" type="button" onclick="openModal();">
                        <i class="fas fa-plus-circle"></i> Nuevo
                    </button>
                </h1>
            </div>
        </div>
    </div>
    <!-- Tabla de Tickets -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm" style="border-radius: 30px;">
                <div class="card-body p-4">
                    <div title="Botones para exportar" class="mb-3">
                        <!-- Botón de Excel -->
                        <button class="btn btn-secondary buttons-excel buttons-html5 btn-success" tabindex="0"
                            type="button" title="Exportar a Excel">
                            <span><i class="bi bi-file-earmark-excel"></i> Excel</span>
                        </button>
                        <!-- Botón de PDF -->
                        <button class="btn btn-secondary buttons-pdf buttons-html5 btn-danger" tabindex="0"
                            type="button" title="Exportar a PDF">
                            <span><i class="bi bi-filetype-pdf"></i> Pdf</span>
                        </button>
                        <!-- Botón de CSV (deshabilitado, visible, bloqueado en gris) -->
                        <button class="btn bg-secondary buttons-csv buttons-html5  disabled" tabindex="0" type="button"
                            title="Exportar a CSV" disabled>
                            <span><i class="fas fa-file-csv"></i> CSV</span>
                        </button>
                        <!-- Botón de JSON (deshabilitado, visible, bloqueado en gris) -->
                        <button class="btn bg-secondary buttons-csv buttons-html5  disabled" tabindex="0" type="button"
                            title="Exportar a JSON" disabled>
                            <span><i class="fas fa-file-code"></i> JSON</span>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered w-100" id="TablaTickets"
                            style="background-color: white;">
                            <thead class="bg-success">
                                <tr>
                                    <th class="font-weight-bold">Codigo</th>
                                    <th class="font-weight-bold">Ticket</th>
                                    <th class="font-weight-bold">Departamento</th>
                                    <th class="font-weight-bold">Problema</th>
                                    <th class="font-weight-bold">Subproblema</th>
                                    <th class="font-weight-bold">Fecha de creacion</th>
                                    <th class="font-weight-bold">Estado</th>
                                    <th class="font-weight-bold">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- se agregan los datos automaticamente con js   -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Tabla de Tickets -->
</section>



<!-- Inicio Modal para Crear/Editar Ticket -->
<div class="modal fade" id="ModalFormTicket" tabindex="-1" role="dialog" aria-labelledby="ModalFormLabelTicket"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header bg-success">
                <h5 class="modal-title" id="ModalFormLabelTicket">Ticket</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="FormularioTicket">
                    <input type="hidden" id="IdTicket" name="IdTicket">
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                                <label for="IdUsuarioCreadorTicket">Nombre</label>
                                <select class="form-control form-control-sm" id="IdUsuarioCreadorTicket"
                                    name="IdUsuarioCreadorTicket" required>
                                    <option value="">Seleccione una nombre</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="DepartamentoTicket">Departamento</label>
                                <select class="form-control form-control-sm" id="DepartamentoTicket"
                                    name="DepartamentoTicket" required>
                                    <option value="">Seleccione una opción</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="IdProblemaTicket">Problema</label>
                                <select class="form-control form-control-sm" id="IdProblemaTicket"
                                    name="IdProblemaTicket">
                                    <option value="">Seleccione un Problema</option>
                                    <!-- Las opciones se cargarán dinámicamente -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="IdSubproblemaTicket">Subproblema</label>
                                <select class="form-control form-control-sm" id="IdSubproblemaTicket"
                                    name="IdSubproblemaTicket">
                                    <option value="">Seleccione un Subproblema</option>
                                    <!-- Las opciones se cargarán dinámicamente -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="editor">Descripción</label>
                            <textarea id="editor" name="descripcion" class="form-control summernote" ></textarea>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cerrar</button>
                <button class="btn btn-success btn-sm" type="button" onclick="GuardarTicket()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal para Crear/Editar Ticket -->



<!-- Inicio Modal para Ver Ticket modalVistaTicket-->
<div class="modal fade" id="ModalViewTicket" tabindex="-1" role="dialog" aria-labelledby="ModalViewLabelTicket"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="ModalViewLabelTicket">Ver Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nombres:</strong> <span id="ViewNombresTicket"></span></p>
                        <p><strong>DNI:</strong> <span id="ViewDNITicket"></span></p>
                        <p><strong>Correo:</strong> <span id="ViewCorreoTicket"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Apellidos:</strong> <span id="ViewApellidosTicket"></span></p>
                        <p><strong>Teléfono:</strong> <span id="ViewTelefonoTicket"></span></p>
                        <p><strong>Usuario:</strong> <span id="ViewUsernameTicket"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal para Ver Ticket -->