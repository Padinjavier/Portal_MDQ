<?php
require_once '../../modelos/subproblemas/SubproblemasModelo.php';
require_once '../../Config/Config.php'; // Incluir Config.php

class SubproblemasControlador
{
    private $modelo;

    public function __construct()
    {
        $db = new Conexion();
        $this->modelo = new SubproblemasModelo($db);
    }





    // inicio Obtener todos los Subproblemas
    public function CargarTablaSubproblemas()
    {
        try {
            ob_start(); // Captura cualquier salida de error o warning
            $subproblemas = $this->modelo->CargarTablaSubproblemas();
            $output = ob_get_clean(); // Obtiene los errores capturados
            if (!empty($output)) {
                throw new Exception($output); // Lanza una excepción con el error capturado
            }
            echo json_encode(['success' => true, 'data' => $subproblemas]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    // fin Obtener todos los Subproblemas





    // inicio Obtener un subproblema por ID
    public function obtenerSubproblemaPorId($id)
    {
        try {
            // Verificar si el ID está vacío
            if (empty($id)) {
                throw new Exception('ID no proporcionado');
            }
            $subproblema = $this->modelo->obtenerSubproblemaPorId($id);
            if ($subproblema) {
                echo json_encode(['success' => true, 'data' => $subproblema]);
            } else {
                echo json_encode(['success' => false, 'msg' => 'Subproblema no encontrado']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al obtener el Subproblema: ' . $e->getMessage()]);
        }
    }
    // fin Obtener un subproblema por ID





    // inicio Crear un nuevo subproblema
    public function crearSubproblema()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }

            $datos = [
                'IdProblema' => $_POST['problema'] ?? null, // Si es necesario
                'NombreSubproblema' => $_POST['nombre'] ?? null,
            ];

            // Validar datos
            foreach ($datos as $key => $value) {
                if (empty($value)) {
                    throw new Exception("El campo $key es requerido");
                }
            }

            $resultado = $this->modelo->crearSubproblema($datos);
            echo json_encode(['success' => $resultado, 'msg' => $resultado ? 'Subproblema creado exitosamente.' : 'Error al crear el Subproblema.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al crear el Subproblema: ' . $e->getMessage()]);
        }
    }
    // fin Crear un nuevo subproblema







    // Editar un subproblema
    public function editarSubproblema($id)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }
            $datos = [
                'IdProblema' => $_POST['problema'] ?? null, // Si es necesario
                'NombreSubproblema' => $_POST['nombre'] ?? null,
            ];
            foreach ($datos as $key => $value) {
                if ($key !== 'PasswordUsuario' && empty($value)) {
                    throw new Exception("El campo $key es requerido");
                }
            }
            $resultado = $this->modelo->editarSubproblema($id, $datos);
            echo json_encode(['success' => $resultado, 'msg' => $resultado ? 'Subproblema editado exitosamente. ' : 'Error al editar el Subproblema.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al editar el Subproblema: ' . $e->getMessage()]);
        }
    }







    // Inicio Eliminar un subproblema
    public function eliminarSubproblema($id)
    {
        try {
            if (empty($id)) {
                throw new Exception('ID no proporcionado');
            }
            $resultado = $this->modelo->eliminarSubproblema($id);
            if (!$resultado) {
                throw new Exception('No se pudo eliminar el Subproblema en la base de datos.');
            }
            echo json_encode(['success' => true, 'msg' => 'Subproblema eliminado correctamente.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al eliminar el Subproblema: ' . $e->getMessage()]);
        }
    }
    // Fin Eliminar un subproblema


    // inicio Obtener todos los roles
    public function CargarProblemas()
    {
        try {
            $roles = $this->modelo->CargarProblemas();
            echo json_encode(['success' => true, 'data' => $roles]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al obtener problemas: ' . $e->getMessage()]);
        }
    }
    // fin Obtener todos los roles

}






// Ejecutar la acción correspondiente
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $controlador = new SubproblemasControlador();
    switch ($_GET['action']) {
        case 'CargarTablaSubproblemas':
            $controlador->CargarTablaSubproblemas();
            break;
        case 'obtenerSubproblemaPorId':
            $id = $_GET['id'] ?? null;
            $controlador->obtenerSubproblemaPorId($id);
            break;
            case 'CargarProblemas':
                $controlador->CargarProblemas();
                break;
        default:
            echo json_encode(['success' => false, 'msg' => 'Acción GET no válida']);
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    // Leer el cuerpo de la solicitud POST
    $input = json_decode(file_get_contents('php://input'), true);

    $controlador = new SubproblemasControlador();
    switch ($_GET['action']) {
        case 'crearSubproblema':
            $controlador->crearSubproblema();
            break;
        case 'editarSubproblema':
            $id = $_POST['idSubproblema'] ?? null;
            $controlador->editarSubproblema($id);
            break;
        case 'eliminarSubproblema':
            $id = $input['id'] ?? null;
            $controlador->eliminarSubproblema($id);
            break;
        default:
            echo json_encode(['success' => false, 'msg' => 'Acción POST no válida']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'msg' => 'Acción no especificada o método incorrecto']);
}
