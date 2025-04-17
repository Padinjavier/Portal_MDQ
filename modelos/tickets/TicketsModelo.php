<?php
// C:\wamp64\www\helpmdq\modelos\trabajadores\TicketsModelo.php
class TicketsModelo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db->getConexion();
    }





    // INICIO FUNCION CargarDatosTickets
    public function CargarDatosTickets()
    {
        try {
            $sql = "SELECT t.CodTicket, CONCAT(ut.NombresUsuario, ut.ApellidosUsuario) AS trabajador, 
                    t.DepartamentoTicket,
                    p.NombreProblema, sp.NombreSubproblema, 
                    t.DataCreateTicket, t.DataUpdateTicket, t.StatusTicket FROM
                    tickets t, usuarios ut,usuarios us, problemas p, subproblemas sp 
                    WHERE t.IdUsuarioCreadorTicket = ut.IdUsuario AND    
                    t.IdUsuarioSoporteTicket = us.IdUsuario AND
                    t.IdProblemaTicket = p.IdProblema AND
                    t.IdSubproblemaTicket = sp.IdSubproblema AND
                    t.StatusTicket != :StatusTicket";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':StatusTicket' => 0]);
            $Trabajadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $Trabajadores;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    // FIN FUNCION CargarDatosTickets





    // INICIO FUNCIÓN: Obtener todos los roles activos con su estado de asignación a módulos 
    public function SelectProblemasySubproblemas()
    {
        try {
            $sql = "SELECT p.IdProblema, p.NombreProblema, sp.IdSubproblema, sp.NombreSubproblema
                FROM problemas p, subproblemas sp
                WHERE sp.IdProblema = p.IdProblema 
                AND p.StatusProblema = :StatusProblema
                AND sp.StatusSubproblema = :StatusSubproblema";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['StatusProblema' => 1,
                            'StatusSubproblema' => 1,
                            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    // FIN FUNCIÓN: Obtener todos los roles activos con su estado de asignación a módulos





    public function SelectNombre($idUsuario, $rolUsuario)
    {
        try {
            if ($rolUsuario == 1) {
                // Administrador: trae todos los usuarios activos
                $sql = "SELECT IdUsuario, CONCAT(NombresUsuario, ' ', ApellidosUsuario) AS NombreCompleto 
                        FROM usuarios 
                        WHERE StatusUsuario != 0";
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
            } else {
                // No administrador: solo su propio usuario
                $sql = "SELECT IdUsuario, CONCAT(NombresUsuario, ' ', ApellidosUsuario) AS NombreCompleto 
                        FROM usuarios 
                        WHERE StatusUsuario != 0 AND IdUsuario = :IdUsuario";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([':IdUsuario' => $idUsuario]);
            }
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener usuarios: " . $e->getMessage());
        }
    }
    






























    


















    // INICIO Crear un nuevo trabajador
    public function GuardarTrabajador($datos)
    {
        try {
            $error = $this->VerificarDatosUnicos($datos);
            if ($error) {
                throw new Exception($error);
            }
            $passwordHash = hash('sha256', $datos['PasswordUsuario']);
            $sql = "INSERT INTO usuarios (NombresUsuario, ApellidosUsuario, TelefonoUsuario, DNIUsuario, CorreoUsuario, UsernameUsuario, PasswordUsuario, RolUsuario) 
                VALUES(:NombresUsuario, :ApellidosUsuario, :TelefonoUsuario, :DNIUsuario, :CorreoUsuario, :UsernameUsuario, :PasswordUsuario, :RolUsuario)";
            $stmt = $this->db->prepare($sql);
            $resultado = $stmt->execute([
                ':NombresUsuario' => $datos['NombresUsuario'],
                ':ApellidosUsuario' => $datos['ApellidosUsuario'],
                ':TelefonoUsuario' => $datos['TelefonoUsuario'],
                ':DNIUsuario' => $datos['DNIUsuario'],
                ':CorreoUsuario' => $datos['CorreoUsuario'],
                ':UsernameUsuario' => $datos['UsernameUsuario'],
                ':PasswordUsuario' => $passwordHash,
                ':RolUsuario' => $datos['RolUsuario']
            ]);
            if (!$resultado) {
                throw new Exception("No se pudo crear el trabajador.");
            }
            return true;
        } catch (Exception $e) {
            throw new Exception( $e->getMessage());
        }
    }
    // FIN Crear un nuevo trabajador





    // INICIO FUNCION BuscarTrabajador 
    public function BuscarTrabajador($IdTrabajador)
    {
        try {
            $sql = "SELECT * FROM usuarios WHERE IdUsuario = :IdUsuario";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['IdUsuario' => $IdTrabajador]);
            $Trabajadores = $stmt->fetch(PDO::FETCH_ASSOC);
            return $Trabajadores;
        } catch (PDOException $e) {
            throw new Exception( $e->getMessage());
        }
    }
    // FIN FUNCION BuscarTrabajador 





    // inicio editar un nuevo trabajador
    public function EditarTrabajador($IdTrabajador, $datos)
    {
        try {
            $error = $this->VerificarDatosUnicos($datos, $IdTrabajador);
            if ($error) {
                throw new Exception($error);
            }
            if (!empty($datos['PasswordUsuario'])) {
                $sql = "UPDATE usuarios SET NombresUsuario = :NombresUsuario, ApellidosUsuario = :ApellidosUsuario, TelefonoUsuario = :TelefonoUsuario, DNIUsuario = :DNIUsuario, 
                                            CorreoUsuario = :CorreoUsuario, UsernameUsuario = :UsernameUsuario, PasswordUsuario = :PasswordUsuario, RolUsuario = :RolUsuario
                        WHERE IdUsuario = :IdUsuario";
                $params = [
                    ':NombresUsuario' => $datos['NombresUsuario'],
                    ':ApellidosUsuario' => $datos['ApellidosUsuario'],
                    ':TelefonoUsuario' => $datos['TelefonoUsuario'],
                    ':DNIUsuario' => $datos['DNIUsuario'],
                    ':CorreoUsuario' => $datos['CorreoUsuario'],
                    ':UsernameUsuario' => $datos['UsernameUsuario'],
                    ':PasswordUsuario' => hash('sha256', $datos['PasswordUsuario']),
                    ':RolUsuario' => $datos['RolUsuario'],
                    ':IdUsuario' => $IdTrabajador
                ];
            } else {
                $sql = "UPDATE usuarios SET NombresUsuario = :NombresUsuario, ApellidosUsuario = :ApellidosUsuario, TelefonoUsuario = :TelefonoUsuario, DNIUsuario = :DNIUsuario,
                                            CorreoUsuario = :CorreoUsuario, UsernameUsuario = :UsernameUsuario, RolUsuario = :RolUsuario
                        WHERE IdUsuario = :IdUsuario";
                $params = [
                    ':NombresUsuario' => $datos['NombresUsuario'],
                    ':ApellidosUsuario' => $datos['ApellidosUsuario'],
                    ':TelefonoUsuario' => $datos['TelefonoUsuario'],
                    ':DNIUsuario' => $datos['DNIUsuario'],
                    ':CorreoUsuario' => $datos['CorreoUsuario'],
                    ':UsernameUsuario' => $datos['UsernameUsuario'],
                    ':RolUsuario' => $datos['RolUsuario'],
                    ':IdUsuario' => $IdTrabajador
                ];
            }
            $stmt = $this->db->prepare($sql);
            $resultado = $stmt->execute($params);
            if (!$resultado) {
                throw new Exception("No se pudo actualizar el trabajador.");
            }
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    // fin editar un trabajador





    // INICIO ELIMINAR (DESACTIVAR) UN TRABAJADOR (CAMBIAR STATUSUSUARIO A 0)
    public function EliminarTrabajador($IdTrabajador)
    {
        try {
            if (empty($IdTrabajador)) {
                throw new Exception("ID de trabajador no proporcionado.");
            }
            $sql = "UPDATE usuarios SET StatusUsuario = 0 WHERE IdUsuario = ?";
            $stmt = $this->db->prepare($sql);
            $resultado =  $stmt->execute([$IdTrabajador]);
            if (!$resultado) {
                throw new Exception("No se pudo eliminar al trabajador.");
            }
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    // FIN ELIMINAR (DESACTIVAR) UN TRABAJADOR





    // INICIO DE FUNCION VERIFICAR DATOS UNICOS  
    public function VerificarDatosUnicos($datos, $IdTrabajador = null)
    {
        try {
            $campos = [
                'CorreoUsuario' => "El correo ya está registrado.",
                'DNIUsuario' => "El DNI ya está registrado.",
                'TelefonoUsuario' => "El teléfono ya está registrado.",
                'UsernameUsuario' => "El nombre de usuario ya está registrado."
            ];
            foreach ($campos as $campo => $mensaje) {
                $sql = "SELECT COUNT(*) as count FROM usuarios WHERE $campo = :valor";
                if ($IdTrabajador !== null) {
                    $sql .= " AND IdUsuario != :IdUsuario";
                }
                $stmt = $this->db->prepare($sql);
                $params = [':valor' => $datos[$campo]];
                if ($IdTrabajador !== null) {
                    $params[':IdUsuario'] = $IdTrabajador;
                }
                $stmt->execute($params);
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($resultado && $resultado['count'] > 0) {
                    return $mensaje;
                }
            }
            return false;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    // FIN DE FUNCION VERIFICAR DATOS UNICOS  








    







    // INICIO FUNCION: Guarda la configuración de roles para el módulo, insertando nuevos registros o actualizando los existentes.
    public function GuardarConfiguracion($roles)
    {
        try {
            $sqlInsert = "INSERT INTO modulo_roles (IdModulo, IdRol) VALUES (IdModulo, :IdRol) 
                          ON DUPLICATE KEY UPDATE IdRol = VALUES(IdRol)";
            $stmtInsert = $this->db->prepare($sqlInsert);
            foreach ($roles as $idRol) {
                $stmtInsert->execute([':IdRol' => $idRol, ':IdModulo' => 2]);
            }
            return true;
        } catch (Exception $e) {
            throw new Exception("Error al guardar la configuración: " . $e->getMessage());
        }
    }
    // FIN FUNCION: Guarda la configuración de roles para el módulo, insertando nuevos registros o actualizando los existentes.





    // INICIO FUNCION: Elimina relaciones entre módulos y roles (IdModulo fijo = 2)
    public function eliminarRelacionModuloRolMODELO(array $roles): bool
    {
        try {
            $sqlDelete = "DELETE FROM modulo_roles WHERE IdModulo = :IdModulo AND IdRol = :IdRol";
            $stmtDelete = $this->db->prepare($sqlDelete);
            foreach ($roles as $idRol) {
                $stmtDelete->execute([
                    ':IdModulo' => 2,  // Valor fijo pasado como parámetro nombrado
                    ':IdRol' => $idRol // Variable referenciada con nombre consistente
                ]);
            }
            if ($stmtDelete->rowCount() > 0) {
                return true; // Se eliminaron registros
            } else {
                return false; // No se eliminaron registros
            }
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar la relación: " . $e->getMessage());
        }
    }
    // FIN FUNCION: Elimina relaciones entre módulos y roles (IdModulo fijo = 2)





}