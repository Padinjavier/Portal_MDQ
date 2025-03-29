<?php
require_once '../../modelos/soportes/SoportesModelo.php';
require_once '../../Config/Config.php'; // Incluir Config.php

class SoportesControlador
{
    private $modelo;

    public function __construct()
    {
        $db = new Conexion();
        $this->modelo = new SoportesModelo($db);
    }





    // inicio Obtener todos los Soportes
    public function CargarTablaSoportes()
    {
        try {
            ob_start(); // Captura cualquier salida de error o warning
            $soportes = $this->modelo->CargarTablaSoportes();
            $output = ob_get_clean(); // Obtiene los errores capturados
            if (!empty($output)) {
                throw new Exception($output); // Lanza una excepción con el error capturado
            }
            echo json_encode(['success' => true, 'data' => $soportes]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    // fin Obtener todos los Soportes





    // inicio Obtener un Soporte por ID
    public function obtenerSoportePorId($id)
    {
        try {
            // Verificar si el ID está vacío
            if (empty($id)) {
                throw new Exception('ID no proporcionado');
            }
            $soporte = $this->modelo->obtenerSoportePorId($id);
            if ($soporte) {
                echo json_encode(['success' => true, 'data' => $soporte]);
            } else {
                echo json_encode(['success' => false, 'msg' => 'Soporte no encontrado']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al obtener el Soporte: ' . $e->getMessage()]);
        }
    }
    // fin Obtener un Soporte por ID





    // inicio Crear un nuevo Soporte
    public function crearSoporte()
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
                'PasswordUsuario' => $_POST['password'] ?? null, // Si es necesario
                'RolUsuario' => $_POST['rol'] ?? null // Si es necesario
            ];

            // Validar datos
            foreach ($datos as $key => $value) {
                if (empty($value)) {
                    throw new Exception("El campo $key es requerido");
                }
            }

            $resultado = $this->modelo->crearSoporte($datos);
            echo json_encode(['success' => $resultado, 'msg' => $resultado ? 'Soporte creado exitosamente.' : 'Error al crear el Soporte.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al crear el Soporte: ' . $e->getMessage()]);
        }
    }
    // fin Crear un nuevo Soporte







    // Editar un Soporte
    public function editarSoporte($id)
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
                'RolUsuario' => $_POST['rol'] ?? null,
                'IdSoporte' => $_POST['idSoporte'] ?? null,
            ];
            if (!empty($_POST['password'])) {
                $datos['PasswordUsuario'] = $_POST['password'];
            }
            foreach ($datos as $key => $value) {
                if ($key !== 'PasswordUsuario' && empty($value)) {
                    throw new Exception("El campo $key es requerido");
                }
            }
            $resultado = $this->modelo->editarSoporte($id, $datos);
            echo json_encode([
                'success' => $resultado,
                'msg' => $resultado ? 'Soporte editado exitosamente. ' : 'Error al editar el Soporte.'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'msg' => 'Error al editar el Soporte: '. $e->getMessage()
            ]);
        }
    }






    // Eliminar un Soporte
    public function eliminarSoporte($id)
    {
        try {
            if (empty($id)) {
                throw new Exception('ID no proporcionado');
            }
            $resultado = $this->modelo->eliminarSoporte($id);
            if (!$resultado) {
                throw new Exception('No se pudo eliminar el Soporte en la base de datos.');
            }
            echo json_encode(['success' => true, 'msg' => 'Soporte eliminado correctamente.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al eliminar el Soporte: ' . $e->getMessage()]);
        }
    }





    // inicio Obtener todos los roles
    public function CargarRoles()
    {
        try {
            $roles = $this->modelo->CargarRoles();
            echo json_encode(['success' => true, 'data' => $roles]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al obtener roles: ' . $e->getMessage()]);
        }
    }
    // fin Obtener todos los roles





    // inicio Guardar configuración de roles
    public function guardarConfiguracion()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $roles = $data['roles'] ?? [];
            if (empty($roles)) {
                throw new Exception("Datos incompletos para guardar la configuración.");
            }
            $result = $this->modelo->guardarConfiguracionMODELO($roles);
            echo json_encode(['success' => true, 'data' => $result]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al guardar la configuración: ' . $e->getMessage()]);
        }
    }
    // fin Guardar configuración de roles





    // inicio eliminar configuración de roles
    public function eliminarRelacionModuloRol()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $roles = $data['roles'] ?? [];
            if (!$roles) {
                throw new Exception("Datos incompletos para eliminar la relación.");
            }
            $result = $this->modelo->eliminarRelacionModuloRolMODELO($roles);
            echo json_encode(['success' => true, 'data' => $result]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al eliminar la relación: ' . $e->getMessage()]);
        }
    }
    // fin eliminar configuración de roles



}






// Ejecutar la acción correspondiente
// Ejecutar la acción correspondiente
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $controlador = new SoportesControlador();
    switch ($_GET['action']) {
        case 'CargarTablaSoportes':
            $controlador->CargarTablaSoportes();
            break;
        case 'obtenerSoportePorId':
            $id = $_GET['id'] ?? null;
            $controlador->obtenerSoportePorId($id);
            break;
        case 'CargarRoles':
            $controlador->CargarRoles();
            break;
        default:
            echo json_encode(['success' => false, 'msg' => 'Acción GET no válida']);
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    // Leer el cuerpo de la solicitud POST
    $input = json_decode(file_get_contents('php://input'), true);

    $controlador = new SoportesControlador();
    switch ($_GET['action']) {
        case 'crearSoporte':
            $controlador->crearSoporte();
            break;
        case 'editarSoporte':
            $id = $_POST['idSoporte'] ?? null; // Leer desde el cuerpo
            $controlador->editarSoporte($id);
            break;
        case 'eliminarSoporte':
            $id = $input['id'] ?? null; // Leer desde el cuerpo
            $controlador->eliminarSoporte($id);
            break;
        case 'guardarConfiguracion':
            $controlador->guardarConfiguracion();
            break;
        case 'eliminarRelacionModuloRol':
            $controlador->eliminarRelacionModuloRol();
            break;
        default:
            echo json_encode(['success' => false, 'msg' => 'Acción POST no válida']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'msg' => 'Acción no especificada o método incorrecto']);
}
