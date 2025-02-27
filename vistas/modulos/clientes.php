<!-- C:\wamp64\www\internet\vistas\modulos\clientes.php -->
<section class="content-header mb-4">
    <div class="app-title">
        <div>
            <h1>Clientes <small></small>
                <button class="btn btn-primary" type="button" onclick="openModal();">
                    <i class="fas fa-plus-circle"></i> Agregar
                </button>
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="app-menu__icon bi bi-house-door-fill"></i></li>
            <li class="breadcrumb-item"><a href="#" class="text-info">Clientes</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered w-100" id="tableClientes">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>DNI</th>
                                    <th>Teléfono</th>
                                    <th>Correo</th>
                                    <th>Servicio</th>
                                    <th>Costo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Los datos de los clientes se cargarán aquí dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal para Agregar/Editar Cliente -->
<div class="modal fade" id="modalCliente" tabindex="-1" role="dialog" aria-labelledby="modalClienteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalClienteLabel">Agregar Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form id="formCliente">
                    <input type="hidden" id="idCliente" name="idCliente">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="dni">DNI</label>
                        <input type="text" class="form-control" id="dni" name="dni" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono">
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo">
                    </div>
                    <div class="form-group">
                        <label for="fecha_inicio_contrato">Fecha Inicio Contrato</label>
                        <input type="date" class="form-control" id="fecha_inicio_contrato" name="fecha_inicio_contrato" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_contrato">Tipo de Contrato</label>
                        <select class="form-control" id="tipo_contrato" name="tipo_contrato" required>
                            <option value="mensual">Mensual</option>
                            <option value="bimestral">Bimestral</option>
                            <option value="trimestral">Trimestral</option>
                            <option value="cuatrimestral">Cuatrimestral</option>
                            <option value="semestral">Semestral</option>
                            <option value="anual">Anual</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="servicio">Servicio</label>
                        <input type="text" class="form-control" id="servicio" name="servicio" required>
                    </div>
                    <div class="form-group">
                        <label for="costo">Costo</label>
                        <input type="number" class="form-control" id="costo" name="costo" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select class="form-control" id="estado" name="estado" required>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarCliente()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Acciones del Cliente -->
<div class="modal fade" id="modalAcciones" tabindex="-1" role="dialog" aria-labelledby="modalAccionesLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAccionesLabel">Acciones del Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <button class="btn btn-warning btn-block" id="btnEditar">Editar</button>
                <button class="btn btn-secondary btn-block" id="btnAcuenta">A cuenta</button>
                <button class="btn btn-success btn-block" id="btnMarcarPagado">Marcar como Pagado</button>
                <button class="btn btn-danger btn-block" id="btnEliminar">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    cargarClientes(); // Llamar a la función después de que la vista se cargue
});

// Función para cargar los datos de los clientes con AJAX
function cargarClientes() {
    $.ajax({
        url: "/internet/controladores/ClienteControlador.php?action=getAll",
        method: "GET",
        dataType: "json",
        success: function (data) {
            let tbody = $("#tableClientes tbody");
            tbody.empty(); // Limpiar la tabla antes de agregar datos

            data.forEach(cliente => {
                let row = `
                    <tr>
                        <td>${cliente.id}</td>
                        <td>${cliente.nombre}</td>
                        <td>${cliente.apellido}</td>
                        <td>${cliente.dni}</td>
                        <td>${cliente.telefono}</td>
                        <td>${cliente.correo}</td>
                        <td>${cliente.servicio}</td>
                        <td>${cliente.costo}</td>
                        <td>${cliente.estado}</td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="abrirModalAcciones(${cliente.id})">
                                <i class="fas fa-info-circle"></i> Acciones
                            </button>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar clientes:", error);
        }
    });
}


// Función para abrir el modal
function openModal(id = null) {
    $('#modalAcciones').modal('hide');
    if (id) {
        // Cargar datos del cliente si se está editando
        fetch(`/internet/controladores/ClienteControlador.php?action=get&id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('idCliente').value = data.id;
                document.getElementById('nombre').value = data.nombre;
                document.getElementById('apellido').value = data.apellido;
                document.getElementById('dni').value = data.dni;
                document.getElementById('telefono').value = data.telefono;
                document.getElementById('correo').value = data.correo;
                document.getElementById('fecha_inicio_contrato').value = data.fecha_inicio_contrato;
                document.getElementById('tipo_contrato').value = data.tipo_contrato;
                document.getElementById('servicio').value = data.servicio;
                document.getElementById('costo').value = data.costo;
                document.getElementById('estado').value = data.estado;
                document.getElementById('modalClienteLabel').innerText = 'Editar Cliente';
            });
    } else {
        // Limpiar el formulario si se está agregando un nuevo cliente
        document.getElementById('formCliente').reset();
        document.getElementById('modalClienteLabel').innerText = 'Agregar Cliente';
    }
    $('#modalCliente').modal('show');
}

// Función para guardar o actualizar un cliente
function guardarCliente() {
    const formData = new FormData(document.getElementById('formCliente'));
    fetch('/internet/controladores/ClienteControlador.php?action=save', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Recargar la página para ver los cambios
        } else {
            alert('Error al guardar el cliente');
        }
    });
}

// Función para eliminar un cliente
function eliminarCliente(id) {
    if (confirm('¿Estás seguro de eliminar este cliente?')) {
        fetch(`/internet/controladores/ClienteControlador.php?action=delete&id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Recargar la página para ver los cambios
                } else {
                    alert('Error al eliminar el cliente');
                }
            });
    }
}

function abrirModalAcciones(clienteId) {
    // Asegúrate de que el modal y los botones existan
    const btnEditar = document.getElementById('btnEditar');
    const btnAcuenta = document.getElementById('btnAcuenta');
    const btnMarcarPagado = document.getElementById('btnMarcarPagado');
    const btnEliminar = document.getElementById('btnEliminar');

    if (btnEditar && btnAcuenta && btnMarcarPagado && btnEliminar) {
        // Asignar el ID del cliente a los botones
        btnEditar.onclick = function() { openModal(clienteId); };
        btnAcuenta.onclick = function() { acuenta(clienteId); };
        btnMarcarPagado.onclick = function() { marcarComoPagado(clienteId); };
        btnEliminar.onclick = function() { eliminarCliente(clienteId); };

        // Mostrar el modal
        $('#modalAcciones').modal('show');
    } else {
        console.error("Uno o más botones no se encontraron en el DOM.");
    }
}
</script>