<?php
// C:\wamp64\www\helpmdq\controladores\DashboardControlador.php
require_once '../../modelos/dashboard/DashboardModelo.php';
require_once '../../Config/Config.php'; // Incluir la configuración

class DashboardControlador
{
    private $DashboardModelo;
    public function __construct()
    {
        $db = new Conexion();
        $this->DashboardModelo = new DashboardModelo($db);
    }





    public function ResumenGeneral()
    {
        $datos = $this->DashboardModelo->ResumenGeneral();
        echo json_encode($datos);
    }





    public function EstadoTickets()
    {
        $datos = $this->DashboardModelo->EstadoTickets();
        echo json_encode($datos);
    }
}





if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $controlador = new DashboardControlador();
    switch ($_GET['action']) {
        case 'ResumenGeneral':
            $controlador->ResumenGeneral();
            break;
        case 'EstadoTickets':
            $controlador->EstadoTickets();
            break;
        default:
            echo json_encode(['success' => false, 'msg' => 'Acción GET no válida']);
            break;
    }
}
?>