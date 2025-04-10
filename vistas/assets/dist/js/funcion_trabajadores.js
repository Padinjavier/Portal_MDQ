// C:\wamp64\www\helpmdq\vistas\assets\dist\js\funcion_trabajadores.js
// INICIO FUNCIONAMIENTO DE TABLA TRABAJADORES
$(document).ready(function () {
    const table = $('#TablaTrabajadores').DataTable({
        "language": {
            "url": `${BASE_URL}/vistas/assets/dist/js/Spanish.json`
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
    });
    CargarDatosTrabajadores();
});
// FIN FUNCIONAMIENTO DE TABLA TRABAJADORES





// INICIO COMPLETAR TABLE TRABAJADORES 
window.CargarDatosTrabajadores = function () {
    fetch(`${BASE_URL}/controladores/trabajadores/TrabajadoresControlador.php?action=CargarDatosTrabajadores`, { method: 'GET' })
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (!data.success) throw data.msg || "Error en el servidor";
                const table = $('#TablaTrabajadores').DataTable();
                table.clear();
                data.data?.forEach(Trabajador => {
                    table.row.add([
                        Trabajador.IdUsuario,
                        Trabajador.NombresUsuario,
                        Trabajador.ApellidosUsuario,
                        Trabajador.DNIUsuario,
                        Trabajador.TelefonoUsuario,
                        Trabajador.CorreoUsuario,
                        Trabajador.UsernameUsuario,
                        Trabajador.NombreRol,
                        `<div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown"><i class="fas fa-cog"></i> Opciones</button>
                        <div class="dropdown-menu">
                            <button class="btn dropdown-item text-success bg-transparent" onclick="VerTrabajador(${Trabajador.IdUsuario})"><i class="fas fa-eye"></i> Ver</button>
                            <button class="btn dropdown-item text-warning  bg-transparent" onclick="EditarTrabajador(${Trabajador.IdUsuario})"><i class="fas fa-edit"></i> Editar</button>
                            <button class="btn dropdown-item text-danger bg-transparent" onclick="EliminarTrabajador(${Trabajador.IdUsuario})"><i class="fas fa-trash"></i> Eliminar</button>
                        </div>
                    </div>`
                    ]).draw(false);
                });
            } catch {
                throw text; // Si no es JSON válido, lanzamos el HTML
            }
        })
        .catch(error => Swal.fire({
            title: "Error",
            html: typeof error === 'string' ? error : "Error desconocido",
            icon: "error",
        }));
};
// FIN COMPLETAR TABLE TRABAJADORES





// INICIO EDITAR TRABAJADOR
function openModal() {
    document.getElementById('FormularioTrabajador').reset();
    document.getElementById('IdTrabajador').value = "";
    document.getElementById('ModalFormLabelTrabajador').innerText = 'Nuevo Trabajador';
    cargarRolesSelect();
    $('#ModalFormTrabajador').modal('show');
}
// FIN EDITAR TRABAJADOR





// inicio guardar trabajador
function GuardarTrabajador() {
    const formData = new FormData(document.getElementById('FormularioTrabajador'));
    const accion = document.getElementById('IdTrabajador').value ? 'EditarTrabajador' : 'GuardarTrabajador';
    fetch(`${BASE_URL}/controladores/trabajadores/TrabajadoresControlador.php?action=${accion}`, {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (!data.success) {
                    Swal.fire("Error", data.msg || "Error en el servidor", "error");
                    return; // Salir de la función para evitar ejecutar el éxito
                }
                Swal.fire("Éxito", data.msg, "success").then(() => {
                    $('#ModalFormTrabajador').modal('hide');
                    CargarDatosTrabajadores();
                });
            } catch {
                throw text; // Si no es JSON válido, lanzamos el HTML con text
            }
        })
        .catch(error => Swal.fire({
            title: "Error",
            html: typeof error === 'string' ? error : "Error desconocido",        // Si no es JSON válido, mostrar el error crudo (HTML)
            icon: "error",
        }));
}
// inicio guardar trabajador





// INICIO VER TRABAJADOR
function VerTrabajador(id) {
    fetch(`${BASE_URL}/controladores/trabajadores/TrabajadoresControlador.php?action=BuscarTrabajador&id=${id}`, { method: 'GET' })
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (!data.success) throw data.msg || "Error en el servidor";
                const trabajador = data.data;
                document.getElementById('ViewNombresTrabajador').textContent = trabajador.NombresUsuario;
                document.getElementById('ViewApellidosTrabajador').textContent = trabajador.ApellidosUsuario;
                document.getElementById('ViewDNITrabajador').textContent = trabajador.DNIUsuario;
                document.getElementById('ViewTelefonoTrabajador').textContent = trabajador.TelefonoUsuario;
                document.getElementById('ViewCorreoTrabajador').textContent = trabajador.CorreoUsuario;
                document.getElementById('ViewUsernameTrabajador').textContent = trabajador.UsernameUsuario;
                $('#ModalViewTrabajador').modal('show');
            } catch {
                throw text; // Si no es JSON válido, lanzamos el HTML
            }
        })
        .catch(error => Swal.fire({
            title: "Error",
            html: typeof error === 'string' ? error : "Error desconocido",
            icon: "error",
        }));
}
// FIN VER TRABAJADOR





// inicio funcion cargar roles en select para formuladio de nuevo o editar
function cargarRolesSelect() {
    return new Promise((resolve) => {
        fetch(`${BASE_URL}/controladores/trabajadores/TrabajadoresControlador.php?action=CargarRoles`)
            .then(response => response.text())
            .then(text => {
                let Roles;
                try {
                    Roles = JSON.parse(text);
                } catch {
                    throw new Error(text);
                }
                if (!Roles.success) throw new Error(Roles.msg || "Error en el servidor");
                const select = document.getElementById('RolTrabajador');
                select.innerHTML = '<option value="">Seleccione un rol</option>';
                Roles.data.forEach(({ IdRol, NombreRol }) => {
                    const option = document.createElement('option');
                    option.value = IdRol;
                    option.textContent = NombreRol;
                    select.appendChild(option);
                });
                resolve();
            })
            .catch(error => {
                Swal.fire({
                    title: "Error",
                    html: error.message || String(error),
                    icon: "error",
                })
            })
    })
}
// inicio funcion cargar roles en select para formuladio de nuevo o editar





// inicio editar trabajador (llena el formulario ocn los datos del trabajdor)
async function EditarTrabajador(id) {
    const url = `${BASE_URL}/controladores/trabajadores/TrabajadoresControlador.php?action=BuscarTrabajador&id=${id}`;
    try {
        const response = await fetch(url);
        const text = await response.text(); // no asumimos que es JSON todavía
        let result;
        try {
            result = JSON.parse(text); // Intentamos parsear
        } catch {
            throw new Error(text); // Si no es JSON válido, es HTML (probablemente error de PHP)
        }
        if (!result.success) throw new Error(result.msg || "Error en el servidor");
        document.getElementById('FormularioTrabajador').reset();
        await cargarRolesSelect();
        const trabajador = result.data;
        document.getElementById('IdTrabajador').value = trabajador.IdUsuario;
        document.getElementById('NombresTrabajador').value = trabajador.NombresUsuario;
        document.getElementById('ApellidosTrabajador').value = trabajador.ApellidosUsuario;
        document.getElementById('DNITrabajador').value = trabajador.DNIUsuario;
        document.getElementById('TelefonoTrabajador').value = trabajador.TelefonoUsuario;
        document.getElementById('CorreoTrabajador').value = trabajador.CorreoUsuario;
        document.getElementById('UsernameTrabajador').value = trabajador.UsernameUsuario;
        document.getElementById('RolTrabajador').value = trabajador.RolUsuario;
        document.getElementById('ModalFormLabelTrabajador').innerText = 'Editar Trabajador';
        $('#ModalFormTrabajador').modal('show');
    } catch (error) {
        Swal.fire({
            title: "Error",
            html: error.message || String(error), // si viene con mensaje, lo usamos
            icon: "error",
        });
    }
}
// fin  editar trabajador (llena el formulario ocn los datos del trabajdor)





// inicio eliminar trabajador 
function EliminarTrabajador(id) {
    Swal.fire({
        title: "Eliminar Trabajador",
        text: "¿Realmente quiere eliminar al Trabajador?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`${BASE_URL}/controladores/trabajadores/TrabajadoresControlador.php?action=EliminarTrabajador`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id }),
            })
                .then(response => response.text())
                .then(text => {
                    let result;
                    try {
                        result = JSON.parse(text); // Intentamos parsear
                    } catch {
                        throw new Error(text); // Si no es JSON válido, es HTML (probablemente error de PHP)
                    }
                    if (!result.success) throw result.msg || "Error en el servidor";
                    Swal.fire('¡Eliminado!', 'El trabajador ha sido eliminado correctamente.', 'success')
                        .then(() => CargarDatosTrabajadores());
                })
                .catch(error => {
                    Swal.fire({
                        title: "Error",
                        html: error.message || String(error),
                        icon: "error",
                    })
                })
        }
    });
}
// fin eliminar trabajador 





// inicio funcionesde open and close menu opciones
function AbrirConfiguracion() {
    const menu = document.getElementById('MenuConfiguracion');
    if (menu.style.display === 'none' || menu.style.display === '') {
        menu.style.display = 'block';
        document.addEventListener('click', CerrarClickFuera);
    } else {
        menu.style.display = 'none';
        document.removeEventListener('click', CerrarClickFuera);
    }
}
function CerrarClickFuera(event) {
    const menu = document.getElementById('MenuConfiguracion');
    const button = document.getElementById('BotonConfiguracion');
    if (!menu.contains(event.target) && !button.contains(event.target)) {
        menu.style.display = 'none';
        document.removeEventListener('click', CerrarClickFuera);
    }
}
// fin funcionesde open and close menu opciones








// inicio Función para cargar los roles desde el servidor
let estadoInicialRoles = {}; // Guarda el estado inicial de los roles
function CargarRoles() {
    fetch(`${BASE_URL}/controladores/trabajadores/TrabajadoresControlador.php?action=CargarRoles`, { method: 'GET' })
        .then(response => response.json())
        .then(({ success, data, msg }) => {
            if (!success) throw new Error(msg || 'Error al cargar los roles');
            const rolesList = document.getElementById('ListaRoles');
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
function GuardarConfiguracion() {
    const checkboxes = document.querySelectorAll('#ListaRoles .form-check-input');
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
        fetch(`${BASE_URL}/controladores/trabajadores/TrabajadoresControlador.php?action=GuardarConfiguracion`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ roles: rolesNuevos })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Éxito", "Roles activados correctamente.", "success");
                    CargarRoles();
                    CargarDatosTrabajadores();
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
                CargarDatosTrabajadores(); // Recargar la tabla
                CargarRoles(); // Recargar los roles para reflejar los cambios
            } else {
                Swal.fire("Error", data.msg || "No se pudo eliminar la relación.", "error");
            }
        })
        .catch(() => Swal.fire("Error", "Hubo un problema al eliminar la relación.", "error"));
}
// fin Función para eliminar la configuración


