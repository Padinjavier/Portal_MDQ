<?php
require_once '../../modelos/problemas/ProblemasModelo.php';
require_once '../../Config/Config.php'; // Incluir Config.php

class ProblemasControlador
{
    private $modelo;

    public function __construct()
    {
        $db = new Conexion();
        $this->modelo = new ProblemasModelo($db);
    }





    // inicio Obtener todos los Problemas
    public function CargarTablaProblemas()
    {
        try {
            ob_start(); // Captura cualquier salida de error o warning
            $problemas = $this->modelo->CargarTablaProblemas();
            $output = ob_get_clean(); // Obtiene los errores capturados
            if (!empty($output)) {
                throw new Exception($output); // Lanza una excepción con el error capturado
            }
            echo json_encode(['success' => true, 'data' => $problemas]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    // fin Obtener todos los Problemas





    // inicio Obtener un Problema por ID
    public function obtenerProblemaPorId($id)
    {
        try {
            // Verificar si el ID está vacío
            if (empty($id)) {
                throw new Exception('ID no proporcionado');
            }
            $problema = $this->modelo->obtenerProblemaPorId($id);
            if ($problema) {
                echo json_encode(['success' => true, 'data' => $problema]);
            } else {
                echo json_encode(['success' => false, 'msg' => 'Problema no encontrado']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al obtener el Problema: ' . $e->getMessage()]);
        }
    }
    // fin Obtener un problema por ID





    // inicio Crear un nuevo problema
    public function crearProblema()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }

            $datos = [
                'NombreProblema' => $_POST['nombre'] ?? null,
            ];

            // Validar datos
            foreach ($datos as $key => $value) {
                if (empty($value)) {
                    throw new Exception("El campo $key es requerido");
                }
            }

            $resultado = $this->modelo->crearProblema($datos);
            echo json_encode(['success' => $resultado, 'msg' => $resultado ? 'Problema creado exitosamente.' : 'Error al crear el Problema.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al crear el Problema: ' . $e->getMessage()]);
        }
    }
    // fin Crear un nuevo Problema







    // Editar un Problema
    public function editarProblema($id)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }
            $datos = [
                'NombreProblema' => $_POST['nombre'] ?? null,
            ];
            foreach ($datos as $key => $value) {
                if ($key !== 'PasswordUsuario' && empty($value)) {
                    throw new Exception("El campo $key es requerido");
                }
            }
            $resultado = $this->modelo->editarProblema($id, $datos);
            echo json_encode(['success' => $resultado, 'msg' => $resultado ? 'Problema editado exitosamente. ' : 'Error al editar el Problema.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al editar el Problema: ' . $e->getMessage()]);
        }
    }







    // Inicio Eliminar un Problema
    public function eliminarProblema($id)
    {
        try {
            if (empty($id)) {
                throw new Exception('ID no proporcionado');
            }
            $resultado = $this->modelo->eliminarProblema($id);
            if (!$resultado) {
                throw new Exception('No se pudo eliminar el Problema en la base de datos.');
            }
            echo json_encode(['success' => true, 'msg' => 'Problema eliminado correctamente.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al eliminar el Problema: ' . $e->getMessage()]);
        }
    }
    // Fin Eliminar un Problema




}






// Ejecutar la acción correspondiente
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $controlador = new ProblemasControlador();
    switch ($_GET['action']) {
        case 'CargarTablaProblemas':
            $controlador->CargarTablaProblemas();
            break;
        case 'obtenerProblemaPorId':
            $id = $_GET['id'] ?? null;
            $controlador->obtenerProblemaPorId($id);
            break;
        default:
            echo json_encode(['success' => false, 'msg' => 'Acción GET no válida']);
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    // Leer el cuerpo de la solicitud POST
    $input = json_decode(file_get_contents('php://input'), true);

    $controlador = new ProblemasControlador();
    switch ($_GET['action']) {
        case 'crearProblema':
            $controlador->crearProblema();
            break;
        case 'editarProblema':
            $id = $_POST['idProblema'] ?? null;
            $controlador->editarProblema($id);
            break;
        case 'eliminarProblema':
            $id = $input['id'] ?? null;
            $controlador->eliminarProblema($id);
            break;
        default:
            echo json_encode(['success' => false, 'msg' => 'Acción POST no válida']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'msg' => 'Acción no especificada o método incorrecto']);
}
