<?php
// C:\wamp64\www\internet\controladores\RegistroControlador.php

require_once '../modelos/UsuarioModelo.php';
require_once '../modelos/conexion.php';

class RegistroControlador {
    private $usuarioModelo;

    public function __construct() {
        $db = new Conexion();
        $this->usuarioModelo = new UsuarioModelo($db);
    }

    public function registro() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'];
            $correo = $_POST['correo'];
            $contrasena = $_POST['contrasena'];

            if ($this->usuarioModelo->registrarUsuario($usuario, $correo, $contrasena)) {
                header('Location: /internet/modulos/login.php');
                exit();
            } else {
                echo "Error al registrar el usuario";
            }
        }
    }
}

$registroControlador = new RegistroControlador();
$registroControlador->registro();
?>