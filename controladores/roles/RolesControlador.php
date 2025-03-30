<?php
require_once '../../modelos/roles/RolesModelo.php';
require_once '../../Config/Config.php'; // Incluir Config.php

class RolesControlador
{
    private $modelo;

    public function __construct()
    {
        $db = new Conexion();
        $this->modelo = new RolesModelo($db);
    }





    // inicio Obtener todos los Roles
    public function CargarTablaRoles()
    {
        try {
            ob_start(); // Captura cualquier salida de error o warning
            $roles = $this->modelo->CargarTablaRoles();
            $output = ob_get_clean(); // Obtiene los errores capturados
            if (!empty($output)) {
                throw new Exception($output); // Lanza una excepción con el error capturado
            }
            echo json_encode(['success' => true, 'data' => $roles]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    // fin Obtener todos los Roles





    // inicio Obtener un rol por ID
    public function obtenerRolPorId($id)
    {
        try {
            // Verificar si el ID está vacío
            if (empty($id)) {
                throw new Exception('ID no proporcionado');
            }
            $rol = $this->modelo->obtenerRolPorId($id);
            if ($rol) {
                echo json_encode(['success' => true, 'data' => $rol]);
            } else {
                echo json_encode(['success' => false, 'msg' => 'Rol no encontrado']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al obtener el Rol: ' . $e->getMessage()]);
        }
    }
    // fin Obtener un rol por ID





    // inicio Crear un nuevo rol
    public function crearRol()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }

            $datos = [
                'NombreRol' => $_POST['nombre'] ?? null,
                'DescripcionRol' => $_POST['descripcion'] ?? null,
            ];

            // Validar datos
            foreach ($datos as $key => $value) {
                if (empty($value)) {
                    throw new Exception("El campo $key es requerido");
                }
            }

            $resultado = $this->modelo->crearRol($datos);
            echo json_encode(['success' => $resultado, 'msg' => $resultado ? 'Rol creado exitosamente.' : 'Error al crear el Rol.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al crear el Rol: ' . $e->getMessage()]);
        }
    }
    // fin Crear un nuevo rol







    // Editar un rol
    public function editarRol($id)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }
            $datos = [
                'NombreRol' => $_POST['nombre'] ?? null,
                'DescripcionRol' => $_POST['descripcion'] ?? null,
            ];
            foreach ($datos as $key => $value) {
                if ($key !== 'PasswordUsuario' && empty($value)) {
                    throw new Exception("El campo $key es requerido");
                }
            }
            $resultado = $this->modelo->editarRol($id, $datos);
            echo json_encode(['success' => $resultado, 'msg' => $resultado ? 'Rol editado exitosamente. ' : 'Error al editar el Rol.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al editar el Rol: ' . $e->getMessage()]);
        }
    }







    // Inicio Eliminar un rol
    public function eliminarRol($id)
    {
        try {
            if (empty($id)) {
                throw new Exception('ID no proporcionado');
            }
            $resultado = $this->modelo->eliminarRol($id);
            if (!$resultado) {
                throw new Exception('No se pudo eliminar el Rol en la base de datos.');
            }
            echo json_encode(['success' => true, 'msg' => 'Rol eliminado correctamente.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al eliminar el Rol: ' . $e->getMessage()]);
        }
    }
    // Fin Eliminar un rol





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





    // inicio ver los permisos del role
    public function permisoRol($id)
    {
        try {
            // Verificar si el ID está vacío
            if (empty($id)) {
                throw new Exception('ID no proporcionado');
            }
            $modulos = $this->modelo->selectmodulos();
            $permisos = $this->modelo->permisoRol($id);
            $rol = $this->modelo->obtenerRolPorId($id);
            if ($rol) {
                echo json_encode(['success' => true, 'modulos' => $modulos, 'permisos' => $permisos, 'rol' => $rol]);
            } else {
                echo json_encode(['success' => false, 'msg' => 'Permisos del rol no encontrado', 'modulos' => $modulos, 'permisos' => $permisos, 'rol' => $rol]);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al obtener los permisos del rol: ' . $e->getMessage()]);
        }
    }

    // fin  ver los permisos del role




    // inicio Crear un nuevo rol
    public function guardarPermisos($idRol)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }

            if (!$idRol) {
                throw new Exception('ID de rol no proporcionado.');
            }

            // Obtener permisos desde POST
            $permisos = $_POST['permisos'] ?? null;

            if (!$permisos || !is_array($permisos)) {
                throw new Exception('Datos de permisos inválidos.');
            }
            // Llamar al modelo para actualizar los permisos
            $resultado = $this->modelo->actualizarPermisosRol($idRol, $permisos);
            echo json_encode([
                'success' => $resultado,
                'msg' => $resultado ? 'Permisos actualizados correctamente.' : 'Error al actualizar los permisos.'
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }

    // fin Crear un nuevo rol



}






// Ejecutar la acción correspondiente
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $controlador = new RolesControlador();
    switch ($_GET['action']) {
        case 'CargarTablaRoles':
            $controlador->CargarTablaRoles();
            break;
        case 'obtenerRolPorId':
            $id = $_GET['id'] ?? null;
            $controlador->obtenerRolPorId($id);
            break;
        case 'permisoRol':
            $id = $_GET['id'] ?? null;
            $controlador->permisoRol($id);
            break;
        default:
            echo json_encode(['success' => false, 'msg' => 'Acción GET no válida']);
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    // Leer el cuerpo de la solicitud POST
    $input = json_decode(file_get_contents('php://input'), true);

    $controlador = new RolesControlador();
    switch ($_GET['action']) {
        case 'crearRol':
            $controlador->crearRol();
            break;
        case 'editarRol':
            $id = $_POST['idRol'] ?? null;
            $controlador->editarRol($id);
            break;
        case 'eliminarRol':
            $id = $input['id'] ?? null;
            $controlador->eliminarRol($id);
            break;
        case 'guardarPermisos':
            $id = $_POST['idRol'] ?? null;
            $controlador->guardarPermisos($id);
            break;
        default:
            echo json_encode(['success' => false, 'msg' => 'Acción POST no válida']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'msg' => 'Acción no especificada o método incorrecto']);
}
