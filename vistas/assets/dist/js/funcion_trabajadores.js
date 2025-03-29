// C:\wamp64\www\helpmdq\vistas\assets\dist\js\funcion_trabajadores.js
// inicio funcionamiento de tabla trabajadores
$(document).ready(function () {
    const table = $('#tableTrabajadores').DataTable({
        "language": {
            "url": `${BASE_URL}/vistas/assets/dist/js/Spanish.json` // Asegúrate de que esta URL sea correcta
        },
        "columnDefs": [
            { "orderable": true, "targets": [0, 1, 2, 3, 4, 5, 6, 7] }, // Columnas ordenables
            { "orderable": false, "targets": [8] } // Columna de acciones no ordenable
        ],
        "paging": true, // Habilitar paginación
        "pageLength": 10, // Número de filas por página
        "lengthChange": true, // Habilitar cambio de longitud de página
        "searching": true, // Habilitar búsqueda
        "ordering": true, // Habilitar ordenación
        "info": true, // Mostrar información de paginación
        "autoWidth": false, // Deshabilitar ajuste automático de ancho
        "responsive": true, // Hacer la tabla responsive
        "dom": 'lfrtip', // Posición de los elementos de la tabla
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
                    "columns": [0, 1, 2, 3, 4, 5, 6]
                }
            }, {
                "extend": "excelHtml5",
                "text": "<i class='bi bi-file-earmark-excel'></i> Excel",
                "titleAttr": "Exportar a Excel",
                "className": "btn btn-success",
                "filename": "Trabajadores_" + new Date().toISOString().split("T")[0],
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5, 6]
                }
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='bi bi-filetype-pdf'></i> Pdf",
                "titleAttr": "Exportar a PDF",
                "className": "btn btn-danger",
                "filename": "Trabajadores_" + new Date().toISOString().split("T")[0],
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5, 6]
                }
            }, {
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr": "Exportar a CSV",
                "className": "btn btn-info d-none",
                "filename": "Trabajadores_" + new Date().toISOString().split("T")[0],
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                "extend": "csv",
                "text": "<i class='fas fa-file-code'></i> JSON",
                "titleAttr": "Exportar a JSON",
                "className": "btn btn-info",
                // "filename": "Trabajadores_" + new Date().toISOString().split("T")[0],
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5, 6]
                }
            }
        ],
    });
    CargarTablaTrabajadores();
    // cargarRoles();
});
// fin funcionamiento de tabla trabajadores





// inicio completar trabajadores 
window.CargarTablaTrabajadores = function () {
    fetch(`${BASE_URL}/controladores/trabajadores/TrabajadoresControlador.php?action=CargarTablaTrabajadores`, { method: 'GET' })
        .then(response => response.json())
        .then(response => {
            if (!response.success) {
                throw new Error(response.msg || 'Error al cargar los datos');
            }
            const table = $('#tableTrabajadores').DataTable();
            table.clear(); // Limpiar los datos existentes
            if (response.data.length === 0) {
                table.draw(); // Redibujar la tabla para que se vea vacía
            }
            response.data.forEach(trabajador => {
                table.row.add([
                    trabajador.IdUsuario,
                    trabajador.NombresUsuario,
                    trabajador.ApellidosUsuario,
                    trabajador.DNIUsuario,
                    trabajador.TelefonoUsuario,
                    trabajador.CorreoUsuario,
                    trabajador.UsernameUsuario,
                    trabajador.NombreRol,
                    `<div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cog"></i> Opciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="btn dropdown-item text-success bg-transparent" href="#" onclick="verTrabajador(${trabajador.IdUsuario})">
                                <i class="fas fa-eye"></i> Ver
                            </button>
                            <button class="btn dropdown-item text-warning  bg-transparent" href="#" onclick="editarTrabajador(${trabajador.IdUsuario})">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button class="btn dropdown-item text-danger bg-transparent" href="#" onclick="eliminarTrabajador(${trabajador.IdUsuario})">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
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
    fetch(`${BASE_URL}/controladores/trabajadores/TrabajadoresControlador.php?action=obtenerTrabajadorPorId&id=${id}`, { method: 'GET' })
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
            fetch(`${BASE_URL}/controladores/trabajadores/TrabajadoresControlador.php?action=eliminarTrabajador`, {
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
async function editarTrabajador(id) {
    try {
        const response = await fetch(`${BASE_URL}/controladores/trabajadores/TrabajadoresControlador.php?action=obtenerTrabajadorPorId&id=${id}`);
        const result = await response.json();
        if (result.success) {
            document.getElementById('formTrabajador').reset();
            // Carga los roles y espera a que termine
            await cargarRolesSelect();
            // Llena el formulario
            document.getElementById('idTrabajador').value = result.data.IdUsuario;
            document.getElementById('nombre').value = result.data.NombresUsuario;
            document.getElementById('apellido').value = result.data.ApellidosUsuario;
            document.getElementById('dni').value = result.data.DNIUsuario;
            document.getElementById('telefono').value = result.data.TelefonoUsuario;
            document.getElementById('correo').value = result.data.CorreoUsuario;
            document.getElementById('usuario').value = result.data.UsernameUsuario;
            // Asigna el valor del rol (¡sin selectpicker!)
            document.getElementById('rol').value = result.data.RolUsuario;
            // Muestra el modal
            document.getElementById('modalFormTrabajadorLabel').innerText = 'Editar Trabajador';
            $('#modalFormTrabajador').modal('show');
        } else {
            Swal.fire("Error", result.msg, "error");
        }
    } catch (error) {
        console.error('Error al obtener el trabajador:', error);
        Swal.fire("Error", "No se pudo obtener la información del trabajador.", "error");
    }
}
// fin editar trabajador





// inicio guardar trabajador
function guardarTrabajador() {
    const formData = new FormData(document.getElementById('formTrabajador'));
    const accion = document.getElementById('idTrabajador').value ? 'editarTrabajador' : 'crearTrabajador';

    fetch(`${BASE_URL}/controladores/trabajadores/TrabajadoresControlador.php?action=${accion}`, {
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
            console.error("Error:", error);
            Swal.fire("Error", "Hubo un problema al procesar la solicitud", "error");
        });
}
// fin guardar trabajador





// inicio editar trabajador
function openModal() {
    document.getElementById('formTrabajador').reset();
    document.getElementById('idTrabajador').value = "";
    document.getElementById('modalFormTrabajadorLabel').innerText = 'Nuevo Trabajador';
    cargarRolesSelect();
    $('#modalFormTrabajador').modal('show');
}
// fin editar trabajador





// inicio funcionesde open and close menu opciones
function toggleConfigMenu() {
    const menu = document.getElementById('configMenu');
    if (menu.style.display === 'none' || menu.style.display === '') {
        menu.style.display = 'block';
        // Agregar event listener para cerrar al hacer clic fuera
        document.addEventListener('click', closeConfigMenuOnClickOutside);
    } else {
        menu.style.display = 'none';
        document.removeEventListener('click', closeConfigMenuOnClickOutside);
    }
}
function closeConfigMenuOnClickOutside(event) {
    const menu = document.getElementById('configMenu');
    const button = document.getElementById('configButton');

    // Si el clic no fue dentro del menú ni en el botón
    if (!menu.contains(event.target) && !button.contains(event.target)) {
        menu.style.display = 'none';
        document.removeEventListener('click', closeConfigMenuOnClickOutside);
    }
}
// fin funcionesde open and close menu opciones





// inicio Función para cargar los roles desde el servidor
let estadoInicialRoles = {}; // Guarda el estado inicial de los roles
function cargarRoles() {
    fetch(`${BASE_URL}/controladores/trabajadores/TrabajadoresControlador.php?action=CargarRoles`, { method: 'GET' })
        .then(response => response.json())
        .then(({ success, data, msg }) => {
            if (!success) throw new Error(msg || 'Error al cargar los roles');
            const rolesList = document.getElementById('roles-list');
            rolesList.innerHTML = ''; // Limpiar lista previa
            estadoInicialRoles = {}; // Resetear el estado inicial
            data.forEach(({ IdRol, NombreRol, NombreModulo }) => {
                const asignadoATrabajadores = NombreModulo === "Trabajadores";
                const noAsignado = NombreModulo === "No asignado";
                const asignadoAOtroModulo = !noAsignado && !asignadoATrabajadores;
                const checked = asignadoATrabajadores || asignadoAOtroModulo;
                const disabled = asignadoAOtroModulo;
                estadoInicialRoles[IdRol] = checked; // Guardar el estado original

                const div = document.createElement('div');
                div.className = 'form-check';
                div.innerHTML = `
                    <input class="form-check-input" type="checkbox" value="${IdRol}" id="rol-${IdRol}" 
                        ${checked ? 'checked' : ''} ${disabled ? 'disabled' : ''}>
                    <label class="form-check-label" for="rol-${IdRol}" data-bs-toggle="tooltip" title="Asignado a ${NombreModulo}">
                        ${NombreRol}
                    </label>
                `;
                // Prevenir que el clic en el checkbox o label cierre el menú
                div.querySelector('input').addEventListener('click', e => e.stopPropagation());
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
    const checkboxes = document.querySelectorAll('#roles-list .form-check-input');
    let rolesNuevos = [];
    let rolesEliminados = [];
    checkboxes.forEach(checkbox => {
        const idRol = checkbox.value;
        const activo = checkbox.checked;
        // Si el estado cambió, lo agregamos a la lista de cambios
        if (estadoInicialRoles[idRol] !== activo) {
            if (activo) {
                rolesNuevos.push(idRol); // Se activó
            } else {
                rolesEliminados.push(idRol); // Se desactivó
            }
        }
    });
    if (rolesNuevos.length === 0 && rolesEliminados.length === 0) {
        return Swal.fire("Sin cambios", "No has realizado cambios en los roles.", "info");
    }
    // Enviar solo los roles activados
    if (rolesNuevos.length > 0) {
        fetch(`${BASE_URL}/controladores/trabajadores/TrabajadoresControlador.php?action=guardarConfiguracion`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ roles: rolesNuevos })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Éxito", "Roles activados correctamente.", "success");
                    cargarRoles();
                    CargarTablaTrabajadores();
                } else {
                    Swal.fire("Error", data.msg || "No se pudieron activar los roles.", "error");
                }
            })
            .catch(() => Swal.fire("Error", "Hubo un problema al activar los roles.", "error"));
    }
    // Enviar solo los roles desactivados
    if (rolesEliminados.length > 0) {
        eliminarRelacionModuloRol(rolesEliminados);
    }
}
// fin Función para guardar la configuración





// Inicio Función para eliminar la configuración
function eliminarRelacionModuloRol(rolesEliminados) {
    fetch(`${BASE_URL}/controladores/trabajadores/TrabajadoresControlador.php?action=eliminarRelacionModuloRol`, {
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





// inicio funcion cargar roles en select para formuladio de nuevo o editar
function cargarRolesSelect() {
    return new Promise((resolve, reject) => {
        fetch(`${BASE_URL}/controladores/trabajadores/TrabajadoresControlador.php?action=CargarRoles`)
            .then(response => response.json())
            .then(({ success, data, msg }) => {
                if (!success) {
                    reject(msg || 'Error al cargar los roles');
                    return;
                }
                const select = document.getElementById('rol');
                select.innerHTML = '<option value="">Seleccione un rol</option>';

                data.forEach(({ IdRol, NombreRol }) => {
                    const option = document.createElement('option');
                    option.value = IdRol;
                    option.textContent = NombreRol;
                    select.appendChild(option);
                });

                resolve();
            })
            .catch(error => reject(error));
    });
}
// inicio funcion cargar roles en select para formuladio de nuevo o editar