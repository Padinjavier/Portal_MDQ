// C:\wamp64\www\Portal_MDQ\vistas\assets\dist\js\funcion_reportetickets.js

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




