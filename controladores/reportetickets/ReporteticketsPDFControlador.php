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
            // Crear instancia TCPDF
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

            // Desactivar cabecera y pie de página predeterminados
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            // Configurar márgenes en 0 para evitar espacios en blanco
            $pdf->SetMargins(0, 0, 0);
            $pdf->SetAutoPageBreak(false, 0);

            // Añadir una página en blanco
            $pdf->AddPage();

            // Limpiar cualquier salida previa para evitar líneas en blanco
            ob_end_clean();

            // Generar el PDF en blanco
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
