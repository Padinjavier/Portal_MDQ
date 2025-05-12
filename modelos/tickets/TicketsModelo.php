<?php
// C:\wamp64\www\Portal_MDQ\modelos\tickets\TicketsModelo.php
class TicketsModelo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db->getConexion();
    }

    // ------------------- INICIO FUNCION CargarDatosTickets -------------------
    public function CargarDatosTickets()
    {
        session_start();
        $rolUsuario = $_SESSION['Login_RolUsuario'];
        $idUsuario = $_SESSION['Login_IdUsuario'];
        $params = [':StatusTicket' => 0];

        $sql = "SELECT 
                t.IdTicket, 
                t.CodTicket, 
                CONCAT(u.NombresUsuario, ' ', u.ApellidosUsuario) AS trabajador,
                t.DepartamentoTicket, 
                p.NombreProblema, 
                sp.NombreSubproblema, 
                t.DataCreateTicket, 
                t.StatusTicket,
                t.IdUsuarioCreadorTicket,
                t.IdUsuarioSoporteTicket
            FROM tickets t
            INNER JOIN usuarios u ON t.IdUsuarioCreadorTicket = u.IdUsuario
            INNER JOIN problemas p ON t.IdProblemaTicket = p.IdProblema
            INNER JOIN subproblemas sp ON t.IdSubproblemaTicket = sp.IdSubproblema
            WHERE t.StatusTicket != :StatusTicket";

        if ($rolUsuario != 1) { // NO admin
            if ($rolUsuario == 2) { // Soporte
                $sql .= " AND (t.IdUsuarioSoporteTicket = :IdUsuario OR t.IdUsuarioSoporteTicket IS NULL)";
            } else { // Trabajador normal
                $sql .= " AND t.IdUsuarioCreadorTicket = :IdUsuario";
            }
            $params[':IdUsuario'] = $idUsuario;
        }
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al cargar tickets: " . $e->getMessage());
        }
    }
    // ------------------- FIN FUNCION CargarDatosTickets -------------------


    public function ListarSoportes()
    {
        try {
            $sql = "SELECT u.IdUsuario, CONCAT(u.NombresUsuario, ' ', u.ApellidosUsuario) AS NombreCompleto 
        FROM usuarios u WHERE u.StatusUsuario != :StatusUsuario AND u.RolUsuario = :RolUsuario";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['StatusUsuario' => 0, 'RolUsuario' => 3]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }


    // ------------------- INICIO FUNCIÓN SelectProblemasySubproblemas -------------------
    public function SelectProblemasySubproblemas()
    {
        try {
            $sql = "SELECT p.IdProblema, p.NombreProblema, sp.IdSubproblema, sp.NombreSubproblema
                FROM problemas p, subproblemas sp
                WHERE sp.IdProblema = p.IdProblema 
                AND p.StatusProblema = :StatusProblema
                AND sp.StatusSubproblema = :StatusSubproblema";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'StatusProblema' => 1,
                'StatusSubproblema' => 1,
            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    // ------------------- FIN FUNCIÓN SelectProblemasySubproblemas -------------------

    // ------------------- INICIO FUNCIÓN SelectNombre -------------------
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
    // ------------------- INICIO FUNCIÓN SelectNombre -------------------

    // INICIO FUNCION GuardarTicket - Inserta un nuevo ticket generando el CodTicket antes del insert.
    public function GuardarTicket($datos)
    {
        try {
            $sqlUltimoId = "SELECT MAX(IdTicket) AS UltimoId FROM tickets";
            $stmtMax = $this->db->prepare($sqlUltimoId);
            $stmtMax->execute();
            $resultadoMax = $stmtMax->fetch(PDO::FETCH_ASSOC);
            $nuevoId = isset($resultadoMax['UltimoId']) ? (int) $resultadoMax['UltimoId'] + 1 : 1;
            $codTicket = "TK_" . $nuevoId;
            $campos = [
                'CodTicket' => $codTicket,
                'IdUsuarioCreadorTicket' => $datos['IdUsuarioCreadorTicket'],
                'DepartamentoTicket' => $datos['DepartamentoTicket'],
                'IdProblemaTicket' => $datos['IdProblemaTicket'],
                'IdSubproblemaTicket' => $datos['IdSubproblemaTicket'],
                'DescripcionTicket' => $datos['DescripcionTicket']
            ];
            $sql = "INSERT INTO tickets (CodTicket, IdUsuarioCreadorTicket, DepartamentoTicket, IdProblemaTicket, IdSubproblemaTicket, DescripcionTicket";
            if (isset($datos['IdUsuarioSoporteTicket'])) {
                $sql .= ", IdUsuarioSoporteTicket";
                $campos['IdUsuarioSoporteTicket'] = $datos['IdUsuarioSoporteTicket'];
            }
            $sql .= ") VALUES (:CodTicket, :IdUsuarioCreadorTicket, :DepartamentoTicket, :IdProblemaTicket, :IdSubproblemaTicket, :DescripcionTicket";
            if (isset($datos['IdUsuarioSoporteTicket'])) {
                $sql .= ", :IdUsuarioSoporteTicket";
            }
            $sql .= ")";
            $stmt = $this->db->prepare($sql);
            $resultado = $stmt->execute($campos);

            if (!$resultado) {
                throw new Exception("No se pudo crear el ticket.");
            }

            return true;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    // FIN FUNCION GuardarTicket - Inserta un nuevo ticket generando el CodTicket antes del insert.


    // INICIO FUNCION BuscarTicket 
    public function BuscarTicket($IdTicket)
    {
        try {
            $sql = "SELECT 
                            t.IdTicket,
                            t.CodTicket,
                            t.IdUsuarioCreadorTicket,
                            CONCAT(ut.NombresUsuario, ' ', ut.ApellidosUsuario) AS Trabajador,
                            t.DepartamentoTicket,
                            t.IdProblemaTicket,
                            p.NombreProblema,
                            t.IdSubproblemaTicket,
                            sp.NombreSubproblema,
                            t.IdUsuarioSoporteTicket,
                            CONCAT(us.NombresUsuario, ' ', us.ApellidosUsuario) AS Soporte,
                            t.DataCreateTicket,
                            t.DataUpdateTicket,
                            t.StatusTicket
                        FROM 
                            tickets t
                            LEFT JOIN usuarios ut ON t.IdUsuarioCreadorTicket = ut.IdUsuario
                            LEFT JOIN usuarios us ON t.IdUsuarioSoporteTicket = us.IdUsuario
                            LEFT JOIN problemas p ON t.IdProblemaTicket = p.IdProblema
                            LEFT JOIN subproblemas sp ON t.IdSubproblemaTicket = sp.IdSubproblema
                        WHERE 
                            t.StatusTicket != :StatusTicket
                            AND t.IdTicket = :IdTicket;
                ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['StatusTicket' => 0, 'IdTicket' => $IdTicket]);
            $Ticket = $stmt->fetch(PDO::FETCH_ASSOC);
            return $Ticket;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function BuscarComentarioTicket($IdTicket)
    {
        try {
            $sql = "SELECT 
                        ct.IdComentario,
                        ct.Comentario,
                        ct.FechaComentario,
                        CONCAT(u.NombresUsuario, ' ', u.ApellidosUsuario) AS ComentadoPor
                    FROM 
                        comentarios_tickets ct,
                        usuarios u
                    WHERE 
                        ct.IdUsuarioComentario = u.IdUsuario
                     AND ct.IdTicket = :IdTicket
                     ORDER BY 
                     ct.FechaComentario DESC;
                     ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['IdTicket' => $IdTicket]);
            $Ticket = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $Ticket;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    // FIN FUNCION BuscarTicket 

    // INICIO FUNCION EditarTicket - Actualiza los datos de un ticket existente
    public function EditarTicket($IdTicket, $datos)
    {
        try {
            // Campos obligatorios
            $sql = "UPDATE tickets SET 
                        IdUsuarioCreadorTicket = :IdUsuarioCreadorTicket,
                        DepartamentoTicket = :DepartamentoTicket,
                        IdProblemaTicket = :IdProblemaTicket,
                        IdSubproblemaTicket = :IdSubproblemaTicket,
                        DescripcionTicket = :DescripcionTicket,
                        DataUpdateTicket = NOW()
                        WHERE IdTicket = :IdTicket";

            $params = [
                ':IdUsuarioCreadorTicket' => $datos['IdUsuarioCreadorTicket'],
                ':DepartamentoTicket' => $datos['DepartamentoTicket'],
                ':IdProblemaTicket' => $datos['IdProblemaTicket'],
                ':IdSubproblemaTicket' => $datos['IdSubproblemaTicket'],
                ':DescripcionTicket' => $datos['DescripcionTicket'],
                ':IdTicket' => $IdTicket,
            ];
            $stmt = $this->db->prepare($sql);
            $resultado = $stmt->execute($params);

            if (!$resultado) {
                throw new Exception("No se pudo actualizar el ticket.");
            }
            return true;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
    public function EditarSoporteTicket($IdTicket, $datos)
    {
        try {
            if ($datos['IdUsuarioSoporteTicket'] == null) {
                $sql = "UPDATE tickets SET 
            IdUsuarioSoporteTicket = NULL,
            DataUpdateTicket = NOW() 
            WHERE IdTicket = :IdTicket;";
                $params = [
                    ':IdTicket' => $IdTicket,
                ];
            } else {
                $sql = "UPDATE tickets SET 
            IdUsuarioSoporteTicket = :IdUsuarioSoporteTicket, 
            DataUpdateTicket = NOW() 
            WHERE IdTicket = :IdTicket;";
                $params = [
                    ':IdTicket' => $IdTicket,
                    ':IdUsuarioSoporteTicket' => $datos['IdUsuarioSoporteTicket'],
                ];
            }

            $stmt = $this->db->prepare($sql);
            $resultado = $stmt->execute($params);
            if (!$resultado) {
                throw new Exception("No se pudo actualizar el soporte del ticket.");
            }
            return true;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function GuardarComentarioTicket($datos)
    {
        try {
            $sql = "INSERT INTO comentarios_tickets (IdTicket, IdUsuarioComentario, Comentario, FechaComentario)
                    VALUES (:IdTicket, :IdUsuario, :Comentario, NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':IdTicket' => $datos['IdTicket'],
                ':IdUsuario' => $datos['IdUsuario'],
                ':Comentario' => $datos['Comentario']
            ]);
            return true;
        } catch (Exception $e) {
            throw new Exception("No se pudo insertar el comentario: " . $e->getMessage());
        }
    }



    // INICIO ELIMINAR (DESACTIVAR) UN Ticket (CAMBIAR STATUSUSUARIO A 0)
    public function EliminarTicket($IdTicket)
    {
        try {
            if (empty($IdTicket)) {
                throw new Exception("ID de ticket no proporcionado.");
            }
            $sql = "UPDATE tickets SET StatusTicket = 0 WHERE IdTicket = ?";
            $stmt = $this->db->prepare($sql);
            $resultado = $stmt->execute([$IdTicket]);
            if (!$resultado) {
                throw new Exception("No se pudo eliminar al ticket.");
            }
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    // FIN ELIMINAR (DESACTIVAR) UN ticket

    public function AtenderTicket($IdTicket, $IdUsuarioSoporte)
    {
        try {
            if (empty($IdTicket) || empty($IdUsuarioSoporte)) {
                throw new Exception("ID de ticket o usuario no proporcionado.");
            }
            $sql = "UPDATE tickets 
                    SET 
                        IdUsuarioSoporteTicket = :IdUsuarioSoporteTicket, 
                        StatusTicket = 1 
                    WHERE IdTicket = :IdTicket";
            $params = [
                ':IdUsuarioSoporteTicket' => $IdUsuarioSoporte,
                ':IdTicket' => $IdTicket,
            ];
            $stmt = $this->db->prepare($sql);
            $resultado = $stmt->execute($params);
            if (!$resultado) {
                throw new Exception("No se pudo asignar el ticket.");
            }
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}