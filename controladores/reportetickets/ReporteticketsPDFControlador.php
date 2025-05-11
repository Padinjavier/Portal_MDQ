<?php
ob_start();

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

            if (empty($data)) {
                echo "No se encontró información para el código: " . htmlspecialchars($codigo);
                exit;
            }

            $ticketData = $data[0];
            $fechaActual = date('d') . " de " . date('F') . " del " . date('Y');
            $horaActual = date('H:i');

            $titulo = "Reporte del Ticket - " . $ticketData['CodTicket'];
            $creador = $ticketData['Creador'];
            $problema = $ticketData['NombreProblema'] ?? 'No especificado';
            $subproblema = $ticketData['NombreSubproblema'] ?? 'No asignado';
            $departamento = $ticketData['DepartamentoTicket'] ?? 'No especificado';
            $fechaCreacion = $ticketData['DataCreateTicket'];
            $fechaActualizacion = $ticketData['DataUpdateTicket'];
            $estado = $ticketData['StatusTicket'];
            $soporte = $ticketData['UsuarioSoporte'] ?? 'No asignado';

            // Crear instancia TCPDF
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

            // Márgenes personalizados
            // $pdf->SetMargins(30, 25, 30);
            $pdf->AddPage();

            // Imagen de Fondo
            $pdf->Image(LOGO_EMPRESA, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

            // Título del Año
            $pdf->SetFont('helvetica', '', 12);
            // $pdf->SetY(25);
            $pdf->Cell(0, 10, '"Año de la Unidad, Paz y Desarrollo"', 0, 1, 'C');

            // Título del Reporte
            $pdf->SetFont('helvetica', 'B', 14);
            $pdf->Ln(5);
            $pdf->Cell(0, 10, "REPORTE DE TICKETS", 0, 1, 'C');

            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(0, 10, "N° " . $ticketData['CodTicket'], 0, 1, 'C');
            $pdf->Cell(0, 10, "UNIDAD DE INFORMÁTICA", 0, 1, 'C');

            // Fecha y Lugar (A la derecha)
            $pdf->SetFont('helvetica', '', 12);
            $pdf->SetY(70);
            $pdf->Cell(0, 10, "Quilmaná, $fechaActual", 0, 1, 'R');

            // Descripción del Reporte
            $pdf->Ln(10);
            $descripcion = "El encargado de la Unidad de Informática de la Municipalidad Distrital de Quilmaná, siendo las $horaActual horas del día $fechaActual, emite el presente reporte identificado con el código ({$ticketData['CodTicket']}) registrado el $fechaCreacion a las " . date('H:i', strtotime($fechaCreacion)) . " por $creador del área $departamento. Dicho ticket fue atendido por $soporte. A continuación, se detallan los datos del ticket:";
            $pdf->MultiCell(0, 10, $descripcion, 0, 'J');
            $pdf->Ln(5);

            // Tabla de Datos del Ticket
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 10, "DETALLES DEL TICKET", 0, 1, 'L');
            $pdf->SetFont('helvetica', '', 12);

            $pdf->Cell(40, 10, "Código:", 1, 0, 'L');
            $pdf->Cell(100, 10, $ticketData['CodTicket'], 1, 1, 'L');

            $pdf->Cell(40, 10, "Trabajador:", 1, 0, 'L');
            $pdf->Cell(100, 10, $creador, 1, 1, 'L');

            $pdf->Cell(40, 10, "Área:", 1, 0, 'L');
            $pdf->Cell(100, 10, $departamento, 1, 1, 'L');

            $pdf->Cell(40, 10, "Fecha Creación:", 1, 0, 'L');
            $pdf->Cell(100, 10, $fechaCreacion, 1, 1, 'L');

            $pdf->Cell(40, 10, "Fecha Actualización:", 1, 0, 'L');
            $pdf->Cell(100, 10, $fechaActualizacion, 1, 1, 'L');

            $pdf->Cell(40, 10, "Soporte:", 1, 0, 'L');
            $pdf->Cell(100, 10, $soporte, 1, 1, 'L');

            $pdf->Cell(40, 10, "Problema:", 1, 0, 'L');
            $pdf->Cell(100, 10, $problema, 1, 1, 'L');

            $pdf->Cell(40, 10, "Subproblema:", 1, 0, 'L');
            $pdf->Cell(100, 10, $subproblema, 1, 1, 'L');

            $pdf->Cell(40, 10, "Estado:", 1, 0, 'L');
            $pdf->Cell(100, 10, $estado, 1, 1, 'L');

            $pdf->Ln(10);
            $pdf->SetFont('helvetica', 'B', 14);
            $pdf->Cell(0, 10, "COMENTARIOS", 0, 1, 'C');
            $pdf->Ln(5);

            $pdf->SetFont('helvetica', '', 12);
            $comentarios = array_filter($data, fn($c) => !empty($c['Comentario']));

            if (empty($comentarios)) {
                $pdf->MultiCell(0, 10, "No hay comentarios disponibles.", 0, 'L');
            } else {
                foreach ($comentarios as $comentario) {
                    $pdf->MultiCell(0, 8, "Comentario de: " . $comentario['UsuarioComentario'] . "   Fecha: " . date('d M Y H:i', strtotime($comentario['FechaComentario'])), 0, 'L');
                    $pdf->Ln(2);
                    $pdf->MultiCell(0, 10, strip_tags($comentario['Comentario']), 1, 'L');
                    $pdf->Ln(5);
                }
            }

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
