<?php
// C:\wamp64\www\internet\modelos\RegistroModelo.php

class RegistroModelo {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConexion();
    }

    // Registra un nuevo usuario en la base de datos
    public function registrarUsuario($usuario, $correo, $contrasena) {
        // Verifica si el usuario o correo ya existen
        $sql = "SELECT id FROM usuarios WHERE username = ? OR correo = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario, $correo]);

        if ($stmt->fetch()) {
            return "El usuario o correo ya están registrados.";
        }

        // Hashea la contraseña (usa password_hash para mayor seguridad)
        $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);

        // Inserta el nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (username, correo, password) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        if ($stmt->execute([$usuario, $correo, $contrasenaHash])) {
            return "Usuario registrado correctamente.";
        }

        return "Error al registrar el usuario.";
    }
}
?>