<?php
// C:\wamp64\www\internet\modelos\LoginModelo.php

class LoginModelo {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConexion();
    }

    // Inicia sesión y verifica las credenciales del usuario
    public function loginUsuario($username, $contrasena) {
        // Obtiene los datos del usuario
        $sql = "SELECT id, nombres, apellidos, username, correo, password, rol, estado FROM usuarios WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica si la contraseña es correcta
        if ($usuarioData && password_verify($contrasena, $usuarioData['password'])) {
            // Inicia la sesión y guarda los datos del usuario
            session_start();
            $_SESSION['usuario_id'] = $usuarioData['id'];
            $_SESSION['nombres'] = $usuarioData['nombres'];
            $_SESSION['apellidos'] = $usuarioData['apellidos'];
            $_SESSION['username'] = $usuarioData['username'];
            $_SESSION['correo'] = $usuarioData['correo'];
            $_SESSION['rol'] = $usuarioData['rol'];
            $_SESSION['estado'] = $usuarioData['estado'];

            return true; // Inicio de sesión exitoso
        }

        return "Usuario o contraseña incorrectos.";
    }

    // Obtiene los datos de un usuario por su nombre de usuario
    public function obtenerUsuarioPorNombre($username) {
        $sql = "SELECT id, nombres, apellidos, username, correo, rol, estado FROM usuarios WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve los datos del usuario
    }
}
?>