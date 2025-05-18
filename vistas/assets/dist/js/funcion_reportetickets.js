// C:\wamp64\www\Portal_MDQ\vistas\assets\dist\js\funcion_reportetickets.js
$(document).ready(function () {

    SelectTrabajadores();
    SelectSoportes();
    SelectDepartamentos();
    SelectProblemas();
});

function SelectTrabajadores() {
    return fetch(`${BASE_URL}/controladores/reportetickets/ReporteticketsPDFControlador.php?action=SelectTrabajadores`)
        .then(res => res.json())
        .then(response => {
            if (!response.success) throw new Error(response.msg);
            const select = document.getElementById('IdUsuarioCreadorTicketReporte');
            select.innerHTML = ''; // Limpiar opciones
            if (response.data.length != 1) {
                select.innerHTML = '<option value="">Seleccione un usuario</option>';
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

function SelectSoportes() {
    return fetch(`${BASE_URL}/controladores/reportetickets/ReporteticketsPDFControlador.php?action=SelectSoportes`)
        .then(res => res.json())
        .then(response => {
            if (!response.success) throw new Error(response.msg);
            const select = document.getElementById('IdUsuarioSoporteTicketReporte');
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

function SelectDepartamentos() {
    return fetch(`${BASE_URL}/controladores/reportetickets/ReporteticketsPDFControlador.php?action=SelectDepartamentos`)
        .then(res => res.json())
        .then(response => {
            if (!response.success) throw new Error(response.msg);
            const select = document.getElementById('IdDepartamentosTicketReporte');
            select.innerHTML = ''; // Limpiar opciones
            if (response.data.length != 1) {
                select.innerHTML = '<option value="">Seleccione un departamento</option>';
            }
            response.data.forEach(Departamento => {
                const option = document.createElement('option');
                option.value = Departamento.DepartamentoTicket;
                option.textContent = Departamento.DepartamentoTicket;
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

function SelectProblemas() {
    return fetch(`${BASE_URL}/controladores/reportetickets/ReporteticketsPDFControlador.php?action=SelectProblemas`)
        .then(res => res.json())
        .then(response => {
            if (!response.success) throw new Error(response.msg);
            const select = document.getElementById('IdProblemaTicketReporte');
            select.innerHTML = '<option value="">Seleccione un problema</option>';
            response.data.forEach(p => {
                const option = document.createElement('option');
                option.value = p.IdProblema;
                option.textContent = p.NombreProblema;
                select.appendChild(option);
            });
        })
        .catch(error => {
            Swal.fire({ icon: 'error', title: 'Error', text: error.message });
        });
}

function CargarSubproblemas() {
    const idProblema = document.getElementById('IdProblemaTicketReporte').value;
    const select = document.getElementById('IdSubproblemaTicketReporte');
    select.innerHTML = '<option value="">Seleccione un subproblema</option>';

    if (!idProblema) return;

    fetch(`${BASE_URL}/controladores/reportetickets/ReporteticketsPDFControlador.php?action=SelectSubproblemas&idProblema=${idProblema}`)
        .then(res => res.json())
        .then(response => {
            if (!response.success) throw new Error(response.msg);
            response.data.forEach(s => {
                const option = document.createElement('option');
                option.value = s.IdSubproblema;
                option.textContent = s.NombreSubproblema;
                select.appendChild(option);
            });
        })
        .catch(error => {
            Swal.fire({ icon: 'error', title: 'Error', text: error.message });
        });
}


function CodigoTicketPDF(tipo) {
    console.log("Generando reporte por codigo de ticket...");
    const codigoTicket = document.getElementById('codigoTicket').value;
    if (!codigoTicket) {
        Swal.fire("Error", "Por favor, seleccione ambas fechas y horas.", "error");
        return;
    }
    if (tipo === "PDF") {
        window.open(`${BASE_URL}/controladores/reportetickets/ReporteticketsPDFControlador.php?action=CodigoTicketPDF&codigo=${codigoTicket}`, "_blank");
    } else if (tipo === "EXCEL") {
        window.open(`${BASE_URL}/controladores/reportetickets/ReporteticketsEXCELControlador.php?action=CodigoTicketPDF&codigo=${codigoTicket}`, "_blank");
    }
}


function generarReportePorFechaHora(tipo) {
    console.log("Generando reporte por fecha y hora...");
    const fechaDesde = document.getElementById('fechaDesde').value;
    const fechaHasta = document.getElementById('fechaHasta').value;
    if (!fechaDesde || !fechaHasta) {
        Swal.fire("Error", "Por favor, seleccione ambas fechas y horas.", "error");
        return;
    }
    if (tipo === "PDF") {
        window.open(`${BASE_URL}/controladores/reportetickets/ReporteticketsPDFControlador.php?action=PorFechaPDF&fechaDesde=
            ${fechaDesde}&fechaHasta=${fechaHasta}`, "_blank");
    } else if (tipo === "EXCEL") {
        window.open(`${BASE_URL}/controladores/reportetickets/ReporteticketsEXCELControlador.php?action=PorFechaEXCEL&fechaDesde=
            ${fechaDesde}&fechaHasta=${fechaHasta}`, "_blank");
    }
}




