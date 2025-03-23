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
    fetch(`${BASE_URL}/controladores/TrabajadoresControlador.php?action=CargarTablaTrabajadores&${new URLSearchParams(filtros)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la solicitud: ' + response.statusText);
            }
            return response.json();
        })
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
            Swal.fire("Error", "No se pudo cargar la tabla de trabajadores: " + error.message, "error");
        });
};
// fin completar trabajadores 

//  inico guardar trabajador
function guardarTrabajador() {
    // Obtener los datos del formulario
    const formData = new FormData(document.getElementById('formTrabajador'));
    console.log("Datos del formulario:", formData); // Verificar los datos del formulario

    // Determinar si es una acción de creación o edición
    const accion = document.getElementById('idTrabajador').value ? 'editarTrabajador' : 'crearTrabajador';
    console.log("Acción a realizar:", accion); // Verificar la acción

    // Realizar la solicitud fetch
    fetch(`${BASE_URL}/controladores/TrabajadoresControlador.php?action=${accion}`, {
        method: 'POST',
        body: formData
    })
        .then(response => {
            console.log("Respuesta del servidor:", response); // Verificar la respuesta del servidor
            return response.json(); // Intentar convertir la respuesta a JSON
        })
        .then(data => {
            console.log("Datos procesados:", data); // Verificar los datos procesados
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
            console.error('Error al guardar el trabajador:', error); // Capturar errores
            console.log("Respuesta del servidor (texto):", error.responseText); // Verificar la respuesta en texto plano
        });
}
//  fin guardar trabajador

// inicio ver trabajador
function verTrabajador(id) {
    fetch(`${BASE_URL}/controladores/TrabajadoresControlador.php?action=obtenerTrabajador&id=${id}`, {
        method: 'GET' // Cambiado a GET
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la solicitud: ' + response.statusText);
            }
            return response.json();
        })
        .then(response => {
            if (response.success) {
                // Acceder directamente a las propiedades del trabajador
                document.getElementById('viewId').textContent = response.data.IdUsuario;
                document.getElementById('viewNombre').textContent = response.data.NombresUsuario;
                document.getElementById('viewApellido').textContent = response.data.ApellidosUsuario;
                document.getElementById('viewDni').textContent = response.data.DNIUsuario;
                document.getElementById('viewTelefono').textContent = response.data.TelefonoUsuario;
                document.getElementById('viewCorreo').textContent = response.data.CorreoUsuario;
                document.getElementById('viewUsuario').textContent = response.data.UsernameUsuario;
                document.getElementById('viewRol').textContent = response.data.RolUsuario;
                $('#modalViewTrabajador').modal('show');
            } else {
                Swal.fire("Error", response.msg, "error");
            }
        })
        .catch(error => {
            Swal.fire("Error", "No se pudo obtener el trabajador: " + error.message, "error");
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
    fetch(`${BASE_URL}/controladores/TrabajadoresControlador.php?action=obtenerTrabajador&id=${id}`, {
        method: 'GET' // Cambiado a GET
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la solicitud: ' + response.statusText);
            }
            return response.json();
        })
        .then(response => {
            if (response.success) {
                // Acceder directamente a las propiedades del trabajador
                document.getElementById('idTrabajador').value = response.data.IdUsuario;
                document.getElementById('nombre').value = response.data.NombresUsuario;
                document.getElementById('apellido').value = response.data.ApellidosUsuario;
                document.getElementById('dni').value = response.data.DNIUsuario;
                document.getElementById('telefono').value = response.data.TelefonoUsuario;
                document.getElementById('correo').value = response.data.CorreoUsuario;
                document.getElementById('usuario').value = response.data.UsernameUsuario;
                document.getElementById('modalFormTrabajadorLabel').innerText = 'Editar Trabajador';

                // Mostrar modal (para Bootstrap 5)
                let modal = new bootstrap.Modal(document.getElementById('modalFormTrabajador'));
                modal.show();
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