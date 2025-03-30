<!-- C:\wamp64\www\helpmdq\vistas\modulos\tecnicos.php -->
<script src="<?php echo BASE_URL; ?>/vistas/assets/dist/js/funcion_roles.js"></script>
<script>
    const BASE_URL = "<?php echo BASE_URL; ?>";
</script>

<section class="content-header ml-3 mr-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm d-flex justify-content-between align-items-center flex-row p-3"
                style="border-radius: 30px;">
                <h1 class="mb-0">Roles
                    <small></small>
                    <button class="btn btn-success btn-sm" type="button" onclick="openModal();">
                        <i class="fas fa-plus-circle"></i> Nuevo
                    </button>
                </h1>
            </div>
        </div>
    </div>
    <!-- Tabla de Roles -->
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
                        <table class="table table-hover table-bordered w-100" id="tableRoles"
                            style="background-color: white;">
                            <thead class="bg-success">
                                <tr>
                                    <th class="font-weight-bold">ID</th>
                                    <th class="font-weight-bold">Nombre</th>
                                    <th class="font-weight-bold">Descripcion</th>
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
    <!-- Fin Tabla de Roles -->
</section>



<!-- Inicio Modal para Crear/Editar Rol -->
<div class="modal fade" id="modalFormRol" tabindex="-1" role="dialog" aria-labelledby="modalFormRolLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="modalFormRolLabel">Rol</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formRol">
                    <input type="hidden" id="idRol" name="idRol">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control form-control-sm" id="nombre" name="nombre"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descripcion">Descripcion</label>
                                <textarea type="text" class="form-control form-control-sm" id="descripcion"
                                    name="descripcion" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cerrar</button>
                <button class="btn btn-success btn-sm" type="button" onclick="guardarRol()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal para Crear/Editar Rol -->


<!-- Inicio Modal para Ver Rol -->
<div class="modal fade" id="modalViewRol" tabindex="-1" role="dialog" aria-labelledby="modalViewRolLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="modalViewRolLabel">Ver Rol</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nombre:</strong> <span id="viewNombre"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Descripcion:</strong> <span id="viewDescripcion"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal para Ver Rol -->





<!-- Inicio Modal para Gestionar Permisos de Rol -->
<div class="modal fade" id="modalViewPermisosRol" tabindex="-1" role="dialog"
    aria-labelledby="modalViewPermisosRolLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success">
            <h5 class="modal-title" id="modalFormPermisosRolLabel">Permisos Rol</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formPermisosRol" name="formPermisosRol">
                    <input type="hidden" id="IdRol" name="IdRol" required>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <link
                                    href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
                                    rel="stylesheet">
                                <script
                                    src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
                                <tr>
                                    <th>#</th>
                                    <th>Módulo</th>
                                    <th>Ver</th>
                                    <th>Crear</th>
                                    <th>Actualizar</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyPermisos">
                                <!-- Se llenará dinámicamente con JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cerrar</button>
                <button class="btn btn-success btn-sm" type="button" onclick="guardarPermisos()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal para Gestionar Permisos de Rol -->