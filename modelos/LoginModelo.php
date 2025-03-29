<?php
// C:\wamp64\www\internet\modelos\LoginModelo.php

class LoginModelo {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConexion();
    }
    // Inicia sesión y verifica las credenciales del usuario con SHA-256
    public function loginUsuario($usernameusuario, $passwordusuario) {
        // Obtiene los datos del usuario
        $sql = "SELECT u.IdUsuario, u.NombresUsuario, u.ApellidosUsuario, u.CorreoUsuario, u.UsernameUsuario, u.PasswordUsuario, u.RolUsuario, r.NombreRol , u.StatusUsuario
                FROM (usuarios u,rol r)
                WHERE  u.RolUsuario = r.IdRol AND UsernameUsuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usernameusuario]);
        $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Hashea la contraseña ingresada con SHA-256
        $passwordusuarioHash = hash('sha256', $passwordusuario);
    
        // Verifica si la contraseña coincide
        if ($usuarioData && $passwordusuarioHash === $usuarioData['PasswordUsuario']) {
            session_start();
    
            // Guarda datos básicos del usuario en la sesión
            $_SESSION['Login_IdUsuario'] = $usuarioData['IdUsuario'];
            $_SESSION['Login_NombresUsuario'] = $usuarioData['NombresUsuario'];
            $_SESSION['Login_ApellidosUsuario'] = $usuarioData['ApellidosUsuario'];
            $_SESSION['Login_CorreoUsuario'] = $usuarioData['CorreoUsuario'];
            $_SESSION['Login_UsernameUsuario'] = $usuarioData['UsernameUsuario'];
            $_SESSION['Login_RolUsuario'] = $usuarioData['RolUsuario'];
            $_SESSION['Login_NombreRol'] = $usuarioData['NombreRol'];
            $_SESSION['Login_StatusUsuario'] = $usuarioData['StatusUsuario'];
    
            // Obtener permisos del usuario
            $sqlPermisos = "SELECT m.NombreModulo, p.R, p.W, p.U, p.D 
                            FROM permisos p
                            JOIN modulos m ON p.IdModulo = m.IdModulo
                            WHERE p.IdRol = ?";
            $stmtPermisos = $this->db->prepare($sqlPermisos);
            $stmtPermisos->execute([$usuarioData['RolUsuario']]);
            $permisos = $stmtPermisos->fetchAll(PDO::FETCH_ASSOC);
    
            // Almacenar permisos en la sesión
            $_SESSION['Login_Permisos'] = [];
            foreach ($permisos as $permiso) {
                $_SESSION['Login_Permisos'][$permiso['NombreModulo']] = [
                    'Leer' => $permiso['R'],
                    'Escribir' => $permiso['W'],
                    'Actualizar' => $permiso['U'],
                    'Eliminar' => $permiso['D']
                ];
            }
    
            return true; // Inicio de sesión exitoso
        }
    
        return "Usuario o contraseña incorrectos.";
    }    

    // Obtiene los datos de un usuario por su nombre de usuario
    public function obtenerUsuarioPorNombre($usernameusuario) {
        $sql = "SELECT IdUsuario, NombresUsuario,ApellidosUsuario, CorreoUsuario, UsernameUsuario, RolUsuario, StatusUsuario FROM usuarios WHERE UsernameUsuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usernameusuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve los datos del usuario
    }
}
?>