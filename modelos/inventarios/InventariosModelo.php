<?php
// C:\wamp64\www\helpmdq\modelos\trabajadores\TrabajadoresModelo.php
class InventariosModelo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db->getConexion();
    }





    // INICIO FUNCION CargarDatosInventarios
    public function CargarDatosInventarios()
    {
        try {
            $sql = "SELECT i.IdInventario, i.NombreInventario, i.CodigoInventario
                FROM inventarios i
                WHERE i.StatusInventario = :StatusInventario";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':StatusInventario' => 1]);
            $Trabajadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $Trabajadores;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    // FIN FUNCION CargarDatosInventarios





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







    

    



}