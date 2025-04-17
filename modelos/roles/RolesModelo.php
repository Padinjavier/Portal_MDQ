<?php
// C:\wamp64\www\helpmdq\modelos\roles\RolesModelo.php
class RolesModelo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db->getConexion();
    }






    // inicio Obtener todos los Roles
    public function CargarTablaRoles()
    {
        $sql = "SELECT * FROM rol WHERE StatusRol = 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        error_log("Usuarios encontrados: " . count($usuarios));

        return $usuarios;
    }


    // fin Obtener todos los Roles asignados al módulo de Roles





    // inicio funcion obtenerporid 
    public function obtenerRolPorId($id)
    {
        $sql = "SELECT * FROM rol WHERE IdRol = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // fin funcion obtenerporid 





    // inicio Eliminar (desactivar) un rol (cambiar StatusUsuario a 0)
    public function eliminarRol($id)
    {
        $sql = "UPDATE rol SET StatusRol = 0 WHERE IdRol = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    // fin Eliminar (desactivar) un rol (cambiar StatusUsuario a 0)





    // inicio Crear un nuevo Rol
    public function crearRol($datos)
    {
        $sql = "INSERT INTO rol (NombreRol, DescripcionRol) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $resultado = $stmt->execute([
            $datos['NombreRol'],
            $datos['DescripcionRol'],
        ]);

        if ($resultado) {
            // Obtener el ID del último rol insertado
            $IdRol = $this->db->lastInsertId();
            $this->asignarPermisosPorDefecto($IdRol);
        }

        return $resultado;
    }
    // FIN Crear un nuevo Rol





    // INICIO Función para asignar permisos a un rol ya creado
    public function asignarPermisosPorDefecto($IdRol)
    {
        try {
            $sql = "INSERT INTO permisos (IdRol, IdModulo, R, W, U, D)
                SELECT ?, IdModulo, 0, 0, 0, 0 FROM modulos";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$IdRol]);
        } catch (Exception $e) {
            return false;
        }
    }
    // FIN Función para asignar permisos a un rol ya creado





    // inicio editar un nuevo rol
    public function editarRol($id, $datos)
    {
        $sql = "UPDATE rol 
                  SET NombreRol = ?, DescripcionRol = ? WHERE IdRol = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $datos['NombreRol'],
            $datos['DescripcionRol'],
            $id,
        ]);
    }
    // fin editar un nuevo rol





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





    // inicio editar un nuevo rol
    public function selectmodulos()
    {
        $sql = "SELECT * FROM modulos WHERE StatusModulo = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // fin editar un nuevo rol

    // inicio editar un nuevo rol
    public function permisoRol($id)
    {
        $sql = "SELECT * FROM permisos WHERE IdRol = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // fin editar un nuevo rol


// INICIO FUNCION guardarPermisos - Guarda o actualiza permisos por módulo para un rol dado.// INICIO FUNCION guardarPermisos - Guarda o actualiza los permisos de un rol sobre los módulos definidos.
public function guardarPermisos($idRol, $permisos)
{
    try {
        foreach ($permisos as $permiso) {
            $idmodulo = $permiso['idmodulo'];
            $r = $permiso['r'];
            $w = $permiso['w'];
            $u = $permiso['u'];
            $d = $permiso['d'];
            $sqlCheck = "SELECT COUNT(*) as existe FROM permisos WHERE idRol = :idRol AND idModulo = :idmodulo";
            $stmtCheck = $this->db->prepare($sqlCheck);
            $stmtCheck->execute([
                ':idRol'    => $idRol,
                ':idmodulo' => $idmodulo
            ]);
            $fila = $stmtCheck->fetch(PDO::FETCH_ASSOC);
            $existe = $fila['existe'];
            if ($existe) {
                $sqlUpdate = "UPDATE permisos 
                              SET R = :r, W = :w, U = :u, D = :d 
                              WHERE idRol = :idRol AND idModulo = :idmodulo";
                $stmtUpdate = $this->db->prepare($sqlUpdate);
                $stmtUpdate->execute([
                    ':r'        => $r,
                    ':w'        => $w,
                    ':u'        => $u,
                    ':d'        => $d,
                    ':idRol'    => $idRol,
                    ':idmodulo' => $idmodulo
                ]);
            } else {
                $sqlInsert = "INSERT INTO permisos (idRol, idModulo, R, W, U, D)
                              VALUES (:idRol, :idmodulo, :r, :w, :u, :d)";
                $stmtInsert = $this->db->prepare($sqlInsert);
                $stmtInsert->execute([
                    ':idRol'    => $idRol,
                    ':idmodulo' => $idmodulo,
                    ':r'        => $r,
                    ':w'        => $w,
                    ':u'        => $u,
                    ':d'        => $d
                ]);
            }
        }
        $reordenado = $this->reordenarPermisos();
        return $reordenado;

    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}





// INICIO FUNCION reordenarPermisos - Reordena los registros de permisos mediante tabla temporal.
public function reordenarPermisos()
{
    try {
        $sqlDrop = "DROP TEMPORARY TABLE IF EXISTS temp_permisos";
        $this->db->exec($sqlDrop);
        $sqlCreate = "CREATE TEMPORARY TABLE temp_permisos (
            IdRol INT NOT NULL,
            IdModulo INT NOT NULL,
            R TINYINT NOT NULL DEFAULT 0,
            W TINYINT NOT NULL DEFAULT 0,
            U TINYINT NOT NULL DEFAULT 0,
            D TINYINT NOT NULL DEFAULT 0
        ) ENGINE=InnoDB";
        $this->db->exec($sqlCreate);
        $sqlInsertTemp = "INSERT INTO temp_permisos (IdRol, IdModulo, R, W, U, D)
                          SELECT IdRol, IdModulo, R, W, U, D FROM permisos ORDER BY IdRol, IdModulo";
        $this->db->exec($sqlInsertTemp);
        $sqlTruncate = "TRUNCATE TABLE permisos";
        $this->db->exec($sqlTruncate);
        $sqlRestore = "INSERT INTO permisos (IdRol, IdModulo, R, W, U, D)
                       SELECT IdRol, IdModulo, R, W, U, D FROM temp_permisos";
        $this->db->exec($sqlRestore);
        $resultado = true;
        return $resultado;
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}
// FIN FUNCION reordenarPermisos - Reordena los registros de permisos mediante tabla temporal.





}