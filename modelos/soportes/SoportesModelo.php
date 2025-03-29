<?php
// C:\wamp64\www\helpmdq\modelos\soportes\SoportesModelo.php
class SoportesModelo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db->getConexion();
    }






    // inicio Obtener todos los Soportes (rol = 2)
// inicio Obtener todos los Soportes asignados al módulo de Soportes
    public function CargarTablaSoportes()
    {
        $sql = "SELECT u.*, r.NombreRol
                FROM usuarios u, rol r,modulo_roles mr ,modulos m
                WHERE m.NombreModulo = 'Soportes' 
                AND u.StatusUsuario = 1 
                AND u.RolUsuario = r.IdRol
                AND mr.IdRol = u.RolUsuario
                AND mr.IdModulo = m.IdModulo";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        error_log("Usuarios encontrados: " . count($usuarios));

        return $usuarios;
    }


    // fin Obtener todos los Soportes asignados al módulo de Soportes
// fin Obtener todos los Soportes (rol = 2)
// return $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);





    // inicio funcion obtenerporid 
    public function obtenerSoportePorId($id)
    {
        $sql = "SELECT * FROM usuarios WHERE IdUsuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // fin funcion obtenerporid 





    // inicio Eliminar (desactivar) un Soporte (cambiar StatusUsuario a 0)
    public function eliminarSoporte($id)
    {
        $sql = "UPDATE usuarios SET StatusUsuario = 0 WHERE IdUsuario = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    // fin Eliminar (desactivar) un Soporte (cambiar StatusUsuario a 0)





    // inicio Crear un nuevo Soporte
    public function crearSoporte($datos)
    {
        $error = $this->verificarDatosUnicos($datos);
        if ($error) {
            throw new Exception($error);
        }
        $sql = "INSERT INTO usuarios (NombresUsuario, ApellidosUsuario, TelefonoUsuario, DNIUsuario, CorreoUsuario, UsernameUsuario, PasswordUsuario, RolUsuario) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $passwordHash = hash('sha256', $datos['PasswordUsuario']);
        return $stmt->execute([
            $datos['NombresUsuario'],
            $datos['ApellidosUsuario'],
            $datos['TelefonoUsuario'],
            $datos['DNIUsuario'],
            $datos['CorreoUsuario'],
            $datos['UsernameUsuario'],
            $passwordHash,
            $datos['RolUsuario'],
        ]);
    }
    // fin Crear un nuevo Soporte





    // inicio editar un nuevo Soporte
    public function editarSoporte($id, $datos)
    {
        $error = $this->verificarDatosUnicos($datos, $id);
        if ($error) {
            throw new Exception($error);
        }
        if (!empty($datos['PasswordUsuario'])) {
            $sql = "UPDATE usuarios 
                  SET NombresUsuario = ?, ApellidosUsuario = ?, TelefonoUsuario = ?, DNIUsuario = ?, CorreoUsuario = ?, UsernameUsuario = ?, PasswordUsuario = ?, RolUsuario = ? 
                  WHERE IdUsuario = ?";
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
                $datos['RolUsuario'],
                $id
            ];
        } else {
            $sql = "UPDATE usuarios 
                  SET NombresUsuario = ?, ApellidosUsuario = ?, TelefonoUsuario = ?, DNIUsuario = ?, CorreoUsuario = ?, UsernameUsuario = ?, RolUsuario = ? 
                  WHERE IdUsuario = ?";
            $stmt = $this->db->prepare($sql);
            $params = [
                $datos['NombresUsuario'],
                $datos['ApellidosUsuario'],
                $datos['TelefonoUsuario'],
                $datos['DNIUsuario'],
                $datos['CorreoUsuario'],
                $datos['UsernameUsuario'],
                $datos['RolUsuario'],
                $id
            ];
        }
        return $stmt->execute($params);
    }
    // fin editar un nuevo Soporte





    public function verificarDatosUnicos($datos, $id = null)
    {
        $campos = [
            'CorreoUsuario' => "El correo ya está registrado.",
            'DNIUsuario' => "El DNI ya está registrado.",
            'TelefonoUsuario' => "El teléfono ya está registrado.",
            'UsernameUsuario' => "El nombre de usuario ya está registrado."
        ];
        foreach ($campos as $campo => $mensaje) {
            $sql = "SELECT COUNT(*) as count FROM usuarios WHERE $campo = ?";
            if ($id !== null) {
                $sql .= " AND IdUsuario != ?";
            }
            $stmt = $this->db->prepare($sql);
            $params = ($id !== null) ? [$datos[$campo], $id] : [$datos[$campo]];
            $stmt->execute($params);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado['count'] > 0) {
                return $mensaje; // Retorna el mensaje del error encontrado
            }
        }
         return false; // No hay duplicados
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





    // inicio guardar configuración de roles que se muestran en las tablas tener en cuenta el ID del modulo cambia dependiendo del modulo donde se aplique
    public function guardarConfiguracionMODELO($roles)
    {
        try {
            $this->db->beginTransaction();
            $sqlInsert = "INSERT INTO modulo_roles (IdModulo, IdRol) VALUES (3, ?) 
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





    // inicio eliminar configuración de roles que se muestran en las tablas tener en cuenta el ID del modulo cambia dependiendo del modulo donde se aplique 
    public function eliminarRelacionModuloRolMODELO($roles)
    {
        try {
            $this->db->beginTransaction();
            $sqlDelete = "DELETE FROM modulo_roles WHERE IdModulo = 3 AND IdRol = ?";
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