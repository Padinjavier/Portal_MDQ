<?php

class ReporteticketsPDFModelo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db->getConexion();
    }

    
    public function SelectTrabajadores()
    {
        try {
            $sql = "SELECT u.IdUsuario, CONCAT(u.NombresUsuario, ' ', u.ApellidosUsuario) AS NombreCompleto
                    FROM usuarios u
                    INNER JOIN tickets t ON u.IdUsuario = t.IdUsuarioCreadorTicket
                    WHERE u.StatusUsuario != :StatusUsuario
                    AND t.StatusTicket != :StatusTicket
                    GROUP BY u.IdUsuario;";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':StatusUsuario' => 0, ':StatusTicket' => 0]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener usuarios: " . $e->getMessage());
        }
    }

    public function SelectSoportes()
    {
        try {
            $sql = "SELECT u.IdUsuario, CONCAT(u.NombresUsuario, ' ', u.ApellidosUsuario) AS NombreCompleto
                    FROM usuarios u
                    INNER JOIN tickets t ON u.IdUsuario = t.IdUsuarioSoporteTicket
                    WHERE u.StatusUsuario != :StatusUsuario
                    AND t.StatusTicket != :StatusTicket
                    GROUP BY u.IdUsuario;";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':StatusUsuario' => 0, ':StatusTicket' => 0]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener usuarios: " . $e->getMessage());
        }
    }

    public function SelectDepartamentos()
    {
        try {
            $sql = "SELECT DISTINCT DepartamentoTicket
                    FROM tickets
                    WHERE StatusTicket != :StatusTicket;";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':StatusTicket' => 0]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener usuarios: " . $e->getMessage());
        }
    }

    public function SelectProblemasUsados()
    {
        try {
            $sql = "SELECT DISTINCT p.IdProblema, p.NombreProblema
                FROM tickets t
                INNER JOIN problemas p ON t.IdProblemaTicket = p.IdProblema
                WHERE t.StatusTicket != 0 AND p.StatusProblema = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener problemas usados: " . $e->getMessage());
        }
    }

    public function SelectSubproblemasUsados($idProblema)
    {
        try {
            $sql = "SELECT DISTINCT s.IdSubproblema, s.NombreSubproblema
                FROM tickets t
                INNER JOIN subproblemas s ON t.IdSubproblemaTicket = s.IdSubproblema
                WHERE t.StatusTicket != 0
                  AND s.StatusSubproblema = 1
                  AND s.IdProblema = :idProblema";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':idProblema' => $idProblema]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener subproblemas usados: " . $e->getMessage());
        }
    }

    public function ObtenerTicketYComentarios($codigo)
    {
        try {
            $sql = "
                SELECT 
                    t.CodTicket,
                    CONCAT(u.NombresUsuario, ' ', u.ApellidosUsuario) AS Creador,
                    p.NombreProblema,
                    sp.NombreSubproblema,
                    t.DepartamentoTicket,
                    t.DataCreateTicket,
                    t.DataUpdateTicket,
                    t.StatusTicket,
                    c.Comentario,
                    c.FechaComentario,
                    CONCAT(us.NombresUsuario, ' ', us.ApellidosUsuario) AS UsuarioComentario
                FROM tickets t
                INNER JOIN usuarios u ON t.IdUsuarioCreadorTicket = u.IdUsuario
                LEFT JOIN problemas p ON t.IdProblemaTicket = p.IdProblema
                LEFT JOIN subproblemas sp ON t.IdSubproblemaTicket = sp.IdSubproblema
                LEFT JOIN comentarios_tickets c ON t.IdTicket = c.IdTicket
                LEFT JOIN usuarios us ON c.IdUsuarioComentario = us.IdUsuario
                WHERE t.CodTicket = :codigo
                ORDER BY c.FechaComentario ASC
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':codigo' => $codigo]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new Exception("Error al obtener datos del ticket: " . $e->getMessage());
        }
    }


    public function ObtenerTicketsPorFechaHora($fechaDesde, $fechaHasta)
    {
        try {
            $sql = "
            SELECT 
                t.IdTicket,
                t.CodTicket,
                CONCAT(u.NombresUsuario, ' ', u.ApellidosUsuario) AS Creador,
                t.DataCreateTicket,
                c.Comentario,
                c.FechaComentario,
                CONCAT(ucom.NombresUsuario, ' ', ucom.ApellidosUsuario) AS UsuarioComentario
            FROM tickets t
            INNER JOIN usuarios u ON t.IdUsuarioCreadorTicket = u.IdUsuario
            LEFT JOIN comentarios_tickets c ON c.IdTicket = t.IdTicket
            LEFT JOIN usuarios ucom ON ucom.IdUsuario = c.IdUsuarioComentario
            WHERE t.DataCreateTicket BETWEEN :fechaDesde AND :fechaHasta
            ORDER BY t.DataCreateTicket ASC, c.FechaComentario ASC
        ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':fechaDesde' => $fechaDesde,
                ':fechaHasta' => $fechaHasta
            ]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new Exception("Error al obtener tickets por fecha y hora: " . $e->getMessage());
        }
    }

public function PorTrabajadorPDF($IdUsuarioCreadorTicketReporte)
{
    try {
        $sql = "
            SELECT 
                t.IdTicket,
                t.CodTicket,
                CONCAT(u.NombresUsuario, ' ', u.ApellidosUsuario) AS Creador,
                t.DataCreateTicket,
                c.Comentario,
                c.FechaComentario,
                CONCAT(ucom.NombresUsuario, ' ', ucom.ApellidosUsuario) AS UsuarioComentario
            FROM tickets t
            INNER JOIN usuarios u ON t.IdUsuarioCreadorTicket = u.IdUsuario
            LEFT JOIN comentarios_tickets c ON c.IdTicket = t.IdTicket
            LEFT JOIN usuarios ucom ON ucom.IdUsuario = c.IdUsuarioComentario
            WHERE t.IdUsuarioCreadorTicket = :IdUsuarioCreadorTicketReporte
              AND t.StatusTicket != 0
            ORDER BY t.DataCreateTicket ASC, c.FechaComentario ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':IdUsuarioCreadorTicketReporte' => $IdUsuarioCreadorTicketReporte
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        throw new Exception("Error al obtener tickets por creador: " . $e->getMessage());
    }
}

public function PorSoportePDF($IdUsuarioSoporteTicketReporte)
{
    try {
        $sql = "
            SELECT 
                t.IdTicket,
                t.CodTicket,
                CONCAT(u.NombresUsuario, ' ', u.ApellidosUsuario) AS Creador,
                t.DataCreateTicket,
                t.DataUpdateTicket,
                t.DepartamentoTicket,
                t.StatusTicket,
                CONCAT(usop.NombresUsuario, ' ', usop.ApellidosUsuario) AS UsuarioSoporte,
                p.NombreProblema,
                sp.NombreSubproblema,
                c.Comentario,
                c.FechaComentario,
                CONCAT(ucom.NombresUsuario, ' ', ucom.ApellidosUsuario) AS UsuarioComentario
            FROM tickets t
            INNER JOIN usuarios u ON t.IdUsuarioCreadorTicket = u.IdUsuario
            INNER JOIN usuarios usop ON t.IdUsuarioSoporteTicket = usop.IdUsuario
            LEFT JOIN problemas p ON t.IdProblemaTicket = p.IdProblema
            LEFT JOIN subproblemas sp ON t.IdSubproblemaTicket = sp.IdSubproblema
            LEFT JOIN comentarios_tickets c ON c.IdTicket = t.IdTicket
            LEFT JOIN usuarios ucom ON ucom.IdUsuario = c.IdUsuarioComentario
            WHERE t.IdUsuarioSoporteTicket = :IdUsuarioSoporteTicketReporte
              AND t.StatusTicket != 0
            ORDER BY t.DataCreateTicket ASC, c.FechaComentario ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':IdUsuarioSoporteTicketReporte' => $IdUsuarioSoporteTicketReporte
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        throw new Exception("Error al obtener tickets por soporte: " . $e->getMessage());
    }
}






}
