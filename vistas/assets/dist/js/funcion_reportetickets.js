// C:\wamp64\www\Portal_MDQ\vistas\assets\dist\js\funcion_reportetickets.js
$(document).ready(function () {

    SelectTrabajadores();
    SelectSoportes();
    SelectDepartamentos();
});

function SelectTrabajadores() {
    return fetch(`${BASE_URL}/controladores/reportetickets/ReporteticketsPDFControlador.php?action=SelectTrabajadores`)
        .then(res => res.json())
        .then(response => {
            if (!response.success) throw new Error(response.msg);
            const select = document.getElementById('IdUsuarioCreadorTicketReporte');
            select.innerHTML = ''; // Limpiar opciones
            if (response.data.length != 1) {
                select.innerHTML = '<option value="">Seleccione un trabajador</option>';
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
function generarReportePorTrabajador(tipo) {
    const IdUsuarioCreadorTicketReporte = document.getElementById('IdUsuarioCreadorTicketReporte').value;
    if (!IdUsuarioCreadorTicketReporte) {
        Swal.fire("Error", "Por favor, seleccione una opcion.", "error");
        return;
    }
    if (tipo === "PDF") {
        window.open(`${BASE_URL}/controladores/reportetickets/ReporteticketsPDFControlador.php?action=PorTrabajadorPDF&IdUsuarioCreadorTicketReporte=
            ${IdUsuarioCreadorTicketReporte}`, "_blank");
    } else if (tipo === "EXCEL") {
        window.open(`${BASE_URL}/controladores/reportetickets/ReporteticketsEXCELControlador.php?action=PorTrabajadorEXCEL&IdUsuarioCreadorTicketReporte=
            ${IdUsuarioCreadorTicketReporte}`, "_blank");
    }
}

function generarReportePorSoporte(tipo) {
    const IdUsuarioSoporteTicketReporte = document.getElementById('IdUsuarioSoporteTicketReporte').value;
    if (!IdUsuarioSoporteTicketReporte) {
        Swal.fire("Error", "Por favor, seleccione una opcion.", "error");
        return;
    }
    if (tipo === "PDF") {
        window.open(`${BASE_URL}/controladores/reportetickets/ReporteticketsPDFControlador.php?action=PorSoportePDF&IdUsuarioSoporteTicketReporte=
            ${IdUsuarioSoporteTicketReporte}`, "_blank");
    } else if (tipo === "EXCEL") {
        window.open(`${BASE_URL}/controladores/reportetickets/ReporteticketsEXCELControlador.php?action=PorSoporteEXCEL&IdUsuarioSoporteTicketReporte=
            ${IdUsuarioSoporteTicketReporte}`, "_blank");
    }
}




