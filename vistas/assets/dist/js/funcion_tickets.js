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
    verificarAgregarSelectSoporte();
});
// FIN FUNCIONAMIENTO DE TABLA Tickets


// funcion para rellenar select de departamentos
$(document).ready(function () {
    const jsonPath = `${BASE_URL}/vistas/assets/dist/js/datos.json`;
    fetch(jsonPath)
        .then(res => {
            if (!res.ok) throw new Error("No se pudo cargar el archivo JSON.");
            return res.json();
        })
        .then(data => {
            const $select = $('#DepartamentoTicket');
            $select.empty(); // Limpia opciones anteriores si las hay
            $select.append('<option value="">Seleccione una opción</option>');
            data.sub_areas?.forEach(area => {
                area.sub_areas?.forEach(gerenciaObj => {
                    const gerencia = gerenciaObj.Gerencia;
                    if (!gerencia) return;
                    // Gerencia (negrita)
                    $select.append(`<option style="font-weight:bold; color:#000;" value="${gerencia}">${gerencia}</option>`);
                    gerenciaObj.sub_areas?.forEach(nivel => {
                        const tipo = Object.keys(nivel)[0];
                        const nombre = nivel[tipo];
                        // Subgerencia (normal)
                        if (tipo === "Subgerencia") {
                            $select.append(`<option style="padding-left:10px; color:#000;" value="${nombre}">${nombre}</option>`);
                        }
                        // Unidad (itálica)
                        if (tipo === "Unidad") {
                            $select.append(`<option style="padding-left:20px; font-style:italic; color:#000;" value="${nombre}">${nombre}</option>`);
                        }
                    });
                });
            });
            $select.attr("size", 1);
            $select.on("change", function () {
                $(this).blur(); // Oculta lista tras seleccionar
            });
        })
        .catch(err => {
            Swal.fire({
                title: "Error",
                text: "No se pudo cargar la lista de departamentos.",
                icon: "error",
            });
        });
});
// funcion para rellenar select de departamentos

// Descripción summernote 
$(document).ready(function () {
    $('#DescripcionTicket').summernote({
        placeholder: 'Escribe aquí tu texto...',
        height: 150,
    });
});

// Gestión de opciones
function generarOpciones(ticket) {
    const esAdmin = (Login_RolUsuario == 1);
    const miIdUsuario = Login_IdUsuario;
    // Definir los botones disponibles (no se crean de nuevo)
    const btnVer = `<button class="btn dropdown-item text-success bg-transparent" onclick="VerTicket(${ticket.IdTicket})"><i class="fas fa-eye"></i> Ver</button>`;
    const btnAtender = `<button class="btn dropdown-item text-info bg-transparent" onclick="AtenderTicket(${ticket.IdTicket})"><i class="bi bi-journal-check"></i> Atender</button>`;
    const btnEditar = `<button class="btn dropdown-item text-warning bg-transparent" onclick="EditarTicket(${ticket.IdTicket})"><i class="fas fa-edit"></i> Editar</button>`;
    const btnEliminar = `<button class="btn dropdown-item text-danger bg-transparent" onclick="EliminarTicket(${ticket.IdTicket})"><i class="fas fa-trash"></i> Eliminar</button>`;
    const btnComentarios = `<button class="btn dropdown-item text-primary bg-transparent" onclick="ComentariosTicket(${ticket.IdTicket})"><i class="fas fa-comments"></i> Comentarios</button>`;
    const soyCreador = ticket.IdUsuarioCreadorTicket == miIdUsuario;
    const soySoporteAsignado = ticket.IdUsuarioSoporteTicket == miIdUsuario;
    const ticketSinAsignar = ticket.IdUsuarioSoporteTicket == null;
    let opciones = '';
    if (esAdmin) {
        opciones += btnVer;
        if (ticketSinAsignar) {
            opciones += btnAtender;
        }
        opciones += btnEditar;
        opciones += btnEliminar;
        opciones += btnComentarios;
    } else {
        if (soyCreador) {
            opciones += btnVer;
            opciones += btnComentarios;
            if (ticketSinAsignar) {
                opciones += btnEliminar;
            }
        } else if (soySoporteAsignado) {
            opciones += btnVer;
            opciones += btnComentarios;
        } else if (ticketSinAsignar) {
            opciones += btnAtender;
        }
    }
    return `
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown">
                <i class="fas fa-cog"></i> Opciones
            </button>
            <div class="dropdown-menu">
                ${opciones}
            </div>
        </div>
    `;
}
// Fin gestión de opciones


// INICIO COMPLETAR TABLE Tickets  
window.CargarDatosTickets = function () {
    fetch(`${BASE_URL}/controladores/tickets/TicketsControlador.php?action=CargarDatosTickets`)
        .then(res => res.json())
        .then(({ success, data, msg }) => {
            if (!success) {
                return Swal.fire({
                    title: "Error",
                    html: msg || "Error en el servidor",
                    icon: "error",
                });
            }
            const table = $('#TablaTickets').DataTable();
            table.clear();
            data?.forEach(ticket => {
                var statusLabel = "";
                if (ticket.IdUsuarioSoporteTicket != null) {
                    statusLabel = getStatusBadge(parseInt(ticket.StatusTicket));
                } else {
                    statusLabel = "<span class='badge badge-secondary'>SIN ASIGNAR</span>"
                }
                const opcionesBotones = generarOpciones(ticket); // AQUÍ

                table.row.add([
                    ticket.CodTicket,
                    ticket.trabajador,
                    ticket.DepartamentoTicket,
                    ticket.NombreProblema,
                    ticket.NombreSubproblema,
                    ticket.DataCreateTicket,
                    statusLabel,
                    opcionesBotones
                ]).draw(false);
            });
        });
};
// FIN COMPLETAR TABLE Tickets





// INICIO EDITAR Ticket
function openModal() {
    document.getElementById('FormularioTicket').reset();
    document.getElementById('IdTicket').value = "";
    $('#DescripcionTicket').summernote('code', '');
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
            if (response.data.length != 1) {
                select.innerHTML = '<option value="">Seleccione un soporte</option>';
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
    document.getElementById('IdUsuarioCreadorTicket').disabled = false;
    fetch(`${BASE_URL}/controladores/tickets/TicketsControlador.php?action=${accion}`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(text => {
        console.log("🟡 Revisando FormData:");

for (let pair of formData.entries()) {
    console.log(`${pair[0]}: ${pair[1]}`);
}
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


function getStatusBadge(status) {
    const labelMap = {
        1: ['primary', 'Abierto'],
        2: ['info', 'En Atención'],
        3: ['success', 'Resuelto'],
        4: ['warning', 'Reabierto'],
        5: ['dark', 'Cerrado'],
        6: ['secondary', 'Desestimado']
    };
    const [color, label] = labelMap[status] || ['danger', 'Eliminado'];
    return `<span class="badge badge-${color}">${label}</span>`;
}



// INICIO VER Ticket
function VerTicket(id) {
    fetch(`${BASE_URL}/controladores/tickets/TicketsControlador.php?action=BuscarTicket&id=${id}`)
        .then(res => res.json())
        .then(({ success, data, msg }) => {
            if (!success) {
                return Swal.fire({
                    title: "Error",
                    html: msg || "Error en el servidor",
                    icon: "error",
                });
            }
            const Ticket = data;
            const set = (id, val, html = false) => {
                document.getElementById(id)[html ? 'innerHTML' : 'textContent'] = val ?? 'No asignado';
            };
            set('ViewCodigoTicket', Ticket.CodTicket);
            set('ViewTrabajadorTicket', Ticket.Trabajador);
            set('ViewDepartamentoTicket', Ticket.DepartamentoTicket);
            set('ViewProblemaTicket', Ticket.NombreProblema);
            set('ViewSubproblemaTicket', Ticket.NombreSubproblema);
            set('ViewSoporteTicket', Ticket.Soporte || 'No asignado');
            set('ViewDataCreateTicket', Ticket.DataCreateTicket);
            set('ViewDataUpdateTicket', Ticket.DataUpdateTicket);
            set('ViewDescripcionTicket', Ticket.DescripcionTicket, true);
            set('ViewStatusTicket', getStatusBadge(Ticket.StatusTicket), true);
            $('#ModalViewTicket').modal('show');
        });
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
        const Ticket = result.data;
        document.getElementById('IdTicket').value = Ticket.IdTicket;
        document.getElementById('IdUsuarioCreadorTicket').value = Ticket.IdUsuarioCreadorTicket;
        document.getElementById('DepartamentoTicket').value = Ticket.DepartamentoTicket;
        document.getElementById('IdProblemaTicket').value = Ticket.IdProblemaTicket;
        // Simular el cambio del select de Problemas
        const selectProblema = document.getElementById('IdProblemaTicket');
        const selectSubproblema = document.getElementById('IdSubproblemaTicket');
        // Cargar subproblemas antes de asignar el subproblema seleccionado
        const subproblemas = subproblemasMap[Ticket.IdProblemaTicket]?.subproblemas || [];
        selectSubproblema.innerHTML = '<option value="">Seleccione un Subproblema</option>';
        subproblemas.forEach(sp => {
            const option = document.createElement('option');
            option.value = sp.id;
            option.textContent = sp.nombre;
            selectSubproblema.appendChild(option);
        });
        // Ahora sí asignar el subproblema
        document.getElementById('IdSubproblemaTicket').value = Ticket.IdSubproblemaTicket;
        document.getElementById('IdUsuarioSoporteTicket').value = Ticket.IdUsuarioSoporteTicket;
        $('#DescripcionTicket').summernote('code', Ticket.DescripcionTicket);
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
function verificarAgregarSelectSoporte() {
    if (Login_RolUsuario == 1) {
        return fetch(`${BASE_URL}/controladores/tickets/TicketsControlador.php?action=ListarSoportes`)
            .then(res => res.json())
            .then(response => {
                if (!response.success) throw new Error(response.msg);
                const select = document.getElementById('IdUsuarioSoporteTicket');
                select.innerHTML = ''; // Limpiar opciones
                if (response.data.length != 1) {
                    select.innerHTML = '<option value="">Seleccione un nombre</option>';
                }
                response.data.forEach(Soporte => {
                    const option = document.createElement('option');
                    option.value = Soporte.IdUsuario;
                    option.textContent = Soporte.NombreCompleto;
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

function AtenderTicket(id) {
    Swal.fire({
        title: "Atender Ticket",
        text: "¿Deseas atender este ticket? Se te asignará a ti.",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Sí, atender!",
        cancelButtonText: "No, cancelar!",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`${BASE_URL}/controladores/tickets/TicketsControlador.php?action=AtenderTicket`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    IdTicket: id,
                    IdSubproblemaTicket: Login_IdUsuario
                }),
            })
                .then(response => response.text())
                .then(text => {
                    let result;
                    try {
                        result = JSON.parse(text);
                    } catch {
                        throw new Error(text);
                    }
                    if (!result.success) throw result.msg || "Error en el servidor";
                    Swal.fire('¡Asignado!', 'El ticket ha sido asignado a ti y está listo para atender.', 'success')
                        .then(() => CargarDatosTickets());
                })
                .catch(error => {
                    Swal.fire({
                        title: "Error",
                        html: error.message || String(error),
                        icon: "error",
                    });
                });
        }
    });
}








