<?php
require_once '../../modelos/trabajadores/TrabajadoresModelo.php';
require_once '../../Config/Config.php'; // Incluir Config.php

class TrabajadoresControlador
{
    private $modelo;

    public function __construct()
    {
        $db = new Conexion();
        $this->modelo = new TrabajadoresModelo($db);
    }





    // inicio Obtener todos los trabajadores
    public function CargarDatosTrabajadores()
    {
        try {
            $trabajadores = $this->modelo->CargarDatosTrabajadores();
            echo json_encode(['success' => true, 'data' => $trabajadores]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    // fin Obtener todos los trabajadores





    // inicio Obtener un trabajador por ID
    public function BuscarTrabajador($id)
    {
        try {
            // Verificar si el ID está vacío
            if (empty($id)) {
                throw new Exception('ID no proporcionado');
            }
            $trabajador = $this->modelo->BuscarTrabajador($id);
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
                'NombresUsuario' => $_POST['NombresTrabajador'] ?? null,
                'ApellidosUsuario' => $_POST['ApellidosTrabajador'] ?? null,
                'TelefonoUsuario' => $_POST['TelefonoTrabajador'] ?? null,
                'DNIUsuario' => $_POST['DNITrabajador'] ?? null,
                'CorreoUsuario' => $_POST['CorreoTrabajador'] ?? null,
                'UsernameUsuario' => $_POST['UsernameTrabajador'] ?? null,
                'PasswordUsuario' => $_POST['PasswordTrabajador'] ?? null, // Si es necesario
                'RolUsuario' => $_POST['rol'] ?? null
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
                'NombresUsuario' => $_POST['NombresTrabajador'] ?? null,
                'ApellidosUsuario' => $_POST['ApellidosTrabajador'] ?? null,
                'TelefonoUsuario' => $_POST['TelefonoTrabajador'] ?? null,
                'DNIUsuario' => $_POST['DNITrabajador'] ?? null,
                'CorreoUsuario' => $_POST['CorreoTrabajador'] ?? null,
                'UsernameUsuario' => $_POST['UsernameTrabajador'] ?? null,
                'RolUsuario' => $_POST['RolTrabajador'] ?? null,
            ];
            if (!empty($_POST['PasswordTrabajador'])) {
                $datos['PasswordUsuario'] = $_POST['PasswordTrabajador'];
            }
            foreach ($datos as $key => $value) {
                if ($key !== 'PasswordUsuario' && empty($value)) {
                    throw new Exception("El campo $key es requerido");
                }
            }
            $resultado = $this->modelo->editarTrabajador($id, $datos);
            echo json_encode([
                'success' => $resultado,
                'msg' => $resultado ? 'Trabajador editado exitosamente. ' : 'Error al editar el trabajador.'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'msg' => 'Error al editar el trabajador: ' . $e->getMessage()
            ]);
        }
    }






    // Eliminar un trabajador
// Eliminar un trabajador
    public function eliminarTrabajador($id)
    {
        try {
            if (empty($id)) {
                throw new Exception('ID no proporcionado');
            }
            // Llamada al modelo para eliminar al trabajador
            $resultado = $this->modelo->eliminarTrabajador($id);
            if (!$resultado) {
                throw new Exception('No se pudo eliminar el trabajador en la base de datos.');
            }
            echo json_encode(['success' => true, 'msg' => 'Trabajador eliminado correctamente.']);
        } catch (Exception $e) {
            // Aquí se captura el error y se manda a frontend para mostrar
            echo json_encode(['success' => false, 'msg' => 'Error al eliminar el trabajador: ' . $e->getMessage()]);
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
    public function GuardarConfiguracion()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $roles = $data['roles'] ?? [];
            if (empty($roles)) {
                throw new Exception("Datos incompletos para guardar la configuración.");
            }
            $result = $this->modelo->GuardarConfiguracion($roles);
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
    $controlador = new TrabajadoresControlador();
    switch ($_GET['action']) {
        case 'CargarDatosTrabajadores':
            $controlador->CargarDatosTrabajadores();
            break;
        case 'BuscarTrabajador':
            $id = $_GET['id'] ?? null;
            $controlador->BuscarTrabajador($id);
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

    $controlador = new TrabajadoresControlador();
    switch ($_GET['action']) {
        case 'crearTrabajador':
            $controlador->crearTrabajador();
            break;
        case 'editarTrabajador':
            $id = $_POST['IdTrabajador'] ?? null; // Leer desde el cuerpo
            $controlador->editarTrabajador($id);
            break;
        case 'eliminarTrabajador':
            $id = $input['id'] ?? null; // Leer desde el cuerpo
            $controlador->eliminarTrabajador($id);
            break;
        case 'GuardarConfiguracion':
            $controlador->GuardarConfiguracion();
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
