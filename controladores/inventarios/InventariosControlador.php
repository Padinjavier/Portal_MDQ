<?php
require_once '../../modelos/inventarios/InventariosModelo.php';
require_once '../../Config/Config.php'; // Incluir Config.php

class InventariosControlador
{
    private $modelo;

    public function __construct()
    {
        $db = new Conexion();
        $this->modelo = new InventariosModelo($db);
    }





    // inicio Obtener todos los trabajadores
    public function CargarDatosInventarios()
    {
        try {
            $Trabajadores = $this->modelo->CargarDatosInventarios();
            if ($Trabajadores !== false) {
                echo json_encode(['success' => true, 'data' => $Trabajadores]);
            } else {
                echo json_encode(['success' => false, 'msg' => 'Trabajadores no encontrados']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al Cargar datos de los trabajadores: <br>' . $e->getMessage()]);
        }
    }
    // fin Obtener todos los trabajadores





    // inicio Crear un nuevo trabajador
    public function GuardarTrabajador()
    {
        try {
            $datos = [
                'NombresUsuario' => $_POST['NombresTrabajador'] ?? null,
                'ApellidosUsuario' => $_POST['ApellidosTrabajador'] ?? null,
                'TelefonoUsuario' => $_POST['TelefonoTrabajador'] ?? null,
                'DNIUsuario' => $_POST['DNITrabajador'] ?? null,
                'CorreoUsuario' => $_POST['CorreoTrabajador'] ?? null,
                'UsernameUsuario' => $_POST['UsernameTrabajador'] ?? null,
                'PasswordUsuario' => $_POST['PasswordTrabajador'] ?? null, // Si es necesario
                'RolUsuario' => $_POST['RolTrabajador'] ?? null
            ];
            foreach ($datos as $key => $value) {
                if (empty($value)) {
                    throw new Exception("El campo $key es requerido");
                }
            }
            $resultado = $this->modelo->GuardarTrabajador($datos);
            echo json_encode(['success' => $resultado, 'msg' => $resultado ? 'Trabajador creado exitosamente.' : 'Error al crear el trabajador.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al Guardar el trabajador: <br>' . $e->getMessage()]);
        }
    }
    // fin Crear un nuevo trabajador





    // inicio Obtener un trabajador por ID
    public function BuscarTrabajador($id)
    {
        try {
            // Verificar si el ID está vacío
            if (empty($id)) {
                throw new Exception('ID no proporcionado');
            }
            $trabajador = $this->modelo->BuscarTrabajador($id);
            if ($trabajador !== false) {
                echo json_encode(['success' => true, 'data' => $trabajador]);
            } else {
                echo json_encode(['success' => false, 'msg' => 'Trabajador no encontrado']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al Buscar el trabajador: <br>' . $e->getMessage()]);
        }
    }
    // fin Obtener un trabajador por ID




    // INICIO FUNCION Editar trabajador
    public function EditarTrabajador($id)
    {
        try {
            if (empty($id)) {
                throw new Exception('ID no proporcionado');
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
            foreach ($datos as $key => $value) {
                if ($key !== 'PasswordUsuario' && empty($value)) {
                    throw new Exception("El campo $key es requerido");
                }
            }
            if (!empty($_POST['PasswordTrabajador'])) {
                $datos['PasswordUsuario'] = $_POST['PasswordTrabajador'];
            }
            $resultado = $this->modelo->EditarTrabajador($id, $datos);
            $respuesta = ['success' => $resultado, 'msg' => $resultado ? 'Trabajador editado exitosamente.' : 'Error al editar el trabajador.'];
            echo json_encode($respuesta);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al editar el trabajador: <br>' . $e->getMessage()]);
        }
    }
    // FIN FUNCION Editar trabajador





    // Eliminar un trabajador
    public function EliminarTrabajador($id)
    {
        try {
            if (empty($id)) {
                throw new Exception('ID no proporcionado');
            }
            $trabajador = $this->modelo->EliminarTrabajador($id);
            if (!$trabajador) {
                throw new Exception('No se pudo eliminar el trabajador en la base de datos.');
            } else {
                echo json_encode(['success' => true, 'msg' => 'Trabajador eliminado correctamente.']);
            }
        } catch (Exception $e) {
            // Aquí se captura el error y se manda a frontend para mostrar
            echo json_encode(['success' => false, 'msg' => 'Error al eliminar el trabajador: <br>' . $e->getMessage()]);
        }
    }











    






    


}






// Ejecutar la acción correspondiente
// Ejecutar la acción correspondiente
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $controlador = new InventariosControlador();
    switch ($_GET['action']) {
        case 'CargarDatosInventarios':
            $controlador->CargarDatosInventarios();
            break;
        case 'BuscarTrabajador':
            $id = $_GET['id'] ?? null;
            $controlador->BuscarTrabajador($id);
            break;
        default:
            echo json_encode(['success' => false, 'msg' => 'Acción GET no válida']);
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    // Leer el cuerpo de la solicitud POST
    $input = json_decode(file_get_contents('php://input'), true);

    $controlador = new InventariosControlador();
    switch ($_GET['action']) {
        case 'GuardarTrabajador':
            $controlador->GuardarTrabajador();
            break;
        case 'EditarTrabajador':
            $id = $_POST['IdTrabajador'] ?? null; // Leer desde el cuerpo
            $controlador->EditarTrabajador($id);
            break;
        case 'EliminarTrabajador':
            $id = $input['id'] ?? null; // Leer desde el cuerpo
            $controlador->EliminarTrabajador($id);
            break;
        default:
            echo json_encode(['success' => false, 'msg' => 'Acción POST no válida']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'msg' => 'Acción no especificada o método incorrecto']);
}
