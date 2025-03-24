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
        "lengthChange": true, // Habilitar cambio de longitud de página
        "searching": true, // Habilitar búsqueda
        "ordering": true, // Habilitar ordenación
        "info": true, // Mostrar información de paginación
        "autoWidth": false, // Deshabilitar ajuste automático de ancho
        "responsive": true, // Hacer la tabla responsive
        "dom": 'lBfrtip', // Posición de los elementos de la tabla
        "bDestroy": true,
        "iDisplayLength": 10,
        "lengthMenu": [5, 10, 25, 50, 100], // Opciones de longitud de página
        "order": [[0, "desc"]],
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary",
                "filename": "Trabajadores_" + new Date().toISOString().split("T")[0],
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5]
                }
            }, {
                "extend": "excelHtml5",
                "text": "<i class='bi bi-file-earmark-excel'></i> Excel",
                "titleAttr": "Exportar a Excel",
                "className": "btn btn-success",
                "filename": "Trabajadores_" + new Date().toISOString().split("T")[0],
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5]
                }
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='bi bi-filetype-pdf'></i> Pdf",
                "titleAttr": "Exportar a PDF",
                "className": "btn btn-danger",
                "filename": "Trabajadores_" + new Date().toISOString().split("T")[0],
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5]
                }
            }, {
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr": "Exportar a CSV",
                "className": "btn btn-info d-none",
                "filename": "Trabajadores_" + new Date().toISOString().split("T")[0],
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5]
                }
            },
            {
                "extend": "csv",
                "text": "<i class='fas fa-file-code'></i> JSON",
                "titleAttr": "Exportar a JSON",
                "className": "btn btn-info",
                // "filename": "Trabajadores_" + new Date().toISOString().split("T")[0],
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5]
                }
            }
        ],
    });
    CargarTablaTrabajadores();
    cargarRoles();
});
// fin funcionamiento de tabla trabajadores





// inicio completar trabajadores 
window.CargarTablaTrabajadores = function () {
    fetch(`${BASE_URL}/controladores/TrabajadoresControlador.php?action=CargarTablaTrabajadores`, { method: 'GET' })
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
            Swal.fire({
                title: "Error en la respuesta",
                html: error.message, // Muestra el error como HTML
                icon: "error",
                width: "70%",
                customClass: { popup: 'text-start' }
            });
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
            fetch(`${BASE_URL}/controladores/TrabajadoresControlador.php?action=eliminarTrabajador`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('¡Eliminado!', 'El trabajador ha sido eliminado correctamente.', 'success')
                            .then(() => CargarTablaTrabajadores());
                    } else {
                        // Mostrar el error completo
                        Swal.fire({
                            title: "Error en la respuesta",
                            html: data.msg, // Muestra el error como HTML
                            icon: "error",
                            width: "70%",
                            customClass: { popup: 'text-start' }
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: "Error en la solicitud",
                        html: error.message, // Muestra el error como HTML
                        icon: "error",
                        width: "70%",
                        customClass: { popup: 'text-start' }
                    });
                });
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

    fetch(`${BASE_URL}/controladores/TrabajadoresControlador.php?action=${accion}`, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        return response.text(); // Primero obtenemos el texto para ver qué contiene
    })
    .then(text => {
        return JSON.parse(text); // Luego intentamos parsearlo como JSON
    })
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
        console.error(error); // Imprime el error en la consola
        Swal.fire("Error", "Hubo un problema al procesar la solicitud: " + error.message, "error");
    });
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





// inicio Función para cargar los roles desde el servidor
let estadoInicialRoles = {}; // Guarda el estado inicial de los roles
function cargarRoles() {
    fetch(`${BASE_URL}/controladores/TrabajadoresControlador.php?action=CargarRoles`, { method: 'GET' })
        .then(response => response.json())
        .then(({ success, data, msg }) => {
            if (!success) throw new Error(msg || 'Error al cargar los roles');
            const rolesList = document.getElementById('roles-list');
            rolesList.innerHTML = '';
            estadoInicialRoles = {}; // Resetear el estado inicial
            data.forEach(({ IdRol, NombreRol, NombreModulo }) => {
                const asignadoATrabajadores = NombreModulo === "Trabajadores";
                const noAsignado = NombreModulo === "No asignado";
                const asignadoAOtroModulo = !noAsignado && !asignadoATrabajadores;
                const checked = asignadoATrabajadores || asignadoAOtroModulo;
                const disabled = asignadoAOtroModulo;
                estadoInicialRoles[IdRol] = checked; // Guardar el estado original
                const div = document.createElement('div');
                div.className = 'form-check form-switch d-flex align-items-center mb-2';
                div.innerHTML = `
                    <input class="form-check-input" type="checkbox" role="switch" id="rol-${IdRol}" value="${IdRol}"
                        ${checked ? 'checked' : ''} ${disabled ? 'disabled' : ''}>
                    <label class="form-check-label ms-2 fw-bold" for="rol-${IdRol}" data-bs-toggle="tooltip" title="Asignado a ${NombreModulo}">
                        ${NombreRol}
                    </label>
                `;
                div.querySelector('label').addEventListener('click', e => e.stopPropagation());
                rolesList.appendChild(div);
            });
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
        })
        .catch(error => {
            console.error('Error al cargar roles:', error);
            Swal.fire("Error", "No se pudieron cargar los roles.", "error");
        });
}
// fin Función para cargar los roles desde el servidor





// Inicio Función para guardar la configuración
function guardarConfiguracion() {
    const rolesNuevos = [...document.querySelectorAll('#roles-list .form-check-input')]
        .filter(checkbox => checkbox.checked && !estadoInicialRoles[checkbox.value])
        .map(checkbox => checkbox.value);

    const rolesEliminados = Object.keys(estadoInicialRoles)
        .filter(idRol => estadoInicialRoles[idRol] && !document.getElementById(`rol-${idRol}`).checked);

    if (!rolesNuevos.length && !rolesEliminados.length) {
        return Swal.fire("Sin cambios", "No has realizado cambios en los roles.", "info");
    }

    // Guardar nuevos roles
    if (rolesNuevos.length) {
        fetch(`${BASE_URL}/controladores/TrabajadoresControlador.php?action=guardarConfiguracion`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ roles: rolesNuevos })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Éxito", "Configuración guardada correctamente.", "success");
                    cargarRoles(); // Recargar los roles para reflejar los cambios
                    CargarTablaTrabajadores(); // Recargar la tabla
                } else {
                    Swal.fire("Error", data.msg || "No se pudo guardar la configuración.", "error");
                }
            })
            .catch(() => Swal.fire("Error", "Hubo un problema al guardar la configuración.", "error"));

    } else {
        // Eliminar roles desactivados
        eliminarRelacionModuloRol(rolesEliminados);
    }
}
// fin Función para guardar la configuración



// Inicio Función para eliminar la configuración
function eliminarRelacionModuloRol(rolesEliminados) {
    fetch(`${BASE_URL}/controladores/TrabajadoresControlador.php?action=eliminarRelacionModuloRol`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ roles: rolesEliminados })
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire("Éxito", "Relación eliminada correctamente.", "success");
                CargarTablaTrabajadores(); // Recargar la tabla
                cargarRoles(); // Recargar los roles para reflejar los cambios
            } else {
                Swal.fire("Error", data.msg || "No se pudo eliminar la relación.", "error");
            }
        })
        .catch(() => Swal.fire("Error", "Hubo un problema al eliminar la relación.", "error"));
}
// fin Función para eliminar la configuración
