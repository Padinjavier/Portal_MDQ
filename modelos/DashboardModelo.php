<?php

class DashboardModelo {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConexion();
    }

    public function getDashboardData() {
        $sql = "SELECT 
                (SELECT COUNT(*) FROM usuarios u, rol r WHERE r.idrol = u.rol AND r.nombre_rol = 'trabajadores') AS total_trabajadores,
                (SELECT COUNT(*) FROM usuarios u, rol r WHERE r.idrol = u.rol AND r.nombre_rol = 'soporte') AS total_soporte,
                (SELECT COUNT(*) FROM rol) AS total_roles,
                (SELECT COUNT(*) FROM computadoras) AS total_inventario,
                (SELECT COUNT(*) FROM problema) AS total_problemas,
                (SELECT COUNT(*) FROM tickets) AS total_tickets,
                (SELECT COUNT(*) FROM tickets WHERE status = 1) AS abiertos,
                (SELECT COUNT(*) FROM tickets WHERE status = 2) AS en_atencion,
                (SELECT COUNT(*) FROM tickets WHERE status = 3) AS resueltos,
                (SELECT COUNT(*) FROM tickets WHERE status = 4) AS reabiertos,
                (SELECT COUNT(*) FROM tickets WHERE status = 5) AS cerrados;
            ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$sql]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
