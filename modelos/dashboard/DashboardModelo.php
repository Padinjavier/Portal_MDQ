<?php
// C:\wamp64\www\helpmdq\modelos\dashboard\DashboardModelo.php
class DashboardModelo
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db->getConexion();
    }





    public function ResumenGeneral()
    {
        $sql = "SELECT 
                (SELECT COUNT(*) FROM usuarios u, rol r WHERE r.IdRol = u.RolUsuario AND r.NombreRol = 'Trabajador') AS total_trabajadores,
                (SELECT COUNT(*) FROM usuarios u, rol r WHERE r.IdRol = u.RolUsuario AND r.NombreRol = 'Soporte') AS total_soporte,
                (SELECT COUNT(*) FROM rol) AS total_roles,
                (SELECT COUNT(*) FROM problemas) AS total_problemas,
                (SELECT COUNT(*) FROM tickets t WHERE t.IdTicket != 0 ) AS total_tickets
            ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }





    public function EstadoTickets()
    {
        $sql = "SELECT 
                (SELECT COUNT(*) FROM tickets WHERE StatusTicket = 1) AS TicketsAbiertos,
                (SELECT COUNT(*) FROM tickets WHERE StatusTicket = 2) AS TicketsEnAtencion,
                (SELECT COUNT(*) FROM tickets WHERE StatusTicket = 3) AS TicketsResueltos,
                (SELECT COUNT(*) FROM tickets WHERE StatusTicket = 4) AS TicketsReabiertos,
                (SELECT COUNT(*) FROM tickets WHERE StatusTicket = 5) AS TicketsCerrados;
            ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


 public function TicketsPorDia()
{
    $sql = "SELECT DATE(DataCreateTicket) AS fecha, COUNT(*) AS total 
            FROM tickets 
            GROUP BY DATE(DataCreateTicket) 
            ORDER BY fecha DESC 
            LIMIT 30";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function TicketsPorTecnico()
{
    $sql = "SELECT u.NombresUsuario AS tecnico, COUNT(*) AS total 
            FROM tickets t
            JOIN usuarios u ON t.IdUsuarioSoporteTicket= u.IdUsuario
            GROUP BY u.NombresUsuario
            ORDER BY total DESC
            LIMIT 10";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function TicketsPorProblema()
{
    $sql = "SELECT p.NombreProblema AS problema, COUNT(*) AS total
            FROM tickets t
            JOIN problemas p ON t.IdProblemaTicket= p.IdProblema
            GROUP BY p.NombreProblema
            ORDER BY total DESC
            LIMIT 10";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
?>