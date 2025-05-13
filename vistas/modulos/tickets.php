<!-- C:\wamp64\www\Portal_MDQ\vistas\modulos\tickets.php -->
<script src="<?php echo BASE_URL; ?>/vistas/assets/dist/js/funcion_tickets.js"></script>
<script>
    const BASE_URL = "<?php echo BASE_URL; ?>";
    const Login_RolUsuario = <?php echo $_SESSION['Login_RolUsuario']; ?>;
    const Login_IdUsuario = <?php echo $_SESSION['Login_IdUsuario']; ?>;
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
                                    <th class="font-weight-bold">Nombre</th>
                                    <th class="font-weight-bold">Departamento</th>
                                    <th class="font-weight-bold">Problema</th>
                                    <th class="font-weight-bold">Subproblema</th>
                                    <th class="font-weight-bold">Fecha de creacion</th>
                                    <th class="font-weight-bold">Estado</th>
                                    <th class="font-weight-bold">Acciones</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 13px;">
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
                                    <option value="">Seleccione una Departamento</option>
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
                        <?php if ($_SESSION['Login_RolUsuario'] == 1) { ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="IdUsuarioSoporteTicket">Asignar Soporte</label>
                                    <select class="form-control form-control-sm" id="IdUsuarioSoporteTicket"
                                        name="IdUsuarioSoporteTicket">
                                        <option value="">Seleccione un Soporte</option>
                                        <!-- Las opciones se cargarán dinámicamente -->
                                    </select>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-12">
                        <input type="number" id="totalcomentarios" name="totalcomentarios" value="1" hidden>
                        <div class="form-group" id="sectionDescripcionTicket">
                            <label for="DescripcionTicket">Descripción</label>
                            <textarea id="DescripcionTicket" class="DescripcionTicket" name="DescripcionTicket"
                                class="form-control summernote"></textarea>
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




<!-- Inicio Modal para Ver Ticket -->
<!-- Inicio Modal para Ver Ticket -->
<div class="modal fade" id="ModalViewTicket" tabindex="-1" role="dialog" aria-labelledby="ModalViewLabelTicket" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="ModalViewLabelTicket">
                    <i class="fas fa-ticket-alt"></i> Ver Ticket
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body px-4">
                <div class="row">
                    <!-- Columna izquierda: información del ticket -->
                    <div class="col-md-6 mb-3">
                        <dl class="row">
                            <dt class="col-sm-5">Código</dt>
                            <dd class="col-sm-7 border rounded bg-light py-1 px-2" id="ViewCodigoTicket"></dd>

                            <dt class="col-sm-5">Nombre</dt>
                            <dd class="col-sm-7 border rounded bg-light py-1 px-2" id="ViewTrabajadorTicket"></dd>

                            <dt class="col-sm-5">Departamento</dt>
                            <dd class="col-sm-7 border rounded bg-light py-1 px-2" id="ViewDepartamentoTicket"></dd>

                            <dt class="col-sm-5">Problema</dt>
                            <dd class="col-sm-7 border rounded bg-light py-1 px-2" id="ViewProblemaTicket"></dd>

                            <dt class="col-sm-5">Subproblema</dt>
                            <dd class="col-sm-7 border rounded bg-light py-1 px-2" id="ViewSubproblemaTicket"></dd>

                            <dt class="col-sm-5">Creación</dt>
                            <dd class="col-sm-7 border rounded bg-light py-1 px-2" id="ViewDataCreateTicket"></dd>

                            <dt class="col-sm-5">Actualización</dt>
                            <dd class="col-sm-7 border rounded bg-light py-1 px-2" id="ViewDataUpdateTicket"></dd>

                            <dt class="col-sm-5">Estado</dt>
                            <dd class="col-sm-7 border rounded bg-light py-1 px-2" id="ViewStatusTicket"></dd>

                            <dt class="col-sm-5">Soporte</dt>
                            <dd class="col-sm-7 border rounded bg-light py-1 px-2" id="ViewSoporteTicket"></dd>
                        </dl>
                    </div>

                    <!-- Columna derecha: comentarios -->
                    <div class="col-md-6">
                        <!-- Formulario nuevo comentario -->
                        <div id="BloqueFormularioComentario" class="d-none mb-3">
                            <h6><strong>Nuevo Comentario:</strong></h6>
                            <input type="hidden" id="IdTicketComent" name="IdTicketComent">
                            <textarea id="ComentarioTexto" class="form-control DescripcionTicket summernote" rows="2" placeholder="Escriba un comentario..."></textarea>
                            <div class="text-end mt-2">
                                <button type="button" class="btn btn-success btn-sm" onclick="GuardarComentarioTicket()">
                                    <i class="fas fa-comment-dots"></i> Enviar comentario
                                </button>
                            </div>
                        </div>

                        <!-- Comentarios -->
                        <h6><strong>Comentarios</strong></h6>
                        <div id="ListaComentariosTicket" class="border p-2 rounded bg-light"
                             style="max-height: 290px; overflow-y: auto; min-height: 100px;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal para Ver Ticket -->

<!-- Fin Modal para Ver Ticket -->