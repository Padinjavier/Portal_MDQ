<?php
require_once '../../modelos/reportetickets/ReporteticketsPDFModelo.php';
require_once '../../Config/Config.php';

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
        echo "Reporte de Ticket - Código: " . htmlspecialchars($codigo);
    }

}

// Validar método y acción
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $controlador = new ReporteticketsPDFControlador();
    $codigo = $_GET['codigo'] ?? null;

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
