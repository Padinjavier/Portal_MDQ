<?php
// C:\wamp64\www\helpmdq\modelos\subproblemas\SubproblemasModelo.php
class SubproblemasModelo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db->getConexion();
    }






    // inicio Obtener todos los Subproblemas
    public function CargarTablaSubproblemas()
    {
        $sql = "SELECT * FROM subproblemas sp, problemas p WHERE sp.IdProblema = p.IdProblema AND sp.StatusSubproblema = 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        error_log("Usuarios encontrados: " . count($usuarios));

        return $usuarios;
    }


    // fin Obtener todos los subproblemas asignados al módulo de subproblemas





    // inicio funcion obtenerporid 
    public function obtenerSubproblemaPorId($id)
    {
        $sql = "SELECT * FROM subproblemas sp, problemas p WHERE sp.IdProblema = p.IdProblema AND IdSubproblema = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // fin funcion obtenerporid 





    // inicio Eliminar (desactivar) un subproblema (cambiar StatusUsuario a 0)
    public function eliminarSubproblema($id)
    {
        $sql = "UPDATE subproblemas SET StatusSubproblema = 0 WHERE IdSubproblema = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    // fin Eliminar (desactivar) un subproblema (cambiar StatusUsuario a 0)





    // inicio Crear un nuevo subproblema
    public function crearSubproblema($datos)
    {
        $sql = "INSERT INTO subproblemas (IdProblema, NombreSubproblema) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $resultado = $stmt->execute([
            $datos['IdProblema'],
            $datos['NombreSubproblema'],
        ]);
        return $resultado;
    }
    // FIN Crear un nuevo subproblema





    // inicio editar un nuevo subproblema
    public function editarSubproblema($id, $datos)
    {
        $sql = "UPDATE subproblemas 
                  SET IdProblema = ?, NombreSubproblema = ? WHERE IdSubproblema = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $datos['IdProblema'],
            $datos['NombreSubproblema'],
            $id,
        ]);
    }
    // fin editar un nuevo subproblema





    // inicio Obtener todos los roles con su estado de asignación
    public function CargarProblemas()
    {
        $sql = "SELECT * FROM problemas WHERE StatusProblema = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // fin Obtener todos los roles con su estado de asignación



}