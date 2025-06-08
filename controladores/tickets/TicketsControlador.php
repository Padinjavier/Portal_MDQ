<?php
require_once '../../modelos/tickets/TicketsModelo.php';
require_once '../../Config/Config.php'; // Incluir Config.php

class TicketsControlador
{
    private $modelo;

    public function __construct()
    {
        $db = new Conexion();
        $this->modelo = new TicketsModelo($db);
    }





    // inicio Obtener todos los Tickets
    public function CargarDatosTickets()
    {
        try {
            $Tickets = $this->modelo->CargarDatosTickets();
            if ($Tickets !== false) {
                echo json_encode(['success' => true, 'data' => $Tickets]);
            } else {
                echo json_encode(['success' => false, 'msg' => 'Tickets no encontrados']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al Cargar datos de los Tickets: <br>' . $e->getMessage()]);
        }
    }
    // fin Obtener todos los Tickets


    public function ListarSoportes()
    {
        try {
            $ListaSoporte = $this->modelo->ListarSoportes();
            if ($ListaSoporte !== false) {
                echo json_encode(['success' => true, 'data' => $ListaSoporte]);
            } else {
                echo json_encode(['success' => false, 'msg' => 'Soportes no encontrados']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al Cargar datos de los Soportes: <br>' . $e->getMessage()]);
        }
    }


    // inicio Obtener todos los roles
    public function SelectProblemasySubproblemas()
    {
        try {
            $datos = $this->modelo->SelectProblemasySubproblemas();
            echo json_encode(['success' => true, 'data' => $datos]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al obtener datos: ' . $e->getMessage()]);
        }
    }
    // fin Obtener todos los roles





    public function SelectNombre()
    {
        try {
            session_start(); // Asegúrate de que la sesión esté iniciada
            $idUsuario = $_SESSION['Login_IdUsuario'];
            $rolUsuario = $_SESSION['Login_RolUsuario'];

            $usuarios = $this->modelo->SelectNombre($idUsuario, $rolUsuario);

            echo json_encode(['success' => true, 'data' => $usuarios]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al obtener usuarios: ' . $e->getMessage()]);
        }
    }






    // inicio Crear un nuevo Ticket
    public function GuardarTicket()
    {
        try {
            $comentarios = json_decode($_POST['comentarios'] ?? '[]', true);
            $primerComentario = isset($comentarios[0]['Comentario']) ? trim($comentarios[0]['Comentario']) : null;
            $datos = [
                'IdUsuarioCreadorTicket' => $_POST['IdUsuarioCreadorTicket'] ?? null,
                'DepartamentoTicket' => $_POST['DepartamentoTicket'] ?? null,
                'IdProblemaTicket' => $_POST['IdProblemaTicket'] ?? null,
                'IdSubproblemaTicket' => $_POST['IdSubproblemaTicket'] ?? null,
                'DescripcionTicket' => $primerComentario,
            ];

            $datos['comentarios'] = $comentarios; // ✅ <- ESTA LÍNEA ES CLAVE
            foreach ($datos as $key => $value) {
                if (empty($value) || $key == "IdUsuarioSoporteTicket") {
                    throw new Exception("El campo $key es requerido");
                }
            }
            // Solo agregar soporte si el rol del usuario es 3
            if (isset($_SESSION['Login_RolUsuario']) && $_SESSION['Login_RolUsuario'] == 1) {
                $datos['IdUsuarioSoporteTicket'] = $_POST['IdUsuarioSoporteTicket'] ?? null;
            }
            $resultado = $this->modelo->GuardarTicket($datos);
            echo json_encode(['success' => $resultado, 'msg' => $resultado ? 'Ticket creado exitosamente.' : 'Error al crear el Ticket.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al Guardar el Ticket: <br>' . $e]);
        }
    }
    // fin Crear un nuevo Ticket





    // inicio Obtener un Ticket por ID
    public function BuscarTicket($id)
    {
        try {
            // Verificar si el ID está vacío
            if (empty($id)) {
                throw new Exception('ID no proporcionado');
            }
            $Ticket = $this->modelo->BuscarTicket($id);
            $ComentarioTicket = $this->modelo->BuscarComentarioTicket($id);
            if ($Ticket !== false) {
                echo json_encode(['success' => true, 'data' => $Ticket, 'comentarios' => $ComentarioTicket]);
            } else {
                echo json_encode(['success' => false, 'msg' => 'Ticket no encontrado']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al Buscar el Ticket: <br>' . $e->getMessage()]);
        }
    }
    // fin Obtener un Ticket por ID

    // INICIO FUNCION Editar Ticket
    public function EditarTicket($id)
    {
        try {
            if (empty($id)) {
                throw new Exception('ID no proporcionado');
            }
            if (!empty($_POST['IdUsuarioSoporteTicket']) || $_POST['IdUsuarioSoporteTicket'] == null) {
                $datos = [
                    'IdUsuarioSoporteTicket' => $_POST['IdUsuarioSoporteTicket'] ?? null,
                ];
                $this->modelo->EditarSoporteTicket($id, $datos);
            }
            $datos = [
                'IdUsuarioCreadorTicket' => $_POST['IdUsuarioCreadorTicket'] ?? null,
                'DepartamentoTicket' => $_POST['DepartamentoTicket'] ?? null,
                'IdProblemaTicket' => $_POST['IdProblemaTicket'] ?? null,
                'IdSubproblemaTicket' => $_POST['IdSubproblemaTicket'] ?? null,
            ];

            foreach ($datos as $key => $value) {
                if (empty($value)) {
                    throw new Exception("El campo $key es requerido");
                }
            }
            // Justo antes del echo json_encode final
            if (!empty($_POST['comentarios'])) {
                $comentarios = json_decode($_POST['comentarios'], true);
                if (is_array($comentarios)) {
                    foreach ($comentarios as $comentario) {
                        $idComentario = $comentario['IdComentario'] ?? null;
                        $contenido = $comentario['Comentario'] ?? null;

                        if ($idComentario && $contenido) {
                            $this->modelo->ActualizarComentario($idComentario, $contenido);
                        }
                    }
                }
            }
            $resultado = $this->modelo->EditarTicket($id, $datos);
            echo json_encode(['success' => $resultado, 'msg' => $resultado ? 'Ticket editado exitosamente.' : 'Error al editar el ticket.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al editar el Ticket: <br>' . $e->getMessage()]);
        }
    }
    // FIN FUNCION Editar Ticket

    public function GuardarComentarioTicket()
    {
        try {
            session_start();
            $IdUsuario = $_SESSION['Login_IdUsuario'] ?? null;
            $IdTicket = $_POST['IdTicketComent'] ?? null;
            $Comentario = trim($_POST['ComentarioTexto'] ?? '');
            $ViewStatusTicket = $_POST['ViewStatusTicket'] ?? null;

            if (!$IdUsuario || !$IdTicket || $Comentario === '') {
                throw new Exception("Faltan datos para guardar el comentario.");
            }

            $datos = [
                'IdTicket' => $IdTicket,
                'IdUsuario' => $IdUsuario,
                'Comentario' => $Comentario,
                'ViewStatusTicket' => $ViewStatusTicket
            ];

            $resultado = $this->modelo->GuardarComentarioTicket($datos);
            if ($resultado !== false) {
                echo json_encode(['success' => true, 'msg' => 'Comentario guardado correctamente.']);
            } else {
                echo json_encode(['success' => false, 'msg' => 'Ticket no encontrado']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => 'Error al guardar comentario: ' . $e->getMessage()]);
        }
    }


    // Eliminar un Ticket
    public function EliminarTicket($id)
    {
        try {
            if (empty($id)) {
                throw new Exception('ID no proporcionado');
            }
            $Ticket = $this->modelo->EliminarTicket($id);
            if (!$Ticket) {
                throw new Exception('No se pudo eliminar el Ticket en la base de datos.');
            } else {
                echo json_encode(['success' => true, 'msg' => 'Ticket eliminado correctamente.']);
            }
        } catch (Exception $e) {
            // Aquí se captura el error y se manda a frontend para mostrar
            echo json_encode(['success' => false, 'msg' => 'Error al eliminar el Ticket: <br>' . $e->getMessage()]);
        }
    }
    public function AtenderTicket($IdTicket, $IdSubproblemaTicket)
    {
        try {
            if (empty($IdTicket) || empty($IdSubproblemaTicket)) {
                throw new Exception('ID o IDsoporte no proporcionado');
            }
            $Ticket = $this->modelo->AtenderTicket($IdTicket, $IdSubproblemaTicket);
            if (!$Ticket) {
                throw new Exception('No se te pudo asignar el Ticket.');
            } else {
                echo json_encode(['success' => true, 'msg' => 'Ticket asignado correctamente.']);
            }
        } catch (Exception $e) {
            // Aquí se captura el error y se manda a frontend para mostrar
            echo json_encode(['success' => false, 'msg' => 'Error al atignarte el ticket: <br>' . $e->getMessage()]);
        }
    }
}


// Ejecutar la acción correspondiente
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $controlador = new TicketsControlador();
    switch ($_GET['action']) {
        case 'CargarDatosTickets':
            $controlador->CargarDatosTickets();
            break;
        case 'ListarSoportes':
            $controlador->ListarSoportes();
            break;
        case 'SelectNombre':
            $controlador->SelectNombre();
            break;
        case 'BuscarTicket':
            $id = $_GET['id'] ?? null;
            $controlador->BuscarTicket($id);
            break;
        case 'SelectProblemasySubproblemas':
            $controlador->SelectProblemasySubproblemas();
            break;
        default:
            echo json_encode(['success' => false, 'msg' => 'Acción GET no válida']);
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    // Leer el cuerpo de la solicitud POST
    $input = json_decode(file_get_contents('php://input'), true);

    $controlador = new TicketsControlador();
    switch ($_GET['action']) {
        case 'GuardarTicket':
            $controlador->GuardarTicket();
            break;
        case 'EditarTicket':
            $id = $_POST['IdTicket'] ?? null; // Leer desde el cuerpo
            $controlador->EditarTicket($id);
            break;
        case 'EliminarTicket':
            $id = $input['id'] ?? null; // Leer desde el cuerpo
            $controlador->EliminarTicket($id);
            break;
        case 'AtenderTicket':
            $IdTicket = $input['IdTicket'] ?? null; // Leer desde el cuerpo
            $IdSubproblemaTicket = $input['IdSubproblemaTicket'] ?? null; // Leer desde el cuerpo
            $controlador->AtenderTicket($IdTicket, $IdSubproblemaTicket);
            break;
        case 'GuardarComentarioTicket':
            $controlador->GuardarComentarioTicket();
            break;
        default:
            echo json_encode(['success' => false, 'msg' => 'Acción POST no válida']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'msg' => 'Acción no especificada o método incorrecto']);
}
