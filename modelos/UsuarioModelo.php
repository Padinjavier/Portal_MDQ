<?php
// C:\wamp64\www\internet\modelos\UsuarioModelo.php

class UsuarioModelo {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConexion(); // Obtener la conexión PDO
    }

    public function registrarUsuario($usuario, $correo, $contrasena) {
        // Verificar si el usuario o el correo ya existen
        $sql = "SELECT id FROM usuarios WHERE usuario = ? OR correo = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario, $correo]);

        if ($stmt->fetch()) {
            return "El usuario o correo ya están registrados.";
        }

        // Registrar el usuario
        $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);
        $sql = "INSERT INTO usuarios (usuario, correo, contrasena) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        if ($stmt->execute([$usuario, $correo, $contrasenaHash])) {
            return $this->loginUsuario($usuario, $contrasena);
        }

        return "Error al registrar el usuario.";
    }

    public function obtenerUsuarioPorNombre($usuario) {
        $sql = "SELECT id, usuario, correo, rol, estado FROM usuarios WHERE usuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve los datos del usuario
    }

    public function loginUsuario($usuario, $contrasena) {
        $sql = "SELECT id, usuario, correo, contrasena, rol, estado FROM usuarios WHERE usuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario]);
        $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioData && password_verify($contrasena, $usuarioData['contrasena'])) {
            // Iniciar sesión y guardar datos del usuario
            session_start();
            $_SESSION['usuario_id'] = $usuarioData['id'];
            $_SESSION['username'] = $usuarioData['usuario'];
            $_SESSION['correo'] = $usuarioData['correo'];
            $_SESSION['rol'] = $usuarioData['rol'];
            $_SESSION['estado'] = $usuarioData['estado'];

            return true; // Inicio de sesión exitoso
        }

        return "Usuario o contraseña incorrectos.";
    }
}
?>
