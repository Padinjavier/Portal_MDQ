<!-- C:\wamp64\www\helpmdq\vistas\modulos\tecnicos.php -->
<script src="<?php echo BASE_URL; ?>/vistas/assets/dist/js/funcion_subproblemas.js"></script>
<script>
    const BASE_URL = "<?php echo BASE_URL; ?>";
</script>

<section class="content-header ml-3 mr-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm d-flex justify-content-between align-items-center flex-row p-3"
                style="border-radius: 30px;">
                <h1 class="mb-0">Subproblemas
                    <small></small>
                    <button class="btn btn-success btn-sm" type="button" onclick="openModal();">
                        <i class="fas fa-plus-circle"></i> Nuevo
                    </button>
                </h1>
            </div>
        </div>
    </div>
    <!-- Tabla de Subproblemas -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm" style="border-radius: 30px;">
                <div class="card-body p-4">
                    <div title="Botones para exportar">
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
                    <div class="dt-buttons btn-group flex-wrap">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered w-100" id="tableSubproblemas"
                            style="background-color: white;">
                            <thead class="bg-success">
                                <tr>
                                    <th class="font-weight-bold">ID</th>
                                    <th class="font-weight-bold">Nombre Problema</th>
                                    <th class="font-weight-bold">Nombre SubProblema</th>
                                    <th class="font-weight-bold">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <!-- se agregan los datos automaticamente con js   -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Tabla de Subproblemas -->
</section>



<!-- Inicio Modal para Crear/Editar subproblema -->
<div class="modal fade" id="modalFormSubproblema" tabindex="-1" role="dialog" aria-labelledby="modalFormSubproblemaLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="modalFormSubproblemaLabel">Subproblema</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formSubproblema">
                    <input type="hidden" id="idSubproblema" name="idSubproblema">
                    <div class="row">
                    <div class="col-md-12">
                            <div class="form-group">
                                <label for="problema">Rol</label>
                                <select class="form-control form-control-sm" id="problema" name="problema">
                                    <option value="">Seleccione un rol</option>
                                    <!-- Las opciones se cargarán dinámicamente -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control form-control-sm" id="nombre" name="nombre"
                                    required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cerrar</button>
                <button class="btn btn-success btn-sm" type="button" onclick="guardarSubproblema()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal para Crear/Editar subproblema -->


<!-- Inicio Modal para Ver subproblema -->
<div class="modal fade" id="modalViewSubproblema" tabindex="-1" role="dialog" aria-labelledby="modalViewProblemaLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="modalViewProblemaLabel">Ver Problema</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <p><strong>Nombre Problema:</strong> <span id="viewNombreProblema"></span></p>
                    </div>
                    <div class="col-md-12">
                        <p><strong>Nombre Sub Problema:</strong> <span id="viewNombreSubproblema"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal para Ver subproblema -->




