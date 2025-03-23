// C:\wamp64\www\helpmdq\vistas\assets\dist\js\funcion_trabajadores.js
// inicio funcionamiento de tabla trabajadores
$(document).ready(function () {
    const table = $('#tableTrabajadores').DataTable({
        "language": {
            "url": `${BASE_URL}/assets/i18n/Spanish.json` // Asegúrate de que esta URL sea correcta
        },
        "columnDefs": [
            { "orderable": true, "targets": [0, 1, 2, 3, 4, 5, 6] }, // Columnas ordenables
            { "orderable": false, "targets": [7] } // Columna de acciones no ordenable
        ],
        "paging": true, // Habilitar paginación
        "pageLength": 10, // Número de filas por página
        "lengthChange": false, // Deshabilitar cambio de longitud de página
        "searching": true, // Habilitar búsqueda
        "ordering": true, // Habilitar ordenación
        "info": true, // Mostrar información de paginación
        "autoWidth": false, // Deshabilitar ajuste automático de ancho
        "responsive": true, // Hacer la tabla responsive
        "dom": 'Bfrtip', // Posición de los elementos de la tabla (B: botones, f: filtro, r: procesamiento, t: tabla, i: información, p: paginación)
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print' // Botones de exportación
        ]
    });
    // Función para cargar datos en la tabla (debes implementarla)
    CargarTablaTrabajadores();
});
// fin funcionamiento de tabla trabajadores





// inicio completar trabajadores 
window.CargarTablaTrabajadores = function () {
    fetch(`${BASE_URL}/controladores/TrabajadoresControlador.php?action=CargarTablaTrabajadores`)
        .then(response => response.json())
        .then(response => {
            if (!response.success) {
                throw new Error(response.msg || 'Error al cargar los datos');
            }

            const table = $('#tableTrabajadores').DataTable();
            table.clear();

            response.data.forEach(trabajador => {
                table.row.add([
                    trabajador.IdUsuario,
                    trabajador.NombresUsuario,
                    trabajador.ApellidosUsuario,
                    trabajador.DNIUsuario,
                    trabajador.TelefonoUsuario,
                    trabajador.CorreoUsuario,
                    trabajador.UsernameUsuario,
                    `<div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cog"></i> Opciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item text-success" href="#" onclick="verTrabajador(${trabajador.IdUsuario})">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a class="dropdown-item text-warning" href="#" onclick="editarTrabajador(${trabajador.IdUsuario})">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a class="dropdown-item text-danger" href="#" onclick="eliminarTrabajador(${trabajador.IdUsuario})">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        </div>
                    </div>`
                ]).draw(false);
            });
        })
        .catch(error => {
            Swal.fire("Error", error.message, "error");
        });
};
// fin completar trabajadores 





// inicio ver trabajador
function verTrabajador(id) {
    fetch(`${BASE_URL}/controladores/TrabajadoresControlador.php?action=obtenerTrabajadorPorId&id=${id}`, { method: 'GET' })
        .then(response => response.json())
        .then(response => {
            if (!response.success) {
                throw new Error('Error en la solicitud: ' + response.statusText);
            }
            const trabajador = response.data;
            document.getElementById('viewNombre').textContent = trabajador.NombresUsuario;
            document.getElementById('viewApellido').textContent = trabajador.ApellidosUsuario;
            document.getElementById('viewDni').textContent = trabajador.DNIUsuario;
            document.getElementById('viewTelefono').textContent = trabajador.TelefonoUsuario;
            document.getElementById('viewCorreo').textContent = trabajador.CorreoUsuario;
            document.getElementById('viewUsuario').textContent = trabajador.UsernameUsuario;
            $('#modalViewTrabajador').modal('show');
        })
        .catch(error => {
            Swal.fire("Error", error.message, "error");
        });
}
// fin ver trabajador





// inicio eliminar trabajador 
function eliminarTrabajador(id) {
    Swal.fire({
        title: "Eliminar Trabajador",
        text: "¿Realmente quiere eliminar al Trabajador?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`${BASE_URL}/controladores/TrabajadoresControlador.php?action=eliminarTrabajador&id=${id}`)
                .then(response => response.json())
                .then(data => {
                    const message = data.success ? '¡Eliminado! El trabajador ha sido eliminado correctamente.' : 'Error: No se pudo eliminar el trabajador.';
                    const icon = data.success ? 'success' : 'error';
                    Swal.fire(message, '', icon).then(() => CargarTablaTrabajadores());
                })
                .catch(() => Swal.fire('Error', 'Hubo un problema al intentar eliminar el trabajador.', 'error'));
        }
    });
}
// fin eliminar trabajador 





// inicio editar trabajador
function editarTrabajador(id) {
    fetch(`${BASE_URL}/controladores/TrabajadoresControlador.php?action=obtenerTrabajadorPorId&id=${id}`, { method: 'GET' })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                document.getElementById('formTrabajador').reset();
                document.getElementById('idTrabajador').value = response.data.IdUsuario;
                document.getElementById('nombre').value = response.data.NombresUsuario;
                document.getElementById('apellido').value = response.data.ApellidosUsuario;
                document.getElementById('dni').value = response.data.DNIUsuario;
                document.getElementById('telefono').value = response.data.TelefonoUsuario;
                document.getElementById('correo').value = response.data.CorreoUsuario;
                document.getElementById('usuario').value = response.data.UsernameUsuario;
                document.getElementById('alerpassword').innerText = '(*) Ingrese una nueva contraseña solo si desea cambiarla. De lo contrario, déjelo vacío.';
                document.getElementById('modalFormTrabajadorLabel').innerText = 'Editar Trabajador';
                $('#modalFormTrabajador').modal('show');
            } else {
                Swal.fire("Error", trabajador.msg, "error");
            }
        })
        .catch(error => {
            console.error('Error al obtener el trabajador:', error);
            Swal.fire("Error", "No se pudo obtener la información del trabajador.", "error");
        });
}
// fin editar trabajador





// inicio guardar trabajador
function guardarTrabajador() {
    const formData = new FormData(document.getElementById('formTrabajador'));
    const accion = document.getElementById('idTrabajador').value ? 'editarTrabajador' : 'crearTrabajador';
    fetch(`${BASE_URL}/controladores/TrabajadoresControlador.php?action=${accion}`, { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire("Éxito", data.msg, "success").then(() => {
                    $('#modalFormTrabajador').modal('hide');
                    CargarTablaTrabajadores(); // Recargar la tabla
                });
            } else {
                Swal.fire("Error", data.msg, "error");
            }
        })
        .catch(error => Swal.fire("Error", "Hubo un problema al procesar la solicitud: " + error.message, "error"));
}
// fin guardar trabajador





// inicio editar trabajador
function openModal() {
    document.getElementById('formTrabajador').reset();
    document.getElementById('idTrabajador').value = "";
    document.getElementById('alerpassword').innerText = '(*) Ingrese una nueva contraseña segura.';
    document.getElementById('modalFormTrabajadorLabel').innerText = 'Nuevo Trabajador';
    $('#modalFormTrabajador').modal('show');
}
// fin editar trabajador