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
        "order": [[5, "desc"]],
    });


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



    $('.DescripcionTicket').summernote({
        placeholder: 'Escribe aquí tu texto...',
        height: 150,
    });


    CargarDatosTickets();
    SelectProblemasySubproblemas();
    SelectNombre();
    verificarAgregarSelectSoporte();

});
// FIN FUNCIONAMIENTO DE TABLA Tickets




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
                table.row.add([
                    ticket.CodTicket,
                    ticket.trabajador,
                    ticket.DepartamentoTicket,
                    ticket.NombreProblema,
                    ticket.NombreSubproblema,
                    ticket.DataCreateTicket,
                    statusLabel,
                    ticket.opciones
                ]).draw(false);
            });
        });
};
// FIN COMPLETAR TABLE Tickets





// INICIO EDITAR Ticket
function openModal() {
    const sectionDescripcionTicket = document.getElementById('sectionDescripcionTicket');
    sectionDescripcionTicket.innerHTML = '';
    const newTextareaContainer = document.createElement('div');
    newTextareaContainer.className = 'col-md-12';
    newTextareaContainer.innerHTML = `
        <div class="form-group">
            <label for="DescripcionTicket_0">Descripción</label>
            <textarea id="DescripcionTicket_0" class="form-control summernote" name="DescripcionTicket_0" data-idcomentario=""></textarea>
        </div>
    `;
    sectionDescripcionTicket.appendChild(newTextareaContainer);
    $('#DescripcionTicket_0').summernote({
        height: 150,
        placeholder: 'Escriba aquí...'
    });
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
    const form = document.getElementById('FormularioTicket');
    const formData = new FormData(form);
    const accion = document.getElementById('IdTicket').value ? 'EditarTicket' : 'GuardarTicket';

    const total = parseInt(document.getElementById('totalcomentarios').value || 0);
    const comentarios = [];

    for (let i = 0; i < total; i++) {
        const textarea = document.getElementById(`DescripcionTicket_${i}`);
        if (textarea) {
            const idComentario = textarea.getAttribute('data-idcomentario');
            const contenido = $(`#DescripcionTicket_${i}`).summernote('code');
            comentarios.push({ IdComentario: idComentario, Comentario: contenido });
        }
    }

    // Agrega el array como JSON string
    formData.append('comentarios', JSON.stringify(comentarios));

    document.getElementById('IdUsuarioCreadorTicket').disabled = false;

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
                    return;
                }
                Swal.fire("Éxito", data.msg, "success").then(() => {
                    $('#ModalFormTicket').modal('hide');
                    CargarDatosTickets();
                });
            } catch {
                throw text;
            }
        })
        .catch(error => Swal.fire({
            title: "Error",
            html: typeof error === 'string' ? error : "Error desconocido",
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

const colorMap = {
    1: 'bg-primary text-white',
    2: 'bg-info text-white',
    3: 'bg-success text-white',
    4: 'bg-warning text-dark',
    5: 'bg-dark text-white',
    6: 'bg-secondary text-white'
};


// INICIO VER Ticket
function VerTicket(id) {
    fetch(`${BASE_URL}/controladores/tickets/TicketsControlador.php?action=BuscarTicket&id=${id}`)
        .then(res => res.json())
        .then(({ success, data, comentarios, msg }) => {
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
            set('ViewStatusTicket', getStatusBadge(Ticket.StatusTicket), true);
            const contenedorComentarios = document.getElementById("ListaComentariosTicket");
            contenedorComentarios.innerHTML = ""; // limpiar
            if (comentarios && comentarios.length > 0) {
                comentarios.forEach(c => {
                    contenedorComentarios.innerHTML += `
                        <div class="mb-2 p-2 border rounded bg-light">
                            <strong>${c.ComentadoPor}</strong> 
                            <small class="text-muted float-end">${c.FechaComentario}</small>
                            <div>${c.Comentario}</div>
                        </div>
                    `;
                });
                document.getElementById('BloqueFormularioComentario').classList.add('d-none');
            } else {
                contenedorComentarios.innerHTML = `<div class="text-muted">Este ticket no tiene comentarios.</div>`;
            }
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

        const selectProblema = document.getElementById('IdProblemaTicket');
        const selectSubproblema = document.getElementById('IdSubproblemaTicket');
        const subproblemas = subproblemasMap[Ticket.IdProblemaTicket]?.subproblemas || [];
        selectSubproblema.innerHTML = '<option value="">Seleccione un Subproblema</option>';
        subproblemas.forEach(sp => {
            const option = document.createElement('option');
            option.value = sp.id;
            option.textContent = sp.nombre;
            selectSubproblema.appendChild(option);
        });

        document.getElementById('IdSubproblemaTicket').value = Ticket.IdSubproblemaTicket;
        document.getElementById('IdUsuarioSoporteTicket').value = Ticket.IdUsuarioSoporteTicket;
        // Limpiar y generar nuevas textareas con Summernote
        const sectionDescripcionTicket = document.getElementById('sectionDescripcionTicket');
        const totalcomentarios = document.getElementById('totalcomentarios');
        sectionDescripcionTicket.innerHTML = '';
        const ComentarioTicket = result.comentarios || [];

        ComentarioTicket.forEach((Comentario, index) => {
            const textareaId = `DescripcionTicket_${index}`;
            const textarea = document.createElement('textarea');
            textarea.id = textareaId;
            textarea.className = 'form-control summernote';
            textarea.name = `DescripcionTicket_${index}`;
            textarea.setAttribute('data-idcomentario', Comentario.IdComentario);
            sectionDescripcionTicket.appendChild(textarea);

            $(`#${textareaId}`).summernote({
                height: 150,
                placeholder: 'Escriba aquí...'
            }).summernote('code', Comentario.Comentario);
        });

        // Guardar total de comentarios generados
        totalcomentarios.value = ComentarioTicket.length;

        document.getElementById('ModalFormLabelTicket').innerText = 'Editar Ticket';
        $('#ModalFormTicket').modal('show');
    } catch (error) {
        Swal.fire({
            title: "Error",
            html: error.message || String(error),
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

// inicio editar Ticket (llena el formulario ocn los datos del trabajdor)
function ComentariosTicket(id) {
    fetch(`${BASE_URL}/controladores/tickets/TicketsControlador.php?action=BuscarTicket&id=${id}`)
        .then(res => res.json())
        .then(({ success, data, comentarios, msg }) => {
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
            document.getElementById('IdTicketComent').value = Ticket.IdTicket;
            set('ViewCodigoTicket', Ticket.CodTicket);
            set('ViewTrabajadorTicket', Ticket.Trabajador);
            set('ViewDepartamentoTicket', Ticket.DepartamentoTicket);
            set('ViewProblemaTicket', Ticket.NombreProblema);
            set('ViewSubproblemaTicket', Ticket.NombreSubproblema);
            set('ViewSoporteTicket', Ticket.Soporte || 'No asignado');
            set('ViewDataCreateTicket', Ticket.DataCreateTicket);
            set('ViewDataUpdateTicket', Ticket.DataUpdateTicket);
            document.getElementById('ViewStatusTicket').value = Ticket.StatusTicket;
            const contenedorComentarios = document.getElementById("ListaComentariosTicket");
            contenedorComentarios.innerHTML = ""; // limpiar
            if (comentarios && comentarios.length > 0) {
                comentarios.forEach(c => {
                    contenedorComentarios.innerHTML += `
                        <div class="mb-2 p-2 border rounded bg-light">
                            <strong>${c.ComentadoPor}</strong> 
                            <small class="text-muted float-end">${c.FechaComentario}</small>
                            <div>${c.Comentario}</div>
                        </div>
                    `;
                });
            } else {
                contenedorComentarios.innerHTML = `<div class="text-muted">Este ticket no tiene comentarios.</div>`;
            }
            document.getElementById('BloqueFormularioComentario').classList.remove('d-none');
            $('#ModalViewTicket').modal('show');
        });
}

function GuardarComentarioTicket() {
    const IdTicketComent = document.getElementById('IdTicketComent').value;
    const ComentarioTexto = document.getElementById('ComentarioTexto').value.trim();
    const ViewStatusTicket = document.getElementById('ViewStatusTicket').value;
    if (!ComentarioTexto) {
        return Swal.fire("Advertencia", "El comentario no puede estar vacío", "warning");
    }
    const formData = new FormData();
    formData.append("IdTicketComent", IdTicketComent); // guarda este ID al cargar el modal
    formData.append("ComentarioTexto", ComentarioTexto);
    formData.append("ViewStatusTicket", ViewStatusTicket);
    fetch(`${BASE_URL}/controladores/tickets/TicketsControlador.php?action=GuardarComentarioTicket`, {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (!data.success) {
                    Swal.fire("Error", data.msg || "Error en el servidor", "error");
                    return;
                }
                Swal.fire("Éxito", data.msg, "success");
                $('#ComentarioTexto').summernote('code', '');
                ComentariosTicket(IdTicketComent);
                CargarDatosTickets();
                console.log("Comentario guardado correctamente");
            } catch {
                throw text;
            }
        })
        .catch(error => Swal.fire({
            title: "Error",
            html: typeof error === 'string' ? error : "Error desconocido",        // Si no es JSON válido, mostrar el error crudo (HTML)
            icon: "error",
        }));
}


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