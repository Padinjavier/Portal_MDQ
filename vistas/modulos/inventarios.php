<!-- C:\wamp64\www\Portal_MDQ\vistas\modulos\Inventarios.php -->
<script src="<?php echo BASE_URL; ?>/vistas/assets/dist/js/funcion_inventarios.js"></script>
<script>
    const BASE_URL = "<?php echo BASE_URL; ?>";
</script>

<section class="content-header ml-3 mr-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm d-flex justify-content-between align-items-center flex-row p-3"
                style="border-radius: 30px;">
                <h1 class="mb-0">Inventarios
                    <small></small>
                    <button class="btn btn-success btn-sm" type="button" onclick="openModal();">
                        <i class="fas fa-plus-circle"></i> Nuevo
                    </button>
                </h1>
            </div>
        </div>
    </div>
    <!-- Tabla de Inventarios -->
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
                        <table class="table table-hover table-bordered w-100" id="TablaInventarios"
                            style="background-color: white;">
                            <thead class="bg-success">
                                <tr>
                                    <th class="font-weight-bold">Id</th>
                                    <th class="font-weight-bold">Nombre</th>
                                    <th class="font-weight-bold">Codigo</th>
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
    <!-- Fin Tabla de Inventarios -->
</section>



<!-- Inicio Modal para Crear/Editar Inventario -->
<div class="modal fade" id="ModalFormInventario" tabindex="-1" role="dialog" aria-labelledby="ModalFormLabelInventario"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header bg-success">
                <h5 class="modal-title" id="ModalFormLabelInventario">Inventario</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="FormularioInventario">
                    <input type="hidden" id="IdInventario" name="IdInventario">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="NombreInventario">Nombre</label>
                                <input type="text" class="form-control form-control-sm" id="NombreInventario"
                                    name="NombreInventario" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="CodigoInventario">Codigo</label>
                                <input type="text" class="form-control form-control-sm" id="CodigoInventario"
                                    name="CodigoInventario" required>
                            </div>
                        </div>
                    </div>
                  
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="DescripcionInventario">Descripción</label>
                            <textarea id="DescripcionInventario" name="DescripcionInventario"
                                class="form-control summernote"></textarea>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cerrar</button>
                <button class="btn btn-success btn-sm" type="button" onclick="GuardarInventario()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal para Crear/Editar Inventario -->




<!-- Inicio Modal para Ver Inventario -->
<div class="modal fade" id="ModalViewInventario" tabindex="-1" role="dialog" aria-labelledby="ModalViewLabelInventario"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="ModalViewLabelInventario"><i class="fas fa-Inventario-alt"></i> Ver Inventario</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-4">
                <dl class="row mb-0 ">
                    <dt class="col-sm-2">Código</dt>
                    <dd class="col-sm-3 border rounded bg-light" id="ViewCodigoInventario"></dd>
                    <dt class="col-sm-2">Nombre</dt>
                    <dd class="col-sm-4 border rounded bg-light" id="ViewTrabajadorInventario"></dd>
                    <dt class="col-sm-2">Departamento</dt>
                    <dd class="col-sm-9 border rounded bg-light" id="ViewDepartamentoInventario"></dd>
                    <dt class="col-sm-2">Problema</dt>
                    <dd class="col-sm-3 border rounded bg-light" id="ViewProblemaInventario"></dd>
                    <dt class="col-sm-2">Subproblema</dt>
                    <dd class="col-sm-4 border rounded bg-light" id="ViewSubproblemaInventario"></dd>
                    <dt class="col-sm-2">Creación</dt>
                    <dd class="col-sm-3 border rounded bg-light" id="ViewDataCreateInventario"></dd>
                    <dt class="col-sm-2">Actualización</dt>
                    <dd class="col-sm-4 border rounded bg-light" id="ViewDataUpdateInventario"></dd>
                    <dt class="col-sm-2">Estado</dt>
                    <dd class="col-sm-3 border rounded bg-light" id="ViewStatusInventario"></dd>
                    <dt class="col-sm-2">Soporte</dt>
                    <dd class="col-sm-4 border rounded bg-light" id="ViewSoporteInventario"></dd>
                </dl>
                <hr>
                <h6><strong>Comentarios</strong></h6>
                <div class="border p-2 rounded bg-light" id="ViewDescripcionInventario" style="min-height: 60px;"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal"><i class="fas fa-times"></i>
                    Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal para Ver Inventario -->