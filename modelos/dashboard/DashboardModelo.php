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
}
?>