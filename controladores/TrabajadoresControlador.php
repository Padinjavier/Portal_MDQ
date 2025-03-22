<?php
require_once "../modelos/TrabajadoresModelo.php";
require_once "../Config/Config.php"; // Asegúrate de que tienes la clase de conexión

$conexion = new Conexion();
$TrabajadoresModelo = new TrabajadoresModelo($conexion);

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'getAll':
            echo json_encode($TrabajadoresModelo->obtenerClientes());
            break;

        case 'get':
            if (isset($_GET['id'])) {
                echo json_encode($TrabajadoresModelo->obtenerCliente($_GET['id']));
            }
            break;

        case 'save':
            $datos = $_POST;
            if (isset($datos['idCliente']) && !empty($datos['idCliente'])) {
                $resultado = $TrabajadoresModelo->actualizarCliente($datos);
            } else {
                $resultado = $TrabajadoresModelo->agregarCliente($datos);
            }
            echo json_encode(['success' => $resultado]);
            break;

        case 'delete':
            if (isset($_GET['id'])) {
                echo json_encode(['success' => $TrabajadoresModelo->eliminarCliente($_GET['id'])]);
            }
            break;
    }
}
?>
