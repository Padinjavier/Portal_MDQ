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
        
            $resultado = $this->usuarioModelo->loginUsuario($usuario, $contrasena);
        
            if ($resultado === true) {
                header('Location: /internet/');
                exit();
            } else {
                echo $resultado;
            }
        }        
    }
}

$loginControlador = new LoginControlador();
$loginControlador->login();
?>