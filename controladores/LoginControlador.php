<?php
// C:\wamp64\www\internet\controladores\LoginControlador.php

require_once '../modelos/UsuarioModelo.php';
require_once '../modelos/conexion.php';

class LoginControlador {
    private $usuarioModelo;

    public function __construct() {
        $db = new Conexion();
        $this->usuarioModelo = new UsuarioModelo($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'];
            $contrasena = $_POST['contrasena'];

            $usuarioId = $this->usuarioModelo->verificarCredenciales($usuario, $contrasena);

            if ($usuarioId) {
                session_start();
                $_SESSION['usuario_id'] = $usuarioId;
                header('Location: /internet/');
                exit();
            } else {
                echo "Credenciales incorrectas";
            }
        }
    }
}

$loginControlador = new LoginControlador();
$loginControlador->login();
?>