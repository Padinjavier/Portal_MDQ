// C:\wamp64\www\helpmdq\vistas\assets\dist\js\funcion_roles.js
// inicio funcionamiento de tabla Roles
$(document).ready(function () {
    const table = $('#tableRoles').DataTable({
        "language": {
            "url": `${BASE_URL}/vistas/assets/dist/js/Spanish.json` // Asegúrate de que esta URL sea correcta
        },
        "columnDefs": [
            { "orderable": true, "targets": [0, 1, 2] }, // Columnas ordenables
            { "orderable": false, "targets": [3] } // Columna de acciones no ordenable
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
        "order": [[0, "desc"]]
    });
    CargarTablaRoles();
    // cargarRoles();
});
// fin funcionamiento de tabla Roles





// inicio completar Roles 
window.CargarTablaRoles = function () {
    fetch(`${BASE_URL}/controladores/roles/RolesControlador.php?action=CargarTablaRoles`, { method: 'GET' })
        .then(response => response.json())
        .then(response => {
            if (!response.success) {
                throw new Error(response.msg || 'Error al cargar los datos');
            }
            const table = $('#tableRoles').DataTable();
            table.clear(); // Limpiar los datos existentes
            if (response.data.length === 0) {
                table.draw(); // Redibujar la tabla para que se vea vacía
            }
            response.data.forEach(rol => {
                table.row.add([
                    rol.IdRol,
                    rol.NombreRol,
                    rol.DescripcionRol,
                    `<div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cog"></i> Opciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="btn dropdown-item text-info bg-transparent" href="#" onclick="permisoRol(${rol.IdRol})">
                                <i class="fas fa-key"></i> Permisos
                            </button>
                            <button class="btn dropdown-item text-success bg-transparent" href="#" onclick="verRol(${rol.IdRol})">
                                <i class="fas fa-eye"></i> Ver
                            </button>
                            <button class="btn dropdown-item text-warning  bg-transparent" href="#" onclick="editarRol(${rol.IdRol})">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button class="btn dropdown-item text-danger bg-transparent" href="#" onclick="eliminarRol(${rol.IdRol})">
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

// fin completar Roles 





// inicio ver rol
function verRol(id) {
    fetch(`${BASE_URL}/controladores/roles/RolesControlador.php?action=obtenerRolPorId&id=${id}`, { method: 'GET' })
        .then(response => response.json())
        .then(response => {
            if (!response.success) {
                throw new Error('Error en la solicitud: ' + response.statusText);
            }
            const rol = response.data;
            document.getElementById('viewNombre').textContent = rol.NombreRol;
            document.getElementById('viewDescripcion').textContent = rol.DescripcionRol;
            $('#modalViewRol').modal('show');
        })
        .catch(error => {
            Swal.fire("Error", error.message, "error");
        });
}
// fin ver rol





// inicio eliminar rol 
function eliminarRol(id) {
    Swal.fire({
        title: "Eliminar Rol",
        text: "¿Realmente quiere eliminar el Rol?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`${BASE_URL}/controladores/roles/RolesControlador.php?action=eliminarRol`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('¡Eliminado!', 'El rol ha sido eliminado correctamente.', 'success')
                            .then(() => CargarTablaRoles());
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
// fin eliminar rol 





// inicio editar rol
async function editarRol(id) {
    try {
        const response = await fetch(`${BASE_URL}/controladores/roles/RolesControlador.php?action=obtenerRolPorId&id=${id}`);
        const result = await response.json();
        if (result.success) {
            document.getElementById('formRol').reset();
            // Llena el formulario
            document.getElementById('idRol').value = result.data.IdRol;
            document.getElementById('nombre').value = result.data.NombreRol;
            document.getElementById('descripcion').value = result.data.DescripcionRol;
            document.getElementById('modalFormRolLabel').innerText = 'Editar Rol';
            // Muestra el modal
            $('#modalFormRol').modal('show');
        } else {
            Swal.fire("Error", result.msg, "error");
        }
    } catch (error) {
        console.error('Error al obtener el rol:', error);
        Swal.fire("Error", "No se pudo obtener la información del rol.", "error");
    }
}
// fin editar rol





// inicio guardar rol
function guardarRol() {
    const formData = new FormData(document.getElementById('formRol'));
    const accion = document.getElementById('idRol').value ? 'editarRol' : 'crearRol';
    fetch(`${BASE_URL}/controladores/roles/RolesControlador.php?action=${accion}`, {
        method: 'POST',
        body: formData
    })
        .then(response => response.text()) // Obtener la respuesta como texto
        .then(text => {
            try {
                const data = JSON.parse(text); // Intentar parsear el JSON
                if (data.success) {
                    Swal.fire("Éxito", data.msg, "success").then(() => {
                        $('#modalFormRol').modal('hide');
                        CargarTablaRoles(); // Recargar la tabla
                    });
                } else {
                    throw new Error(data.msg); // Forzar un error para que lo maneje el catch
                }
            } catch (error) {
                throw new Error(text); // Si JSON.parse falla, lanzar el error con el HTML recibido
            }
        })
        .catch(error => {
            Swal.fire({
                title: "Error",
                html: error.message, // Mostrar error o HTML en caso de fallo
                icon: "error",
                width: "60%",
                customClass: {
                    popup: 'swal-wide'
                }
            });
        });
}


// fin guardar rol





// inicio editar rol
function openModal() {
    document.getElementById('formRol').reset();
    document.getElementById('idRol').value = "";
    document.getElementById('modalFormRolLabel').innerText = 'Nuevo Rol';
    // cargarRolesSelect();
    $('#modalFormRol').modal('show');
}
// fin editar rol




// inicio ver permisosrol
function permisoRol(id) {
    fetch(`${BASE_URL}/controladores/roles/RolesControlador.php?action=permisoRol&id=${id}`, { method: 'GET' })
        .then(response => response.json())
        .then(response => {
            if (!response.success) {
                throw new Error(response.msg || 'Error al obtener los permisos.');
            }
            const tbody = document.getElementById("tbodyPermisos");
            tbody.innerHTML = ""; // Limpiar contenido previo

            const modulos = response.modulos;
            const permisos = response.permisos.reduce((acc, permiso) => {
                acc[permiso.IdModulo] = {
                    R: Number(permiso.R),
                    W: Number(permiso.W),
                    U: Number(permiso.U),
                    D: Number(permiso.D)
                };
                return acc;
            }, {});


            modulos.forEach((modulo, index) => {
                const permiso = permisos[modulo.IdModulo] || { R: 0, W: 0, U: 0, D: 0 };
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${index + 1}
                        <input type="hidden" name="modulos[${index}][idmodulo]" value="${modulo.IdModulo}">
                    </td>
                    <td>${modulo.NombreModulo}</td>
                    <td>
                        <div class="toggle-flip">
                            <label>
                                <input type="checkbox" name="modulos[${index}][r]" ${permiso.R ? "checked" : ""}>
                                <span class="flip-indecator" data-toggle-on="Activo" data-toggle-off="Inactivo"></span>
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="toggle-flip">
                            <label>
                                <input type="checkbox" name="modulos[${index}][w]" ${permiso.W ? "checked" : ""}>
                                <span class="flip-indecator" data-toggle-on="Activo" data-toggle-off="Inactivo"></span>
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="toggle-flip">
                            <label>
                                <input type="checkbox" name="modulos[${index}][u]" ${permiso.U ? "checked" : ""}>
                                <span class="flip-indecator" data-toggle-on="Activo" data-toggle-off="Inactivo"></span>
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="toggle-flip">
                            <label>
                                <input type="checkbox" name="modulos[${index}][d]" ${permiso.D ? "checked" : ""}>
                                <span class="flip-indecator" data-toggle-on="Activo" data-toggle-off="Inactivo"></span>
                            </label>
                        </div>
                    </td>
                `;
                tbody.appendChild(row);
            });
            document.getElementById("IdRol").value = id;
            document.getElementById("modalFormPermisosRolLabel").innerText="Permisos del Rol "+response.rol.NombreRol;
            $("#modalViewPermisosRol").modal("show");
        })
        .catch(error => {
            Swal.fire({
                title: "Error",
                html: error.message, // Mostrar error o HTML en caso de fallo
                icon: "error",
                width: "60%",
                customClass: {
                    popup: 'swal-wide'
                }
            });
        });
}
// fin permisos de rol


function guardarPermisos() {
    const idRol = document.getElementById("IdRol").value; // Obtener ID del rol
    const formData = new FormData();
    formData.append("idRol", idRol);

    const checkboxes = document.querySelectorAll("#tbodyPermisos tr");

    checkboxes.forEach((row, index) => {
        const idmodulo = row.querySelector(`input[name="modulos[${index}][idmodulo]"]`).value;
        const r = row.querySelector(`input[name="modulos[${index}][r]"]`).checked ? 1 : 0;
        const w = row.querySelector(`input[name="modulos[${index}][w]"]`).checked ? 1 : 0;
        const u = row.querySelector(`input[name="modulos[${index}][u]"]`).checked ? 1 : 0;
        const d = row.querySelector(`input[name="modulos[${index}][d]"]`).checked ? 1 : 0;

        formData.append(`permisos[${index}][idmodulo]`, idmodulo);
        formData.append(`permisos[${index}][r]`, r);
        formData.append(`permisos[${index}][w]`, w);
        formData.append(`permisos[${index}][u]`, u);
        formData.append(`permisos[${index}][d]`, d);
    });

    fetch(`${BASE_URL}/controladores/roles/RolesControlador.php?action=guardarPermisos`, {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(response => {
            if (!response.success) {
                throw new Error(response.msg || "Error al guardar los permisos.");
            }
            Swal.fire("Éxito", "Permisos guardados correctamente", "success")
                .then(() => $("#modalViewPermisosRol").modal("hide"));
        })
        .catch(error => {
            Swal.fire("Error", error.message, "error");
        });
}


