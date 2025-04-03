// C:\wamp64\www\helpmdq\vistas\assets\dist\js\funcion_subproblemas.js
// inicio funcionamiento de tabla Subproblemas
$(document).ready(function () {
    const table = $('#tableSubproblemas').DataTable({
        "language": {
            "url": `${BASE_URL}/vistas/assets/dist/js/Spanish.json` // Asegúrate de que esta URL sea correcta
        },
        "columnDefs": [
            { "orderable": true, "targets": [0, 1, 2, 3] }, // Columnas ordenables
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
    CargarTablaSubproblemas();
});
// fin funcionamiento de tabla Subproblemas





// inicio completar Subproblemas 
window.CargarTablaSubproblemas = function () {
    fetch(`${BASE_URL}/controladores/subproblemas/SubproblemasControlador.php?action=CargarTablaSubproblemas`, { method: 'GET' })
        .then(response => response.json())
        .then(response => {
            if (!response.success) {
                throw new Error(response.msg || 'Error al cargar los datos');
            }
            const table = $('#tableSubproblemas').DataTable();
            table.clear(); // Limpiar los datos existentes
            if (response.data.length === 0) {
                table.draw(); // Redibujar la tabla para que se vea vacía
            }
            response.data.forEach(subproblema => {
                table.row.add([
                    subproblema.IdSubproblema,
                    subproblema.NombreProblema,
                    subproblema.NombreSubproblema,
                    `<div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cog"></i> Opciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="btn dropdown-item text-success bg-transparent" href="#" onclick="verSubproblema(${subproblema.IdSubproblema})">
                                <i class="fas fa-eye"></i> Ver
                            </button>
                            <button class="btn dropdown-item text-warning  bg-transparent" href="#" onclick="editarSubproblema(${subproblema.IdSubproblema})">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button class="btn dropdown-item text-danger bg-transparent" href="#" onclick="eliminarSubproblema(${subproblema.IdSubproblema})">
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

// fin completar Subproblemas 





// inicio ver subproblema
function verSubproblema(id) {
    fetch(`${BASE_URL}/controladores/subproblemas/SubproblemasControlador.php?action=obtenerSubproblemaPorId&id=${id}`, { method: 'GET' })
        .then(response => response.json())
        .then(response => {
            if (!response.success) {
                throw new Error('Error en la solicitud: ' + response.statusText);
            }
            const subproblema = response.data;
            document.getElementById('viewNombreProblema').textContent = subproblema.NombreProblema;
            document.getElementById('viewNombreSubproblema').textContent = subproblema.NombreSubproblema;
            $('#modalViewSubproblema').modal('show');
        })
        .catch(error => {
            Swal.fire("Error", error.message, "error");
        });
}
// fin ver subproblema





// inicio eliminar subproblema 
function eliminarSubproblema(id) {
    Swal.fire({
        title: "Eliminar Subproblema",
        text: "¿Realmente quiere eliminar el Subproblema?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`${BASE_URL}/controladores/subproblemas/SubproblemasControlador.php?action=eliminarSubproblema`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('¡Eliminado!', 'El subproblema ha sido eliminado correctamente.', 'success')
                            .then(() => CargarTablaSubproblemas());
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
// fin eliminar subproblema 





// inicio editar subproblema
async function editarSubproblema(id) {
    try {
        const response = await fetch(`${BASE_URL}/controladores/subproblemas/SubproblemasControlador.php?action=obtenerSubproblemaPorId&id=${id}`);
        const result = await response.json();
        if (result.success) {
            await cargarProblemasSelect();
            document.getElementById('formSubproblema').reset();
            // Llena el formulario
            document.getElementById('idSubproblema').value = result.data.IdSubproblema;
            document.getElementById('nombre').value = result.data.NombreSubproblema;
            // Asigna el valor del rol (¡sin selectpicker!)
            document.getElementById('problema').value = result.data.IdProblema;
            document.getElementById('modalFormSubproblemaLabel').innerText = 'Editar Subproblema';
            // Muestra el modal
            $('#modalFormSubproblema').modal('show');
        } else {
            Swal.fire("Error", result.msg, "error");
        }
    } catch (error) {
        console.error('Error al obtener el subproblema:', error);
        Swal.fire("Error", "No se pudo obtener la información del subproblema.", "error");
    }
}
// fin editar subproblema





// inicio guardar subproblema
function guardarSubproblema() {
    const formData = new FormData(document.getElementById('formSubproblema'));
    const accion = document.getElementById('idSubproblema').value ? 'editarSubproblema' : 'crearSubproblema';
    fetch(`${BASE_URL}/controladores/subproblemas/SubproblemasControlador.php?action=${accion}`, {
        method: 'POST',
        body: formData
    })
        .then(response => response.text()) // Obtener la respuesta como texto
        .then(text => {
            try {
                const data = JSON.parse(text); // Intentar parsear el JSON
                if (data.success) {
                    Swal.fire("Éxito", data.msg, "success").then(() => {
                        $('#modalFormSubproblema').modal('hide');
                        CargarTablaSubproblemas(); // Recargar la tabla
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


// fin guardar subproblema





// inicio editar subproblema
function openModal() {
    document.getElementById('formSubproblema').reset();
    document.getElementById('idSubproblema').value = "";
    cargarProblemasSelect();
    document.getElementById('modalFormSubproblemaLabel').innerText = 'Nuevo Sub Poblema';
    $('#modalFormSubproblema').modal('show');
}
// fin editar subproblema





// inicio funcion cargar roles en select para formuladio de nuevo o editar
function cargarProblemasSelect() {
    return new Promise((resolve, reject) => {
        fetch(`${BASE_URL}/controladores/subproblemas/SubproblemasControlador.php?action=CargarProblemas`)
            .then(response => response.json())
            .then(({ success, data, msg }) => {
                if (!success) {
                    reject(msg || 'Error al cargar los problemas');
                    return;
                }
                const select = document.getElementById('problema');
                select.innerHTML = '<option value="">Seleccione un Problema</option>';

                data.forEach(({ IdProblema, NombreProblema }) => {
                    const option = document.createElement('option');
                    option.value = IdProblema;
                    option.textContent = NombreProblema;
                    select.appendChild(option);
                });

                resolve();
            })
            .catch(error => reject(error));
    });
}
// inicio funcion cargar roles en select para formuladio de nuevo o editar