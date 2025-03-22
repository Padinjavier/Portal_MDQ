<?php
require_once "../modelos/ClienteModelo.php";
require_once "../Config/Config.php"; // Asegúrate de que tienes la clase de conexión

$conexion = new Conexion();
$clienteModelo = new ClienteModelo($conexion);

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'getAll':
            echo json_encode($clienteModelo->obtenerClientes());
            break;

        case 'get':
            if (isset($_GET['id'])) {
                echo json_encode($clienteModelo->obtenerCliente($_GET['id']));
            }
            break;

        case 'save':
            $datos = $_POST;
            if (isset($datos['idCliente']) && !empty($datos['idCliente'])) {
                $resultado = $clienteModelo->actualizarCliente($datos);
            } else {
                $resultado = $clienteModelo->agregarCliente($datos);
            }
            echo json_encode(['success' => $resultado]);
            break;

        case 'delete':
            if (isset($_GET['id'])) {
                echo json_encode(['success' => $clienteModelo->eliminarCliente($_GET['id'])]);
            }
            break;
    }
}
?>
