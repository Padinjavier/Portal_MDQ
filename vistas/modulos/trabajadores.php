<!-- C:\wamp64\www\helpmdq\vistas\modulos\trabajadores.php -->
<script src="<?php echo BASE_URL; ?>/vistas/assets/dist/js/funcion_trabajadores.js"></script>
<script>
    const BASE_URL = "<?php echo BASE_URL; ?>";
</script>

<section class="content-header ml-3 mr-3">
    <div class="app-title">
        <div>
            <h1>Trabajadores <small></small>
                <button class="btn btn-primary btn-sm" type="button" onclick="openModal();">
                    <i class="fas fa-plus-circle"></i> Nuevo
                </button>
            </h1>
        </div>
    </div>

    <!-- Inicio Filtros -->
    <div class="row mb-3">
        <div class="col-md-12">
            <h5 class="text-muted">Filtros</h5>
        </div>
        <div class="col-md-2">
            <label for="filtroNombre" class="form-label">Nombre</label>
            <input type="text" id="filtroNombre" class="form-control form-control-sm" placeholder="Nombre">
        </div>
        <div class="col-md-2">
            <label for="filtroApellido" class="form-label">Apellido</label>
            <input type="text" id="filtroApellido" class="form-control form-control-sm" placeholder="Apellido">
        </div>
        <div class="col-md-2">
            <label for="filtroDNI" class="form-label">DNI</label>
            <input type="text" id="filtroDNI" class="form-control form-control-sm" placeholder="DNI">
        </div>
        <div class="col-md-2">
            <label for="filtroTelefono" class="form-label">Teléfono</label>
            <input type="text" id="filtroTelefono" class="form-control form-control-sm" placeholder="Teléfono">
        </div>
        <div class="col-md-2">
            <label for="filtroCorreo" class="form-label">Correo</label>
            <input type="text" id="filtroCorreo" class="form-control form-control-sm" placeholder="Correo">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary btn-sm btn-block" onclick="buscarTrabajadores()">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>
    </div>
    <!-- Fin Filtros -->

    <!-- Tabla de Trabajadores -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body p-3">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered w-100" id="tableTrabajadores">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>DNI</th>
                                    <th>Teléfono</th>
                                    <th>Correo</th>
                                    <th>Usuario</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Datos de ejemplo en texto plano -->
                                <tr>
                                    <td>1</td>
                                    <td>example</td>
                                    <td>example</td>
                                    <td>12345678</td>
                                    <td>12345678</td>
                                    <td>example@example.com</td>
                                    <td>example</td>
                                    <td>example</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle btn-sm" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="fas fa-cog"></i> Opciones
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">Ver</a>
                                                <a class="dropdown-item" href="#">Editar</a>
                                                <a class="dropdown-item" href="#">Eliminar</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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
<div class="modal fade" id="modalFormTrabajador" tabindex="-1" role="dialog" aria-labelledby="modalFormTrabajadorLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormTrabajadorLabel">Trabajador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formTrabajador">
                    <input type="hidden" id="idTrabajador" name="idTrabajador">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control form-control-sm" id="nombre" name="nombre"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellido">Apellido</label>
                                <input type="text" class="form-control form-control-sm" id="apellido" name="apellido"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dni">DNI</label>
                                <input type="text" class="form-control form-control-sm" id="dni" name="dni" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" class="form-control form-control-sm" id="telefono" name="telefono">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input type="email" class="form-control form-control-sm" id="correo" name="correo">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="usuario">Usuario</label>
                                <input type="text" class="form-control form-control-sm" id="usuario" name="usuario"
                                    required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="guardarTrabajador()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal para Crear/Editar Trabajador -->


<!-- Inicio Modal para Ver Trabajador -->
<div class="modal fade" id="modalViewTrabajador" tabindex="-1" role="dialog" aria-labelledby="modalViewTrabajadorLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalViewTrabajadorLabel">Ver Trabajador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> <span id="viewId"></span></p>
                        <p><strong>Nombre:</strong> <span id="viewNombre"></span></p>
                        <p><strong>Apellido:</strong> <span id="viewApellido"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>DNI:</strong> <span id="viewDni"></span></p>
                        <p><strong>Teléfono:</strong> <span id="viewTelefono"></span></p>
                        <p><strong>Correo:</strong> <span id="viewCorreo"></span></p>
                        <p><strong>Usuario:</strong> <span id="viewUsuario"></span></p>
                        <p><strong>Rol:</strong> <span id="viewRol"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal para Ver Trabajador -->