<?php
// C:\wamp64\www\internet\modelos\UsuarioModelo.php

class UsuarioModelo {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function registrarUsuario($usuario, $correo, $contrasena) {
        $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);
        $sql = "INSERT INTO usuarios (usuario, correo, contrasena) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$usuario, $correo, $contrasenaHash]);
    }

    public function verificarCredenciales($usuario, $contrasena) {
        $sql = "SELECT id, contrasena FROM usuarios WHERE usuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
            return $usuario['id'];
        }
        return false;
    }
}
?>