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


    public function actualizarPermisosRol($idRol, $permisos)
    {
        try {
            $this->db->beginTransaction(); // Iniciar transacción

            foreach ($permisos as $permiso) {
                $idModulo = $permiso['idmodulo'];
                $r = $permiso['r'];
                $w = $permiso['w'];
                $u = $permiso['u'];
                $d = $permiso['d'];

                // Verificar si ya existe el permiso
                $sqlCheck = "SELECT COUNT(*) as existe FROM permisos WHERE idRol = ? AND idModulo = ?";
                $stmt = $this->db->prepare($sqlCheck);
                $stmt->execute([$idRol, $idModulo]);
                $existe = $stmt->fetch(PDO::FETCH_ASSOC)['existe'];

                if ($existe) {
                    // Actualizar permisos existentes
                    $sqlUpdate = "UPDATE permisos SET R = ?, W = ?, U = ?, D = ? WHERE idRol = ? AND idModulo = ?";
                    $stmt = $this->db->prepare($sqlUpdate);
                    $stmt->execute([$r, $w, $u, $d, $idRol, $idModulo]);
                } else {
                    // Insertar nuevo permiso si no existe
                    $sqlInsert = "INSERT INTO permisos (idRol, idModulo, R, W, U, D) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $this->db->prepare($sqlInsert);
                    $stmt->execute([$idRol, $idModulo, $r, $w, $u, $d]);
                }
            }

            // Reordenar permisos después de la actualización
            if (!$this->reordenarPermisos()) {
                throw new Exception("Error al reordenar permisos");
            }
            $this->db->commit(); // Confirmar transacción
            return true;
        } catch (Exception $e) {
            $this->db->rollBack(); // Revertir en caso de error
            return false;
        }
    }



    public function reordenarPermisos()
    {
        try {
            // Eliminar la tabla temporal si existe
            $this->db->exec("DROP TEMPORARY TABLE IF EXISTS temp_permisos");

            // Crear tabla temporal usando InnoDB
            $sqlTemp = "CREATE TEMPORARY TABLE temp_permisos (
                IdRol INT NOT NULL,
                IdModulo INT NOT NULL,
                R TINYINT NOT NULL DEFAULT 0,
                W TINYINT NOT NULL DEFAULT 0,
                U TINYINT NOT NULL DEFAULT 0,
                D TINYINT NOT NULL DEFAULT 0
            ) ENGINE=InnoDB;";
            $this->db->exec($sqlTemp);

            // Insertar datos ordenados en la tabla temporal
            $sqlInsertTemp = "INSERT INTO temp_permisos (IdRol, IdModulo, R, W, U, D)
                              SELECT IdRol, IdModulo, R, W, U, D FROM permisos ORDER BY IdRol, IdModulo;";
            $this->db->exec($sqlInsertTemp);

            // Vaciar la tabla original
            $this->db->exec("TRUNCATE TABLE permisos;");

            // Insertar los datos desde la tabla temporal
            $sqlInsert = "INSERT INTO permisos (IdRol, IdModulo, R, W, U, D)
                          SELECT IdRol, IdModulo, R, W, U, D FROM temp_permisos;";
            $this->db->exec($sqlInsert);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }




}