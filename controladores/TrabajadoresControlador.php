<?php
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





    // inicio Obtener todos los trabajadores
    public function CargarTablaTrabajadores()
    {
        try {
            $trabajadores = $this->modelo->CargarTablaTrabajadores();
            echo json_encode(['success' => true, 'data' => $trabajadores]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al obtener trabajadores: ' . $e->getMessage()]);
        }
    }
    // fin Obtener todos los trabajadores





    // inicio Obtener un trabajador por ID
    public function obtenerTrabajador($id)
    {
        try {
            if (empty($id)) {
                throw new Exception('ID no proporcionado');
            }
            $trabajador = $this->modelo->obtenerPorId($id);
            if ($trabajador) {
                echo json_encode(['success' => true, 'data' => $trabajador]);
            } else {
                echo json_encode(['success' => false, 'msg' => 'Trabajador no encontrado']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al obtener el trabajador: ' . $e->getMessage()]);
        }
    }
    // fin Obtener un trabajador por ID





    // inicio Crear un nuevo trabajador
    public function crearTrabajador()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }

            $datos = [
                'NombresUsuario' => $_POST['nombre'] ?? null,
                'ApellidosUsuario' => $_POST['apellido'] ?? null,
                'TelefonoUsuario' => $_POST['telefono'] ?? null,
                'DNIUsuario' => $_POST['dni'] ?? null,
                'CorreoUsuario' => $_POST['correo'] ?? null,
                'UsernameUsuario' => $_POST['usuario'] ?? null,
                'PasswordUsuario' => $_POST['password'] ?? null // Si es necesario
            ];

            // Validar datos
            foreach ($datos as $key => $value) {
                if (empty($value)) {
                    throw new Exception("El campo $key es requerido");
                }
            }

            $resultado = $this->modelo->crearTrabajador($datos);
            echo json_encode(['success' => $resultado, 'msg' => $resultado ? 'Trabajador creado exitosamente.' : 'Error al crear el trabajador.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al crear el trabajador: ' . $e->getMessage()]);
        }
    }
    // fin Crear un nuevo trabajador




  


    // Editar un trabajador
    public function editarTrabajador($id)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }
            $datos = [
                'NombresUsuario' => $_POST['nombre'] ?? null,
                'ApellidosUsuario' => $_POST['apellido'] ?? null,
                'TelefonoUsuario' => $_POST['telefono'] ?? null,
                'DNIUsuario' => $_POST['dni'] ?? null,
                'CorreoUsuario' => $_POST['correo'] ?? null,
                'UsernameUsuario' => $_POST['usuario'] ?? null,
            ];
            if (!empty($_POST['password'])) {
                $datos['PasswordUsuario'] = $_POST['password'];
            }
            foreach ($datos as $key => $value) {
                if ($key !== 'PasswordUsuario' && empty($value)) {
                    throw new Exception("El campo $key es requerido");
                }
            }
            $resultado = $this->modelo->editarTrabajador($id, $datos);
            echo json_encode([
                'success' => $resultado,
                'msg' => $resultado ? 'Trabajador editado exitosamente.' : 'Error al editar el trabajador.'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'msg' => 'Error al editar el trabajador: ' . $e->getMessage()
            ]);
        }
    }





  
    // Eliminar un trabajador
    public function eliminarTrabajador($id)
    {
        try {
            if (empty($id)) {
                throw new Exception('ID no proporcionado');
            }
            $resultado = $this->modelo->eliminarTrabajador($id);
            echo json_encode(['success' => $resultado, 'msg' => $resultado ? 'Trabajador eliminado correctamente.' : 'Error al eliminar el trabajador.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al eliminar el trabajador: ' . $e->getMessage()]);
        }
    }


















    // Buscar trabajadores según filtros
    public function buscarTrabajador()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
                throw new Exception('Método no permitido');
            }

            $filtros = [
                'NombresUsuario' => $_GET['NombresUsuario'] ?? null,
                'ApellidosUsuario' => $_GET['ApellidosUsuario'] ?? null,
                'DNIUsuario' => $_GET['DNIUsuario'] ?? null,
                'CorreoUsuario' => $_GET['CorreoUsuario'] ?? null
            ];

            $resultado = $this->modelo->buscarTrabajador($filtros);
            echo json_encode(['success' => true, 'data' => $resultado]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al buscar trabajadores: ' . $e->getMessage()]);
        }
    }
}






// Ejecutar la acción correspondiente
if (isset($_GET['action'])) {
    $controlador = new TrabajadoresControlador();
    switch ($_GET['action']) {
        case 'CargarTablaTrabajadores':
            $controlador->CargarTablaTrabajadores();
            break;
        case 'eliminarTrabajador':
            $id = $_GET['id'] ?? null;
            $controlador->eliminarTrabajador($id);
            break;
        case 'crearTrabajador':
            $controlador->crearTrabajador();
            break;
        case 'editarTrabajador':
            $id = $_POST['idTrabajador'] ?? null;
            $controlador->editarTrabajador($id);
            break;
        case 'buscarTrabajador':
            $controlador->buscarTrabajador();
            break;
        case 'obtenerTrabajador':
            $id = $_GET['id'] ?? null;
            $controlador->obtenerTrabajador($id);
            break;
        default:
            echo json_encode(['success' => false, 'msg' => 'Acción no válida']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'msg' => 'Acción no especificada']);
}