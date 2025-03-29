<?php
// C:\wamp64\www\internet\modelos\RegistroModelo.php

class RegistroModelo {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConexion();
    }

    // Registra un nuevo usuario en la base de datos con SHA-256
    public function registrarUsuario($nombres, $apellidos, $telefono, $dni, $correo, $username, $password) {
        // Verifica si el username o correo ya existen
        $sql = "SELECT IdUsuario FROM usuarios WHERE UsernameUsuario = ? OR CorreoUsuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username, $correo]);

        if ($stmt->fetch()) {
            return "El nombre de usuario o correo ya están registrados.";
        }

        // Hashea la contraseña con SHA-256
        $contrasenaHash = hash('sha256', $password);

        // Inserta el nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (NombresUsuario, ApellidosUsuario, TelefonoUsuario, DNIUsuario, CorreoUsuario, UsernameUsuario, PasswordUsuario) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        // Ejecuta la inserción con los datos del usuario
        if ($stmt->execute([$nombres, $apellidos, $telefono, $dni, $correo, $username, $contrasenaHash])) {
            return true; // Registro exitoso
        }

        return "Error al registrar el usuario.";
    }
}
?>