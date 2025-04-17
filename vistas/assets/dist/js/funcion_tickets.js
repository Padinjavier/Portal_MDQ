// C:\wamp64\www\Portal_MDQ\vistas\assets\dist\js\funcion_tickets.js
// INICIO FUNCIONAMIENTO DE TABLA Tickets
$(document).ready(function () {
    const table = $('#TablaTickets').DataTable({
        "language": {
            "url": `${BASE_URL}/vistas/assets/dist/js/Spanish.json`
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
        "autoWidth": true, // Deshabilitar ajuste automático de ancho
        "responsive": true, // Hacer la tabla responsive
        "dom": 'flrtip', // Posición de los elementos de la tabla
        "bDestroy": true,
        "iDisplayLength": 10,
        "lengthMenu": [5, 10, 25, 50, 100], // Opciones de longitud de página
        "order": [[0, "desc"]],
    });
    CargarDatosTickets();
    SelectProblemasySubproblemas();
    SelectNombre();
});
// FIN FUNCIONAMIENTO DE TABLA Tickets


$(document).ready(function () {
    const jsonPath = `${BASE_URL}/vistas/assets/dist/js/datos.json`;
    fetch(jsonPath)
        .then(res => res.json())
        .then(data => {
            const $select = $('#DepartamentoTicket');
            data.sub_areas.forEach(area => {
                if (!area.sub_areas) return;
                area.sub_areas.forEach(gerenciaObj => {
                    const gerencia = gerenciaObj.Gerencia;
                    if (!gerencia) return;
                    $select.append(`<option style="color:rgb(0, 0, 0); font-weight: bold;" value="${gerencia}">${gerencia}</option>`);
                    if (gerenciaObj.sub_areas) {
                        gerenciaObj.sub_areas.forEach(nivel => {
                            const tipo = Object.keys(nivel)[0];
                            const nombre = nivel[tipo];
                            if (tipo === "Subgerencia") {
                                $select.append(`<option style="color:rgb(0, 0, 0);"  value="${nombre} > ${gerencia}">${nombre}</option>`);
                            } else if (tipo === "Unidad") {
                                $select.append(`<option style="color: rgb(0, 0, 0); font-style: italic;" value="${nombre} > ${gerencia}">${nombre}</option>`);
                            }
                        });
                    }
                });
            });
            $select.attr("size", 1); // mostrar como dropdown normal
            $select.on("change", function () {
                $(this).blur(); // oculta menú al elegir
            });
        })
        .catch(err => console.error("Error al cargar JSON:", err));
});

// Descripción summernote 
$(document).ready(function() {
    $('#editor').summernote({
        placeholder: 'Escribe aquí tu texto...',
        height: 150,
    });
});



// INICIO COMPLETAR TABLE Tickets 
window.CargarDatosTickets = function () {
    fetch(`${BASE_URL}/controladores/tickets/TicketsControlador.php?action=CargarDatosTickets`, { method: 'GET' })
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (!data.success) throw data.msg || "Error en el servidor";
                const table = $('#TablaTickets').DataTable();
                table.clear();
                data.data?.forEach(Ticket => {
                    let statusLabel = '';
                    switch (parseInt(Ticket.StatusTicket)) {
                        case 1:
                            statusLabel = '<span class="badge badge-primary">Abierto</span>';
                            break;
                        case 2:
                            statusLabel = '<span class="badge badge-info">En Atención</span>';
                            break;
                        case 3:
                            statusLabel = '<span class="badge badge-success">Resuelto</span>';
                            break;
                        case 4:
                            statusLabel = '<span class="badge badge-warning">Reabierto</span>';
                            break;
                        case 5:
                            statusLabel = '<span class="badge badge-dark">Cerrado</span>';
                            break;
                        default:
                            statusLabel = '<span class="badge badge-danger">Eliminado</span>';
                    }
                    table.row.add([
                        Ticket.CodTicket,
                        Ticket.trabajador,
                        Ticket.DepartamentoTicket,
                        Ticket.NombreProblema,
                        Ticket.NombreSubproblema,
                        Ticket.DataCreateTicket,
                        statusLabel,
                        `<div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown"><i class="fas fa-cog"></i> Opciones</button>
                        <div class="dropdown-menu">
                            <button class="btn dropdown-item text-success bg-transparent" onclick="VerTicket(${Ticket.IdTicket})"><i class="fas fa-eye"></i> Ver</button>
                            <button class="btn dropdown-item text-warning  bg-transparent" onclick="EditarTicket(${Ticket.IdTicket})"><i class="fas fa-edit"></i> Editar</button>
                            <button class="btn dropdown-item text-danger bg-transparent" onclick="EliminarTicket(${Ticket.IdTicket})"><i class="fas fa-trash"></i> Eliminar</button>
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
// FIN COMPLETAR TABLE Tickets





// INICIO EDITAR Ticket
function openModal() {
    document.getElementById('FormularioTicket').reset();
    document.getElementById('IdTicket').value = "";
    document.getElementById('ModalFormLabelTicket').innerText = 'Nuevo Ticket';
    $('#ModalFormTicket').modal('show');
}
// FIN EDITAR Ticket




// inicio funcion cargar roles en select para formuladio de nuevo o editar
let subproblemasMap = {};
function SelectProblemasySubproblemas() {
    return fetch(`${BASE_URL}/controladores/tickets/TicketsControlador.php?action=SelectProblemasySubproblemas`)
        .then(res => res.json())
        .then(response => {
            if (!response.success) throw new Error(response.msg);
            const selectProblema = document.getElementById('IdProblemaTicket');
            const selectSubproblema = document.getElementById('IdSubproblemaTicket');
            selectProblema.innerHTML = '<option value="">Seleccione un Problema</option>';
            selectSubproblema.innerHTML = '<option value="">Seleccione un Subproblema</option>';
            const problemasMap = {};
            response.data.forEach(item => {
                if (!problemasMap[item.IdProblema]) {
                    problemasMap[item.IdProblema] = {
                        nombre: item.NombreProblema,
                        subproblemas: []
                    };
                }
                if (item.IdSubproblema) {
                    problemasMap[item.IdProblema].subproblemas.push({
                        id: item.IdSubproblema,
                        nombre: item.NombreSubproblema
                    });
                }
            });
            subproblemasMap = problemasMap;
            for (const id in problemasMap) {
                const option = document.createElement('option');
                option.value = id;
                option.textContent = problemasMap[id].nombre;
                selectProblema.appendChild(option);
            }
            selectProblema.addEventListener('change', () => {
                const selectedId = selectProblema.value;
                const subproblemas = subproblemasMap[selectedId]?.subproblemas || [];
                selectSubproblema.innerHTML = '<option value="">Seleccione un Subproblema</option>';
                subproblemas.forEach(sp => {
                    const option = document.createElement('option');
                    option.value = sp.id;
                    option.textContent = sp.nombre;
                    selectSubproblema.appendChild(option);
                });
            });
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message
            });
        });
}
// inicio funcion cargar roles en select para formuladio de nuevo o editar



function SelectNombre() {
    return fetch(`${BASE_URL}/controladores/tickets/TicketsControlador.php?action=SelectNombre`)
        .then(res => res.json())
        .then(response => {
            if (!response.success) throw new Error(response.msg);
            const select = document.getElementById('IdUsuarioCreadorTicket');
            select.innerHTML = ''; // Limpiar opciones
            if(response.data.length ==1){
                select.disabled = true;
            }else{
                select.innerHTML = '<option value="">Seleccione un nombre</option>';
            }
            response.data.forEach(usuario => {
                const option = document.createElement('option');
                option.value = usuario.IdUsuario;
                option.textContent = usuario.NombreCompleto;
                select.appendChild(option);
            });
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message
            });
        });
}



















































// inicio guardar Ticket
function GuardarTicket() {
    const formData = new FormData(document.getElementById('FormularioTicket'));
    const accion = document.getElementById('IdTicket').value ? 'EditarTicket' : 'GuardarTicket';
    fetch(`${BASE_URL}/controladores/tickets/TicketsControlador.php?action=${accion}`, {
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
                    $('#ModalFormTicket').modal('hide');
                    CargarDatosTickets();
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
// inicio guardar Ticket





// INICIO VER Ticket
function VerTicket(id) {
    fetch(`${BASE_URL}/controladores/tickets/TicketsControlador.php?action=BuscarTicket&id=${id}`, { method: 'GET' })
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (!data.success) throw data.msg || "Error en el servidor";
                const Ticket = data.data;
                document.getElementById('ViewNombresTicket').textContent = Ticket.NombresUsuario;
                document.getElementById('ViewApellidosTicket').textContent = Ticket.ApellidosUsuario;
                document.getElementById('ViewDNITicket').textContent = Ticket.DNIUsuario;
                document.getElementById('ViewTelefonoTicket').textContent = Ticket.TelefonoUsuario;
                document.getElementById('ViewCorreoTicket').textContent = Ticket.CorreoUsuario;
                document.getElementById('ViewUsernameTicket').textContent = Ticket.UsernameUsuario;
                $('#ModalViewTicket').modal('show');
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
// FIN VER Ticket









// inicio editar Ticket (llena el formulario ocn los datos del trabajdor)
async function EditarTicket(id) {
    const url = `${BASE_URL}/controladores/tickets/TicketsControlador.php?action=BuscarTicket&id=${id}`;
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
        document.getElementById('FormularioTicket').reset();
        await cargarRolesSelect();
        const Ticket = result.data;
        document.getElementById('IdTicket').value = Ticket.IdUsuario;
        document.getElementById('NombresTicket').value = Ticket.NombresUsuario;
        document.getElementById('ApellidosTicket').value = Ticket.ApellidosUsuario;
        document.getElementById('DNITicket').value = Ticket.DNIUsuario;
        document.getElementById('TelefonoTicket').value = Ticket.TelefonoUsuario;
        document.getElementById('CorreoTicket').value = Ticket.CorreoUsuario;
        document.getElementById('UsernameTicket').value = Ticket.UsernameUsuario;
        document.getElementById('RolTicket').value = Ticket.RolUsuario;
        document.getElementById('ModalFormLabelTicket').innerText = 'Editar Ticket';
        $('#ModalFormTicket').modal('show');
    } catch (error) {
        Swal.fire({
            title: "Error",
            html: error.message || String(error), // si viene con mensaje, lo usamos
            icon: "error",
        });
    }
}
// fin  editar Ticket (llena el formulario ocn los datos del trabajdor)





// inicio eliminar Ticket 
function EliminarTicket(id) {
    Swal.fire({
        title: "Eliminar Ticket",
        text: "¿Realmente quiere eliminar al Ticket?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`${BASE_URL}/controladores/tickets/TicketsControlador.php?action=EliminarTicket`, {
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
                    Swal.fire('¡Eliminado!', 'El Ticket ha sido eliminado correctamente.', 'success')
                        .then(() => CargarDatosTickets());
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
// fin eliminar Ticket 




// inicio Función para cargar los roles desde el servidor
let estadoInicialRoles = {}; // Guarda el estado inicial de los roles
function CargarRoles() {
    fetch(`${BASE_URL}/controladores/tickets/TicketsControlador.php?action=CargarRoles`, { method: 'GET' })
        .then(response => response.json())
        .then(({ success, data, msg }) => {
            if (!success) throw new Error(msg || 'Error al cargar los roles');
            const rolesList = document.getElementById('ListaRoles');
            rolesList.innerHTML = ''; // Limpiar lista previa
            estadoInicialRoles = {}; // Resetear el estado inicial
            data.forEach(({ IdRol, NombreRol, NombreModulo }) => {
                const asignadoATickets = NombreModulo === "Tickets";
                const noAsignado = NombreModulo === "No asignado";
                const asignadoAOtroModulo = !noAsignado && !asignadoATickets;
                const checked = asignadoATickets || asignadoAOtroModulo;
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




