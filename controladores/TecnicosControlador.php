<?php
require_once "../modelos/TecnicosModelo.php";
require_once "../Config/Config.php"; // Asegúrate de que tienes la clase de conexión

$conexion = new Conexion();
$TecnicosModelo = new TecnicosModelo($conexion);

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'getAll':
            echo json_encode($TecnicosModelo->obtenerClientes());
            break;

        case 'get':
            if (isset($_GET['id'])) {
                echo json_encode($TecnicosModelo->obtenerCliente($_GET['id']));
            }
            break;

        case 'save':
            $datos = $_POST;
            if (isset($datos['idCliente']) && !empty($datos['idCliente'])) {
                $resultado = $TecnicosModelo->actualizarCliente($datos);
            } else {
                $resultado = $TecnicosModelo->agregarCliente($datos);
            }
            echo json_encode(['success' => $resultado]);
            break;

        case 'delete':
            if (isset($_GET['id'])) {
                echo json_encode(['success' => $TecnicosModelo->eliminarCliente($_GET['id'])]);
            }
            break;
    }
}
?>
