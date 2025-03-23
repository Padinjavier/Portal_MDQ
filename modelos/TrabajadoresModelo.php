<?php
// C:\wamp64\www\helpmdq\modelos\TrabajadoresModelo.php
class TrabajadoresModelo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db->getConexion();
    }






    // inicio Obtener todos los trabajadores (rol = 3)
    public function CargarTablaTrabajadores()
    {
        $sql = "SELECT * FROM usuarios WHERE RolUsuario = 3 AND StatusUsuario = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  // fin Obtener todos los trabajadores (rol = 3)





    // inicio funcion obtenerporid 
    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM usuarios WHERE IdUsuario = ? AND RolUsuario = 3";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
   // fin funcion obtenerporid 





    // inicio Eliminar (desactivar) un trabajador (cambiar StatusUsuario a 0)
    public function eliminarTrabajador($id)
    {
        $sql = "UPDATE usuarios SET StatusUsuario = 0 WHERE IdUsuario = ? AND RolUsuario = 3";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    // fin Eliminar (desactivar) un trabajador (cambiar StatusUsuario a 0)





    // Crear un nuevo trabajador
    public function crearTrabajador($datos)
    {
        $sql = "INSERT INTO usuarios (NombresUsuario, ApellidosUsuario, TelefonoUsuario, DNIUsuario, CorreoUsuario, UsernameUsuario, PasswordUsuario, RolUsuario) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 3)";
        $stmt = $this->db->prepare($sql);
        $passwordHash = hash('sha256', $datos['PasswordUsuario']);
        return $stmt->execute([
            $datos['NombresUsuario'],
            $datos['ApellidosUsuario'],
            $datos['TelefonoUsuario'],
            $datos['DNIUsuario'],
            $datos['CorreoUsuario'],
            $datos['UsernameUsuario'],
            $passwordHash
        ]);
    }

    public function editarTrabajador($id, $datos)
    {
        // Verificar si el campo "PasswordUsuario" está presente y no está vacío
        if (!empty($datos['PasswordUsuario'])) {
            // Si hay contraseña, actualizarla junto con los demás campos
            $sql = "UPDATE usuarios 
                    SET NombresUsuario = ?, ApellidosUsuario = ?, TelefonoUsuario = ?, DNIUsuario = ?, CorreoUsuario = ?, UsernameUsuario = ?, PasswordUsuario = ? 
                    WHERE IdUsuario = ? AND RolUsuario = 3";
            $stmt = $this->db->prepare($sql);
            $passwordHash = hash('sha256', $datos['PasswordUsuario']); // Hashear la contraseña
            $params = [
                $datos['NombresUsuario'],
                $datos['ApellidosUsuario'],
                $datos['TelefonoUsuario'],
                $datos['DNIUsuario'],
                $datos['CorreoUsuario'],
                $datos['UsernameUsuario'],
                $passwordHash,
                $id
            ];
        } else {
            // Si no hay contraseña, actualizar solo los demás campos
            $sql = "UPDATE usuarios 
                    SET NombresUsuario = ?, ApellidosUsuario = ?, TelefonoUsuario = ?, DNIUsuario = ?, CorreoUsuario = ?, UsernameUsuario = ? 
                    WHERE IdUsuario = ? AND RolUsuario = 3";
            $stmt = $this->db->prepare($sql);
            $params = [
                $datos['NombresUsuario'],
                $datos['ApellidosUsuario'],
                $datos['TelefonoUsuario'],
                $datos['DNIUsuario'],
                $datos['CorreoUsuario'],
                $datos['UsernameUsuario'],
                $id
            ];
        }
    
        // Ejecutar la consulta
        return $stmt->execute($params);
    }

    // Buscar trabajadores según filtros
    public function buscarTrabajador($filtros)
    {
        $sql = "SELECT * FROM usuarios WHERE RolUsuario = 3 AND StatusUsuario = 1";
        $params = [];

        // Aplicar filtros dinámicos
        if (!empty($filtros['NombresUsuario'])) {
            $sql .= " AND NombresUsuario LIKE ?";
            $params[] = '%' . $filtros['NombresUsuario'] . '%';
        }
        if (!empty($filtros['ApellidosUsuario'])) {
            $sql .= " AND ApellidosUsuario LIKE ?";
            $params[] = '%' . $filtros['ApellidosUsuario'] . '%';
        }
        if (!empty($filtros['DNIUsuario'])) {
            $sql .= " AND DNIUsuario = ?";
            $params[] = $filtros['DNIUsuario'];
        }
        if (!empty($filtros['CorreoUsuario'])) {
            $sql .= " AND CorreoUsuario LIKE ?";
            $params[] = '%' . $filtros['CorreoUsuario'] . '%';
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}