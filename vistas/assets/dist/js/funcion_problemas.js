// C:\wamp64\www\helpmdq\vistas\assets\dist\js\funcion_problemas.js
// inicio funcionamiento de tabla Problemas
$(document).ready(function () {
    const table = $('#tableProblemas').DataTable({
        "language": {
            "url": `${BASE_URL}/vistas/assets/dist/js/Spanish.json` // Asegúrate de que esta URL sea correcta
        },
        "columnDefs": [
            { "orderable": true, "targets": [0, 1,2] }, // Columnas ordenables
            { "orderable": false, "targets": [2] } // Columna de acciones no ordenable
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
    CargarTablaProblemas();
});
// fin funcionamiento de tabla Problemas





// inicio completar Problemas 
window.CargarTablaProblemas = function () {
    fetch(`${BASE_URL}/controladores/problemas/ProblemasControlador.php?action=CargarTablaProblemas`, { method: 'GET' })
        .then(response => response.json())
        .then(response => {
            if (!response.success) {
                throw new Error(response.msg || 'Error al cargar los datos');
            }
            const table = $('#tableProblemas').DataTable();
            table.clear(); // Limpiar los datos existentes
            if (response.data.length === 0) {
                table.draw(); // Redibujar la tabla para que se vea vacía
            }
            response.data.forEach(problema => {
                table.row.add([
                    problema.IdProblema,
                    problema.NombreProblema,
                    `<div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cog"></i> Opciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="btn dropdown-item text-success bg-transparent" href="#" onclick="verProblema(${problema.IdProblema})">
                                <i class="fas fa-eye"></i> Ver
                            </button>
                            <button class="btn dropdown-item text-warning  bg-transparent" href="#" onclick="editarProblema(${problema.IdProblema})">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button class="btn dropdown-item text-danger bg-transparent" href="#" onclick="eliminarProblema(${problema.IdProblema})">
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

// fin completar Problemas 





// inicio ver Problema
function verProblema(id) {
    fetch(`${BASE_URL}/controladores/problemas/ProblemasControlador.php?action=obtenerProblemaPorId&id=${id}`, { method: 'GET' })
        .then(response => response.json())
        .then(response => {
            if (!response.success) {
                throw new Error('Error en la solicitud: ' + response.statusText);
            }
            const problema = response.data;
            document.getElementById('viewNombre').textContent = problema.NombreProblema;
            $('#modalViewProblema').modal('show');
        })
        .catch(error => {
            Swal.fire("Error", error.message, "error");
        });
}
// fin ver Problema





// inicio eliminar Problema 
function eliminarProblema(id) {
    Swal.fire({
        title: "Eliminar Problema",
        text: "¿Realmente quiere eliminar el Problema?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`${BASE_URL}/controladores/problemas/ProblemasControlador.php?action=eliminarProblema`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('¡Eliminado!', 'El problema ha sido eliminado correctamente.', 'success')
                            .then(() => CargarTablaProblemas());
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
// fin eliminar Problema 





// inicio editar Problema
async function editarProblema(id) {
    try {
        const response = await fetch(`${BASE_URL}/controladores/problemas/ProblemasControlador.php?action=obtenerProblemaPorId&id=${id}`);
        const result = await response.json();
        if (result.success) {
            document.getElementById('formProblema').reset();
            // Llena el formulario
            document.getElementById('idProblema').value = result.data.IdProblema;
            document.getElementById('nombre').value = result.data.NombreProblema;
            document.getElementById('modalFormProblemaLabel').innerText = 'Editar Problema';
            // Muestra el modal
            $('#modalFormProblema').modal('show');
        } else {
            Swal.fire("Error", result.msg, "error");
        }
    } catch (error) {
        console.error('Error al obtener el problema:', error);
        Swal.fire("Error", "No se pudo obtener la información del problema.", "error");
    }
}
// fin editar problema





// inicio guardar problema
function guardarProblema() {
    const formData = new FormData(document.getElementById('formProblema'));
    const accion = document.getElementById('idProblema').value ? 'editarProblema' : 'crearProblema';
    fetch(`${BASE_URL}/controladores/problemas/ProblemasControlador.php?action=${accion}`, {
        method: 'POST',
        body: formData
    })
        .then(response => response.text()) // Obtener la respuesta como texto
        .then(text => {
            try {
                const data = JSON.parse(text); // Intentar parsear el JSON
                if (data.success) {
                    Swal.fire("Éxito", data.msg, "success").then(() => {
                        $('#modalFormProblema').modal('hide');
                        CargarTablaProblemas(); // Recargar la tabla
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


// fin guardar Problema





// inicio editar Problema
function openModal() {
    document.getElementById('formProblema').reset();
    document.getElementById('idProblema').value = "";
    document.getElementById('modalFormProblemaLabel').innerText = 'Nuevo Problema';
    $('#modalFormProblema').modal('show');
}
// fin editar Problema


