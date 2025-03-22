<?php
// C:\wamp64\www\helpmdq\controladores\DashboardControlador.php
require_once '../modelos/DashboardModelo.php';
require_once '../Config/Config.php'; // Incluir la configuración

class DashboardControlador {
    private $DashboardModelo;

    public function __construct() {
        $db = new Conexion();
        $this->DashboardModelo = new DashboardModelo($db);
    }

    public function obtenerDashboardData() {
        $datos = $this->DashboardModelo->getDashboardData();
        echo json_encode($datos); // Devuelve los datos en formato JSON
    }
}

// Verifica si la petición es AJAX para devolver los datos
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $dashboardControlador = new DashboardControlador();
    $dashboardControlador->obtenerDashboardData();
}
?>