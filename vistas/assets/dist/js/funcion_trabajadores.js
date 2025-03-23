// C:\wamp64\www\helpmdq\vistas\assets\dist\js\funcion_trabajadores.js

// inicio funcionamiento de tabla trabajadores
$(document).ready(function () {
    const table = $('#tableTrabajadores').DataTable({
        "language": {
            "url": `${BASE_URL}/assets/i18n/Spanish.json`
        },
        "columnDefs": [
            { "orderable": true, "targets": [0, 1, 2, 3, 4, 5, 6, 7] },
            { "orderable": false, "targets": [8] }
        ],
        "paging": true,
        "pageLength": 10,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true
    });
    CargarTablaTrabajadores();
});
// fin funcionamiento de tabla trabajadores

// inicio completar trabajadores 
window.CargarTablaTrabajadores = function () {
    const filtros = {
        NombresUsuario: $('#filtroNombre').val(),
        ApellidosUsuario: $('#filtroApellido').val(),
        DNIUsuario: $('#filtroDNI').val(),
        TelefonoUsuario: $('#filtroTelefono').val(),
        CorreoUsuario: $('#filtroCorreo').val()
    };
    fetch(`${BASE_URL}/controladores/TrabajadoresControlador.php?action=buscarTrabajador&${new URLSearchParams(filtros)}`)
        .then(response => {
            return response.json();
        })
        .then(data => {
            const table = $('#tableTrabajadores').DataTable();
            table.clear(); // Limpiar la tabla
            data.forEach(trabajador => {
                table.row.add([
                    trabajador.IdUsuario,
                    trabajador.NombresUsuario,
                    trabajador.ApellidosUsuario,
                    trabajador.DNIUsuario,
                    trabajador.TelefonoUsuario,
                    trabajador.CorreoUsuario,
                    trabajador.UsernameUsuario,
                    trabajador.RolUsuario,
                    `<div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog"></i> Opciones
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#" onclick="verTrabajador(${trabajador.IdUsuario})">Ver</a>
    <a class="dropdown-item" href="#" onclick="editarTrabajador(${trabajador.IdUsuario})">Editar</a>
    <a class="dropdown-item" href="#" onclick="eliminarTrabajador(${trabajador.IdUsuario})">Eliminar</a>
</div>
                        </div>`
                ]).draw(false);
            });
        })
        .catch(error => {
            console.error('Error al buscar trabajadores:', error);
        });
};
// fin completar trabajadores 

//  inico guardar trabajador
function guardarTrabajador() {
    const formData = new FormData(document.getElementById('formTrabajador'));
    const accion = document.getElementById('idTrabajador').value ? 'editarTrabajador' : 'crearTrabajador';

    fetch(`${BASE_URL}/controladores/TrabajadoresControlador.php?action=${accion}`, {
        method: 'POST',
        body: formData
    })
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
        .catch(error => {
            console.error('Error al guardar el trabajador:', error);
        });
}
//  fin guardar trabajador

// inicio ver trabajador
function verTrabajador(id) {
    fetch(`${BASE_URL}/controladores/TrabajadoresControlador.php?action=obtenerTrabajador&id=${id}`)
        .then(response => response.json())
        .then(trabajador => {
            if (trabajador.status) {
                document.getElementById('viewId').textContent = trabajador.data.IdUsuario;
                document.getElementById('viewNombre').textContent = trabajador.data.NombresUsuario;
                document.getElementById('viewApellido').textContent = trabajador.data.ApellidosUsuario;
                document.getElementById('viewDni').textContent = trabajador.data.DNIUsuario;
                document.getElementById('viewTelefono').textContent = trabajador.data.TelefonoUsuario;
                document.getElementById('viewCorreo').textContent = trabajador.data.CorreoUsuario;
                document.getElementById('viewUsuario').textContent = trabajador.data.UsernameUsuario;
                document.getElementById('viewRol').textContent = trabajador.data.RolUsuario;
                $('#modalViewTrabajador').modal('show');
            } else {
                Swal.fire("Error", trabajador.msg, "error");
            }
        })
        .catch(error => {
            console.error('Error al obtener el trabajador:', error);
        });
}
// fin ver trabajador


function crearTrabajador() {
    document.getElementById('formTrabajador').reset();
    document.getElementById('idTrabajador').value = "";
    document.getElementById('modalFormTrabajadorLabel').innerText = 'Crear Trabajador';
    $('#modalFormTrabajador').modal('show');
}

// inicio editar trabajador
function editarTrabajador(id) {
    fetch(`${BASE_URL}/controladores/TrabajadoresControlador.php?action=obtenerTrabajador&id=${id}`)
        .then(response => response.json())
        .then(trabajador => {
            if (trabajador.status) {
                document.getElementById('idTrabajador').value = trabajador.data.IdUsuario;
                document.getElementById('nombre').value = trabajador.data.NombresUsuario;
                document.getElementById('apellido').value = trabajador.data.ApellidosUsuario;
                document.getElementById('dni').value = trabajador.data.DNIUsuario;
                document.getElementById('telefono').value = trabajador.data.TelefonoUsuario;
                document.getElementById('correo').value = trabajador.data.CorreoUsuario;
                document.getElementById('usuario').value = trabajador.data.UsernameUsuario;
                document.getElementById('modalFormTrabajadorLabel').innerText = 'Editar Trabajador';
                $('#modalFormTrabajador').modal('show');
            } else {
                Swal.fire("Error", trabajador.msg, "error");
            }
        })
        .catch(error => {
            console.error('Error al obtener el trabajador:', error);
        });
}
// fin editar trabajador


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

// inicio editar trabajador
function openModal() {

                $('#modalFormTrabajador').modal('show');
            
    
}
// fin editar trabajador