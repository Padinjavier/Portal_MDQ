<?php
// C:\wamp64\www\internet\modelos\RegistroModelo.php

class RegistroModelo {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConexion();
    }

    // Registra un nuevo usuario en la base de datos
    public function registrarUsuario($nombres, $apellidos, $telefono, $dni, $correo, $username, $password) {
        // Verifica si el username o correo ya existen
        $sql = "SELECT id FROM usuarios WHERE username = ? OR correo = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username, $correo]);

        if ($stmt->fetch()) {
            return "El nombre de usuario o correo ya están registrados.";
        }

        // Hashea la contraseña (usa password_hash para mayor seguridad)
        $contrasenaHash = password_hash($password, PASSWORD_BCRYPT);

        // Inserta el nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (nombres, apellidos, telefono, dni, correo, username, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        // Ejecuta la inserción con los datos del usuario
        if ($stmt->execute([$nombres, $apellidos, $telefono, $dni, $correo, $username, $contrasenaHash])) {
            return true; // Registro exitoso
        }

        return "Error al registrar el usuario.";
    }
}
?>