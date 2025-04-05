<!-- C:\wamp64\www\helpmdq\vistas\modulos\trabajadores.php -->
<script src="<?php echo BASE_URL; ?>/vistas/assets/dist/js/funcion_trabajadores.js"></script>
<script>
    const BASE_URL = "<?php echo BASE_URL; ?>";
</script>

<section class="content-header ml-3 mr-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm d-flex justify-content-between align-items-center flex-row p-3"
                style="border-radius: 30px;">
                <h1 class="mb-0">Trabajadores
                    <small></small>
                    <button class="btn btn-success btn-sm" type="button" onclick="openModal();">
                        <i class="fas fa-plus-circle"></i> Nuevo
                    </button>
                </h1>
                <div class="position-relative">
                    <button class="btn btn-primary btn-sm" type="button" id="BotonConfiguracion"
                        onclick="AbrirConfiguracion(); CargarRoles()">
                        <i class="fas fa-cog"></i> Configuración
                    </button>
                    <div class="config-menu shadow-sm bg-white pb-2 mt-2 border position-absolute "
                        id="MenuConfiguracion" style="display: none; right: 0; top: 100%; z-index: 1000;">
                        <h6 class="dropdown-header bg-success fw-bold"
                            title="Estos son los roles que se verán en esta tabla, algunos ya están en otra tabla quitelos de esas para agregarlos a esta.">
                            Configuracion de tabla</h6>
                        <div id="ListaRoles" class="px-3">
                            <!-- Aquí se cargarán los roles dinámicamente -->
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="d-flex">
                            <button class="btn btn-success btn-sm mx-auto" type="button"
                                onclick="GuardarConfiguracion()">
                                <i class="fas fa-save"></i> Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tabla de Trabajadores -->
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
                        <table class="table table-hover table-bordered w-100" id="TablaTrabajadores"
                            style="background-color: white;">
                            <thead class="bg-success">
                                <tr>
                                    <th class="font-weight-bold">ID</th>
                                    <th class="font-weight-bold">Nombre</th>
                                    <th class="font-weight-bold">Apellido</th>
                                    <th class="font-weight-bold">DNI</th>
                                    <th class="font-weight-bold">Teléfono</th>
                                    <th class="font-weight-bold">Correo</th>
                                    <th class="font-weight-bold">Usuario</th>
                                    <th class="font-weight-bold">Rol</th>
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
    <!-- Fin Tabla de Trabajadores -->
</section>



<!-- Inicio Modal para Crear/Editar Trabajador -->
<div class="modal fade" id="ModalFormTrabajador" tabindex="-1" role="dialog" aria-labelledby="ModalFormLabelTrabajador"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="ModalFormLabelTrabajador">Trabajador</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="FormularioTrabajador">
                    <input type="hidden" id="IdTrabajador" name="IdTrabajador">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="NombresTrabajador">Nombre</label>
                                <input type="text" class="form-control form-control-sm" id="NombresTrabajador"
                                    name="NombresTrabajador" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ApellidosTrabajador">Apellido</label>
                                <input type="text" class="form-control form-control-sm" id="ApellidosTrabajador"
                                    name="ApellidosTrabajador" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="DNITrabajador">DNI</label>
                                <input type="text" class="form-control form-control-sm" id="DNITrabajador"
                                    name="DNITrabajador" minlength="8" maxlength="8" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="TelefonoTrabajador">Teléfono</label>
                                <input type="text" class="form-control form-control-sm" id="TelefonoTrabajador"
                                    name="TelefonoTrabajador" minlength="9" maxlength="9" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="CorreoTrabajador">Correo</label>
                                <input type="email" class="form-control form-control-sm" id="CorreoTrabajador"
                                    name="CorreoTrabajador">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="UsernameTrabajador">Usuario</label>
                                <input type="text" class="form-control form-control-sm" id="UsernameTrabajador"
                                    name="UsernameTrabajador" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="PasswordTrabajador">Contraseña</label>
                                <input type="text" class="form-control form-control-sm" id="PasswordTrabajador"
                                    name="PasswordTrabajador">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="RolTrabajador">Rol</label>
                                <select class="form-control form-control-sm" id="RolTrabajador" name="RolTrabajador">
                                    <option value="">Seleccione un rol</option>
                                    <!-- Las opciones se cargarán dinámicamente -->
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cerrar</button>
                <button class="btn btn-success btn-sm" type="button" onclick="GuardarTrabajador()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal para Crear/Editar Trabajador -->



<!-- Inicio Modal para Ver Trabajador modalVistaTrabajador-->
<div class="modal fade" id="ModalViewTrabajador" tabindex="-1" role="dialog" aria-labelledby="ModalViewLabelTrabajador"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="ModalViewLabelTrabajador">Ver Trabajador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nombres:</strong> <span id="ViewNombresTrabajador"></span></p>
                        <p><strong>DNI:</strong> <span id="ViewDNITrabajador"></span></p>
                        <p><strong>Correo:</strong> <span id="ViewCorreoTrabajador"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Apellidos:</strong> <span id="ViewApellidosTrabajador"></span></p>
                        <p><strong>Teléfono:</strong> <span id="ViewTelefonoTrabajador"></span></p>
                        <p><strong>Usuario:</strong> <span id="ViewUsernameTrabajador"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal para Ver Trabajador -->