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
// inicio Obtener todos los trabajadores asignados al módulo de Trabajadores
public function CargarTablaTrabajadores()
{
    $sql = "SELECT u.* 
            FROM usuarios u
            INNER JOIN modulo_roles mr ON u.RolUsuario = mr.IdRol
            INNER JOIN modulos m ON mr.IdModulo = m.IdModulo
            WHERE m.NombreModulo = 'Trabajadores' 
            AND u.StatusUsuario = 1";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    error_log("Usuarios encontrados: " . count($usuarios));

    return $usuarios;
}


// fin Obtener todos los trabajadores asignados al módulo de Trabajadores
// fin Obtener todos los trabajadores (rol = 3)
// return $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);





    // inicio funcion obtenerporid 
    public function obtenerTrabajadorPorId($id)
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





    // inicio Crear un nuevo trabajador
    public function crearTrabajador($datos)
    {
        if ($this->verificarDatosUnicos($datos)) {
            throw new Exception("El correo, DNI, teléfono o nombre de usuario ya están registrados.");
        }
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
    // fin Crear un nuevo trabajador





    // inicio editar un nuevo trabajador
    public function editarTrabajador($id, $datos)
    {
        if ($this->verificarDatosUnicos($datos, $id)) {
            throw new Exception("El correo, DNI, teléfono o nombre de usuario ya están registrados.");
        }
        if (!empty($datos['PasswordUsuario'])) {
            $sql = "UPDATE usuarios 
                  SET NombresUsuario = ?, ApellidosUsuario = ?, TelefonoUsuario = ?, DNIUsuario = ?, CorreoUsuario = ?, UsernameUsuario = ?, PasswordUsuario = ? 
                  WHERE IdUsuario = ? AND RolUsuario = 3";
            $stmt = $this->db->prepare($sql);
            $passwordHash = hash('sha256', $datos['PasswordUsuario']);
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
        return $stmt->execute($params);
    }
    // fin editar un nuevo trabajador





    public function verificarDatosUnicos($datos, $id = null)
    {
        $sql = "SELECT COUNT(*) as count FROM usuarios WHERE (CorreoUsuario = ? OR DNIUsuario = ? OR TelefonoUsuario = ? OR UsernameUsuario = ?)";
        if ($id !== null) {
            $sql .= " AND IdUsuario != ?";
        }
        $stmt = $this->db->prepare($sql);
        $params = [
            $datos['CorreoUsuario'],
            $datos['DNIUsuario'],
            $datos['TelefonoUsuario'],
            $datos['UsernameUsuario']
        ];
        if ($id !== null) {
            $params[] = $id;
        }
        $stmt->execute($params);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['count'] > 0;
    }





// inicio Obtener todos los roles con su estado de asignación
public function CargarRoles()
{
    $sql = "SELECT 
                r.IdRol,
                r.NombreRol,
                COALESCE(m.IdModulo, 'No asignado') AS IdModulo,
                COALESCE(m.NombreModulo, 'No asignado') AS NombreModulo
            FROM rol r
            LEFT JOIN modulo_roles mr ON r.IdRol = mr.IdRol
            LEFT JOIN modulos m ON mr.IdModulo = m.IdModulo
            WHERE r.StatusRol = 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// fin Obtener todos los roles con su estado de asignación





    // inicio guardar configuración de roles
public function guardarConfiguracionMODELO($roles)
{
    try {
        $this->db->beginTransaction();
        $sqlInsert = "INSERT INTO modulo_roles (IdModulo, IdRol) VALUES (2, ?) 
                      ON DUPLICATE KEY UPDATE IdRol = VALUES(IdRol)";
        $stmtInsert = $this->db->prepare($sqlInsert);

        foreach ($roles as $idRol) {
            $stmtInsert->execute([$idRol]);
        }
        $this->db->commit();
        return true;
    } catch (Exception $e) {
        $this->db->rollBack();
        throw new Exception("Error al guardar la configuración: " . $e->getMessage());
    }
}
    // fin guardar configuración de roles





    // inicio eliminar configuración de roles
public function eliminarRelacionModuloRolMODELO($roles)
{
    try {
        $this->db->beginTransaction();
        $sqlDelete = "DELETE FROM modulo_roles WHERE IdModulo = 2 AND IdRol = ?";
        $stmtDelete = $this->db->prepare($sqlDelete);
        foreach ($roles as $idRol) {
            $stmtDelete->execute([$idRol]);
        }
        $this->db->commit();
        return true;
    } catch (Exception $e) {
        $this->db->rollBack();
        throw new Exception("Error al eliminar la relación: " . $e->getMessage());
    }
}
    // fin eliminar configuración de roles





}