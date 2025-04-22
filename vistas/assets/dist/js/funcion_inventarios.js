// C:\wamp64\www\Portal_MDQ\vistas\assets\dist\js\funcion_tickets.js
// INICIO FUNCIONAMIENTO DE TABLA Tickets
$(document).ready(function () {
    const table = $('#TablaInventarios').DataTable({
        "language": {
            "url": `${BASE_URL}/vistas/assets/dist/js/Spanish.json`
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
        "autoWidth": true, // Deshabilitar ajuste automático de ancho
        "responsive": true, // Hacer la tabla responsive
        "dom": 'flrtip', // Posición de los elementos de la tabla
        "bDestroy": true,
        "iDisplayLength": 10,
        "lengthMenu": [5, 10, 25, 50, 100], // Opciones de longitud de página
        "order": [[0, "desc"]],
    });
    CargarDatosInventario();
});
// FIN FUNCIONAMIENTO DE TABLA Tickets

// Descripción summernote 
$(document).ready(function () {
    $('#DescripcionInventario').summernote({
        placeholder: 'Escribe aquí tu texto...',
        height: 200,
    });
});

// INICIO COMPLETAR TABLE inventarios 
window.CargarDatosInventario = function () {
    fetch(`${BASE_URL}/controladores/inventarios/InventariosControlador.php?action=CargarDatosInventarios`)
        .then(res => res.json())
        .then(({ success, data, msg }) => {
            if (!success) {
                return Swal.fire({
                    title: "Error",
                    html: msg || "Error en el servidor",
                    icon: "error",
                });
            }
            const table = $('#TablaInventarios').DataTable();
            table.clear();
            data?.forEach(Inventario => {
                table.row.add([
                    Inventario.IdInventario,
                    Inventario.NombreInventario,
                    Inventario.CodigoInventario,
                    `<div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown"><i class="fas fa-cog"></i> Opciones</button>
                        <div class="dropdown-menu">
                            <button class="btn dropdown-item text-success bg-transparent" onclick="VerInventario(${Inventario.IdInventario})"><i class="fas fa-eye"></i> Ver</button>
                            <button class="btn dropdown-item text-warning bg-transparent" onclick="EditarInventario(${Inventario.IdInventario})"><i class="fas fa-edit"></i> Editar</button>
                            <button class="btn dropdown-item text-danger bg-transparent" onclick="EliminarInventario(${Inventario.IdInventario})"><i class="fas fa-trash"></i> Eliminar</button>
                        </div>
                    </div>`
                ]).draw(false);
            });
        });
};
// FIN COMPLETAR TABLE inventarios



// INICIO EDITAR Ticket
function openModal() {
    document.getElementById('FormularioInventario').reset();
    document.getElementById('IdInventario').value = "";
    $('#DescripcionInventario').summernote('code', '');
    document.getElementById('ModalFormLabelInventario').innerText = 'Nuevo Inventario';
    $('#ModalFormInventario').modal('show');
}
// FIN EDITAR Ticket












// inicio guardar Inventario
function GuardarInventario() {
    const formData = new FormData(document.getElementById('FormularioInventario'));
    const accion = document.getElementById('IdInventario').value ? 'EditarInventario' : 'GuardarInventario';
    document.getElementById('IdUsuarioCreadorInventario').disabled = false;
    fetch(`${BASE_URL}/controladores/inventarios/InventariosControlador.php?action=${accion}`, {
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
                    $('#ModalFormInventario').modal('hide');
                    CargarDatosInventarios();
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
// inicio guardar Inventario


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
    fetch(`${BASE_URL}/controladores/inventarios/InventariosControlador.php?action=BuscarTicket&id=${id}`)
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
            set('ViewSoporteTicket', Ticket.soporte || 'No asignado');
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
    const url = `${BASE_URL}/controladores/inventarios/InventariosControlador.php?action=BuscarTicket&id=${id}`;
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
        $('#DescripcionTicket').summernote('code', Ticket.DescripcionTicket);
        console.log(Ticket.DescripcionTicket)
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
            fetch(`${BASE_URL}/controladores/inventarios/InventariosControlador.php?action=EliminarTicket`, {
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







