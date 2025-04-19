<?php
// C:\wamp64\www\helpmdq\modelos\trabajadores\TicketsModelo.php
class TicketsModelo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db->getConexion();
    }





// INICIO FUNCION CargarDatosTickets
public function CargarDatosTickets()
{
    session_start();
    $isAdmin = $_SESSION['Login_RolUsuario'] == 1;
    $params = [':StatusTicket' => 0];
    $sql = "SELECT 
                t.IdTicket, 
                t.CodTicket, 
                CONCAT(u.NombresUsuario, ' ', u.ApellidosUsuario) AS trabajador,
                t.DepartamentoTicket, 
                p.NombreProblema, 
                sp.NombreSubproblema, 
                t.DataCreateTicket, 
                t.StatusTicket
            FROM tickets t
            INNER JOIN usuarios u ON t.IdUsuarioCreadorTicket = u.IdUsuario
            INNER JOIN problemas p ON t.IdProblemaTicket = p.IdProblema
            INNER JOIN subproblemas sp ON t.IdSubproblemaTicket = sp.IdSubproblema
            WHERE t.StatusTicket != :StatusTicket";
    if (!$isAdmin) {
        $sql .= " AND t.IdUsuarioCreadorTicket = :IdUsuarioCreadorTicket";
        $params[':IdUsuarioCreadorTicket'] = $_SESSION['Login_IdUsuario'];
    }
    try {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Error al cargar tickets: " . $e->getMessage());
    }
}
// FIN FUNCION CargarDatosTickets






    // INICIO FUNCIÓN: Obtener todos los roles activos con su estado de asignación a módulos 
    public function SelectProblemasySubproblemas()
    {
        try {
            $sql = "SELECT p.IdProblema, p.NombreProblema, sp.IdSubproblema, sp.NombreSubproblema
                FROM problemas p, subproblemas sp
                WHERE sp.IdProblema = p.IdProblema 
                AND p.StatusProblema = :StatusProblema
                AND sp.StatusSubproblema = :StatusSubproblema";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['StatusProblema' => 1,
                            'StatusSubproblema' => 1,
                            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    // FIN FUNCIÓN: Obtener todos los roles activos con su estado de asignación a módulos





    public function SelectNombre($idUsuario, $rolUsuario)
    {
        try {
            if ($rolUsuario == 1) {
                // Administrador: trae todos los usuarios activos
                $sql = "SELECT IdUsuario, CONCAT(NombresUsuario, ' ', ApellidosUsuario) AS NombreCompleto 
                        FROM usuarios 
                        WHERE StatusUsuario != 0";
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
            } else {
                // No administrador: solo su propio usuario
                $sql = "SELECT IdUsuario, CONCAT(NombresUsuario, ' ', ApellidosUsuario) AS NombreCompleto 
                        FROM usuarios 
                        WHERE StatusUsuario != 0 AND IdUsuario = :IdUsuario";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([':IdUsuario' => $idUsuario]);
            }
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener usuarios: " . $e->getMessage());
        }
    }
    
// INICIO FUNCION GuardarTicket - Inserta un nuevo ticket generando el CodTicket antes del insert.
public function GuardarTicket($datos)
{
    try {
        $sqlUltimoId = "SELECT MAX(IdTicket) AS UltimoId FROM tickets";
        $stmtMax = $this->db->prepare($sqlUltimoId);
        $stmtMax->execute();
        $resultadoMax = $stmtMax->fetch(PDO::FETCH_ASSOC);
        $nuevoId = isset($resultadoMax['UltimoId']) ? (int)$resultadoMax['UltimoId'] + 1 : 1;
        $codTicket = "TK_" . $nuevoId;
        $sql = "INSERT INTO tickets (CodTicket, IdUsuarioCreadorTicket, DepartamentoTicket, IdProblemaTicket, IdSubproblemaTicket, DescripcionTicket) 
                VALUES (:CodTicket, :IdUsuarioCreadorTicket, :DepartamentoTicket, :IdProblemaTicket, :IdSubproblemaTicket, :DescripcionTicket)";
        $stmt = $this->db->prepare($sql);
        $resultado = $stmt->execute([
            ':CodTicket'              => $codTicket,
            ':IdUsuarioCreadorTicket' => $datos['IdUsuarioCreadorTicket'],
            ':DepartamentoTicket'     => $datos['DepartamentoTicket'],
            ':IdProblemaTicket'       => $datos['IdProblemaTicket'],
            ':IdSubproblemaTicket'    => $datos['IdSubproblemaTicket'],
            ':DescripcionTicket'=> $datos['DescripcionTicket']
        ]);
        if (!$resultado) {
            throw new Exception("No se pudo crear el ticket.");
        }
        return true;
    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
}
// FIN FUNCION GuardarTicket - Inserta un nuevo ticket generando el CodTicket antes del insert.


    // INICIO FUNCION BuscarTicket 
    public function BuscarTicket($IdTicket)
    {
        try {
            $sql = "SELECT t.IdTicket, t.CodTicket, t.IdUsuarioCreadorTicket,
                    CONCAT(ut.NombresUsuario, ' ', ut.ApellidosUsuario) AS Trabajador,
                    t.DepartamentoTicket,
                    t.IdProblemaTicket,
                    t.IdSubproblemaTicket,
                    p.NombreProblema,
                    sp.NombreSubproblema,
                    t.DescripcionTicket,
                    CONCAT(us.NombresUsuario, ' ', us.ApellidosUsuario) AS Soporte,
                    t.DataCreateTicket,
                    t.DataUpdateTicket,
                    t.StatusTicket
                FROM tickets t
                INNER JOIN usuarios ut ON t.IdUsuarioCreadorTicket = ut.IdUsuario
                LEFT JOIN usuarios us ON t.IdUsuarioSoporteTicket = us.IdUsuario
                INNER JOIN problemas p ON t.IdProblemaTicket = p.IdProblema
                INNER JOIN subproblemas sp ON t.IdSubproblemaTicket = sp.IdSubproblema
                WHERE t.StatusTicket != :StatusTicket
                AND t.IdTicket = :IdTicket;
                ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['StatusTicket' => 0,'IdTicket' => $IdTicket]);
            $Trabajadores = $stmt->fetch(PDO::FETCH_ASSOC);
            return $Trabajadores;
        } catch (PDOException $e) {
            throw new Exception( $e->getMessage());
        }
    }
    // FIN FUNCION BuscarTicket 

// INICIO FUNCION EditarTicket - Actualiza los datos de un ticket existente
public function EditarTicket($IdTicket, $datos)
{
    try {
        $sql = "UPDATE tickets 
                SET IdUsuarioCreadorTicket = :IdUsuarioCreadorTicket,
                    DepartamentoTicket = :DepartamentoTicket,
                    IdProblemaTicket = :IdProblemaTicket,
                    IdSubproblemaTicket = :IdSubproblemaTicket,
                    DescripcionTicket = :DescripcionTicket,
                    DataUpdateTicket = NOW()
                WHERE IdTicket = :IdTicket";

        $params = [
            ':IdUsuarioCreadorTicket' => $datos['IdUsuarioCreadorTicket'],
            ':DepartamentoTicket'     => $datos['DepartamentoTicket'],
            ':IdProblemaTicket'       => $datos['IdProblemaTicket'],
            ':IdSubproblemaTicket'    => $datos['IdSubproblemaTicket'],
            ':DescripcionTicket'      => $datos['DescripcionTicket'],
            ':IdTicket'               => $IdTicket
        ];
        $stmt = $this->db->prepare($sql);
        $resultado = $stmt->execute($params);

        if (!$resultado) {
            throw new Exception("No se pudo actualizar el ticket.");
        }
        return true;
    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
}
// FIN FUNCION EditarTicket
























    // INICIO ELIMINAR (DESACTIVAR) UN TRABAJADOR (CAMBIAR STATUSUSUARIO A 0)
    public function EliminarTicket($IdTrabajador)
    {
        try {
            if (empty($IdTrabajador)) {
                throw new Exception("ID de trabajador no proporcionado.");
            }
            $sql = "UPDATE usuarios SET StatusUsuario = 0 WHERE IdUsuario = ?";
            $stmt = $this->db->prepare($sql);
            $resultado =  $stmt->execute([$IdTrabajador]);
            if (!$resultado) {
                throw new Exception("No se pudo eliminar al trabajador.");
            }
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    // FIN ELIMINAR (DESACTIVAR) UN TRABAJADOR






}