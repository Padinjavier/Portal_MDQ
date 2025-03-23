<?php
// C:\wamp64\www\helpmdq\controladores\TrabajadoresControlador.php
require_once '../modelos/TrabajadoresModelo.php';
require_once '../Config/Config.php'; // Incluir Config.php

class TrabajadoresControlador
{
    private $modelo;

    public function __construct()
    {
        $db = new Conexion();
        $this->modelo = new TrabajadoresModelo($db);
    }

    // Obtener todos los trabajadores
    public function obtenerTrabajadoresTotal()
    {
        $trabajadores = $this->modelo->obtenerTrabajadoresTotal();
        echo json_encode($trabajadores);
    }

    // Función para eliminar un trabajador
    public function eliminarTrabajador($id)
    {
        $resultado = $this->modelo->eliminarTrabajador($id);
        if ($resultado) {
            echo json_encode(['success' => true, 'msg' => 'Trabajador eliminado correctamente.']);
        } else {
            echo json_encode(['success' => false, 'msg' => 'Error al eliminar el trabajador.']);
        }
    }



    // Crear un nuevo trabajador
    public function crearTrabajador()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'NombresUsuario' => $_POST['nombre'],
                'ApellidosUsuario' => $_POST['apellido'],
                'TelefonoUsuario' => $_POST['telefono'],
                'DNIUsuario' => $_POST['dni'],
                'CorreoUsuario' => $_POST['correo'],
                'UsernameUsuario' => $_POST['usuario'],
                'PasswordUsuario' => $_POST['password'] // Si es necesario
            ];
            $resultado = $this->modelo->crearTrabajador($datos);
            echo json_encode(['success' => $resultado]);
        }
    }

    public function editarTrabajador($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar que el ID esté presente
            if (empty($_POST['idTrabajador'])) {
                echo json_encode(['success' => false, 'msg' => 'ID no proporcionado']);
                return;
            }

            $datos = [
                'NombresUsuario' => $_POST['nombre'],
                'ApellidosUsuario' => $_POST['apellido'],
                'TelefonoUsuario' => $_POST['telefono'],
                'DNIUsuario' => $_POST['dni'],
                'CorreoUsuario' => $_POST['correo'],
                'UsernameUsuario' => $_POST['usuario']
            ];

            $resultado = $this->modelo->editarTrabajador($_POST['idTrabajador'], $datos);
            if ($resultado) {
                echo json_encode(['success' => true, 'msg' => 'Trabajador editado exitosamente']);
            } else {
                echo json_encode(['success' => false, 'msg' => 'Error al editar el trabajador']);
            }
        }
    }

    // Obtener un trabajador por ID
    public function obtenerTrabajador($id)
    {
        $trabajador = $this->modelo->obtenerPorId($id);
        if ($trabajador) {
            echo json_encode(['status' => true, 'data' => $trabajador]);
        } else {
            echo json_encode(['status' => false, 'msg' => 'Trabajador no encontrado']);
        }
    }
    // Buscar trabajadores según filtros
    public function buscarTrabajador()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $filtros = [
                'NombresUsuario' => $_GET['NombresUsuario'] ?? null,
                'ApellidosUsuario' => $_GET['ApellidosUsuario'] ?? null,
                'DNIUsuario' => $_GET['DNIUsuario'] ?? null,
                'CorreoUsuario' => $_GET['CorreoUsuario'] ?? null
            ];
            $resultado = $this->modelo->buscarTrabajador($filtros);
            echo json_encode($resultado);
        }
    }
}

// Ejecutar la acción correspondiente
if (isset($_GET['action'])) {
    $controlador = new TrabajadoresControlador();
    switch ($_GET['action']) {
        case 'obtenerTrabajadoresTotal':
            $controlador->obtenerTrabajadoresTotal();
            break;
        case 'eliminarTrabajador':
            $id = $_GET['id'] ?? null;
            if ($id) {
                $controlador->eliminarTrabajador($id);
            } else {
                echo json_encode(['error' => 'ID no proporcionado']);
            }
            break;
        case 'crearTrabajador':
            $controlador->crearTrabajador();
            break;
        case 'editarTrabajador':
            $id = $_POST['idTrabajador'] ?? null;
            if ($id) {
                $controlador->editarTrabajador($id);
            } else {
                echo json_encode(['error' => 'ID no proporcionado']);
            }
            break;
        case 'buscarTrabajador':
            $controlador->buscarTrabajador();
            break;
        case 'obtenerTrabajador':
            $id = $_GET['id'] ?? null;
            if ($id) {
                $controlador->obtenerTrabajador($id);
            } else {
                echo json_encode(['error' => 'ID no proporcionado']);
            }
            break;
        default:
            echo json_encode(['error' => 'Acción no válida']);
            break;
    }
} else {
    echo json_encode(['error' => 'Acción no especificada']);
}