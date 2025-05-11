<?php

require '../../vendor/autoload.php';
require '../../Config/Config.php';
require '../../modelos/reportetickets/ReporteticketsPDFModelo.php';
require '../../vendor/tecnickcom/tcpdf/tcpdf.php';

class ReporteticketsPDFControlador
{
    private $modelo;

    public function __construct()
    {
        $db = new Conexion();
        $this->modelo = new ReporteticketsPDFModelo($db);
    }

    public function CodigoTicketPDF($codigo)
    {
        try {
            $data = $this->modelo->ObtenerTicketYComentarios($codigo);
            // Crear instancia TCPDF
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            // Desactivar encabezado y pie de página
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            // Márgenes en 0 para usar toda la hoja
            $pdf->SetMargins(25, 30, 25);
            $pdf->SetAutoPageBreak(false, 0);
            // Añadir una página
            $pdf->AddPage();
            // Imagen de Fondo - Ocupa toda la hoja sin perder calidad
            $pdf->Image(LOGO_EMPRESA, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
            // Fecha Actual y Hora
            $fechaActual = date('d') . " de " . getMesEnEspañol(date('Y-m-d')) . " del " . date('Y');
            $horaActual = date('H:i');
            $ticketData = $data[0] ?? [];
            $creador = $ticketData['Creador'] ?? 'Sin asignar';
            $problema = $ticketData['NombreProblema'] ?? 'No especificado';
            $subproblema = $ticketData['NombreSubproblema'] ?? 'No asignado';
            $departamento = $ticketData['DepartamentoTicket'] ?? 'No especificado';
            $fechaCreacion = $ticketData['DataCreateTicket'] ?? 'Sin fecha';
            $fechaActualizacion = $ticketData['DataUpdateTicket'] ?? 'Sin fecha';
            $estado = getEstadoTicket($ticketData['StatusTicket'] ?? -1);
            $soporte = $ticketData['UsuarioSoporte'] ?? 'No asignado';
            // Título del Año
            $nombreAño = getNombreAño($ticketData['DataCreateTicket']);
            $pdf->SetFont('helvetica', 'I', 10);
            $pdf->Cell(0, 10, '"' . $nombreAño . '"', 0, 1, 'C');
            $pdf->Ln(10);
            // Título del Reporte
            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->Cell(0, 10, "REPORTE DE TICKETS", 0, 1, 'C');
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(0, 10, "N° " . ($ticketData['CodTicket'] ?? 'Sin Código'), 0, 1, 'C');
            $pdf->Ln(10);
            // Fecha y Lugar
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(0, 10, "Quilmaná, $fechaActual", 0, 1, 'R');
            $pdf->Ln(10);
            // Descripción del Reporte
            $descripcion = "El encargado de la Unidad de Informática de la Municipalidad Distrital de Quilmaná, siendo las $horaActual horas del día $fechaActual, emite el presente reporte identificado con el código N° {$ticketData['CodTicket']} registrado el $fechaCreacion por $creador del área $departamento. Dicho ticket fue atendido por $soporte.";
            $pdf->MultiCell(0, 10, $descripcion, 0, 'L');
            $pdf->Cell(0, 10, "A continuación, se detallan los datos del ticket:", 0, 1, 'L');
            $pdf->Ln(5);
            // Tabla de Datos del Ticket
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 10, "DETALLES DEL TICKET", 0, 1, 'L');
            $pdf->SetFont('helvetica', '', 12);
            // Restablecer fuente y color para las celdas
            $pdf->SetFont('helvetica', '', 12);
            $pdf->SetFillColor(220, 220, 220); // Blanco
            // Datos del Ticket
            $datos = [
                "Código:" => $ticketData['CodTicket'],
                "Trabajador:" => $creador,
                "Departamento:" => $departamento,
                "Fecha Creación:" => $fechaCreacion,
                "Fecha Actualización:" => $fechaActualizacion,
                "Soporte:" => $soporte,
                "Problema:" => $problema,
                "Subproblema:" => $subproblema,
                "Estado:" => $estado,
            ];
            // Iterar por los datos
            foreach ($datos as $campo => $valor) {
                $pdf->Cell(50, 10, $campo, 1, 0, 'L', 1); // Celda del campo
                $pdf->Cell(110, 10, $valor, 1, 1, 'L', 0); // Celda del valor
            }
            $pdf->Ln(5); // Espacio al final de la tabla
            ob_end_clean();
            $pdf->Output("Reporte_Ticket_{$codigo}.pdf", 'I');

        } catch (Exception $e) {
            echo "Error al generar el PDF: " . $e->getMessage();
        }
    }
}




















// Validar acción
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $controlador = new ReporteticketsPDFControlador();
    $codigo = $_GET['codigo'] ?? 'Sin Código';

    switch ($_GET['action']) {
        case 'CodigoTicketPDF':
            $controlador->CodigoTicketPDF($codigo);
            break;
        default:
            echo json_encode(['success' => false, 'msg' => 'Acción GET no válida']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'msg' => 'Método no válido o acción no especificada']);
}
