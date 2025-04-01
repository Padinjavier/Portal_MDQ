<?php
// C:\wamp64\www\helpmdq\modelos\problemas\ProblemasModelo.php
class ProblemasModelo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db->getConexion();
    }






    // inicio Obtener todos los Problemas
    public function CargarTablaProblemas()
    {
        $sql = "SELECT * FROM problemas WHERE StatusProblema = 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        error_log("Usuarios encontrados: " . count($usuarios));

        return $usuarios;
    }


    // fin Obtener todos los Problemas asignados al módulo de Problemas





    // inicio funcion obtenerporid 
    public function obtenerProblemaPorId($id)
    {
        $sql = "SELECT * FROM problemas WHERE IdProblema = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // fin funcion obtenerporid 





    // inicio Eliminar (desactivar) un Problema (cambiar StatusUsuario a 0)
    public function eliminarProblema($id)
    {
        $sql = "UPDATE problemas SET StatusProblema = 0 WHERE IdProblema = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    // fin Eliminar (desactivar) un Problema (cambiar StatusUsuario a 0)





    // inicio Crear un nuevo Problema
    public function crearProblema($datos)
    {
        $sql = "INSERT INTO problemas (NombreProblema) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        $resultado = $stmt->execute([
            $datos['NombreProblema'],
        ]);
        return $resultado;
    }
    // FIN Crear un nuevo Problema





    // inicio editar un nuevo Problema
    public function editarProblema($id, $datos)
    {
        $sql = "UPDATE problemas 
                  SET NombreProblema = ? WHERE IdProblema = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $datos['NombreProblema'],
            $id,
        ]);
    }
    // fin editar un nuevo Problema








}