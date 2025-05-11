<?php
require_once '../../modelos/reportetickets/ReporteticketsEXCELModelo.php';
require_once '../../Config/Config.php';

class ReporteticketsEXCELControlador
{
    private $modelo;

    public function __construct()
    {
        $db = new Conexion();
        $this->modelo = new ReporteticketsEXCELModelo($db);
    }

    public function CodigoTicketEXCEL($codigo)
    {
        echo "Reporte de Ticket - Código: " . htmlspecialchars($codigo);
    }

}

// Validar método y acción
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $controlador = new ReporteticketsEXCELControlador();
    $codigo = $_GET['codigo'] ?? null;

    switch ($_GET['action']) {
        case 'CodigoTicketEXCEL':
            $controlador->CodigoTicketEXCEL($codigo);
            break;
        default:
            echo json_encode(['success' => false, 'msg' => 'Acción GET no válida']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'msg' => 'Método no válido o acción no especificada']);
}
