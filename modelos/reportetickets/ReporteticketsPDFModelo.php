<?php

class ReporteticketsPDFModelo
{
    private $db;

    public function __construct($db)
    {
         $this->db = $db->getConexion();
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
}
