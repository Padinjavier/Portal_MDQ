<?php
// C:\wamp64\www\internet\controladores\LoginControlador.php

require_once '../modelos/LoginModelo.php';
require_once '../config/conexion.php';

class LoginControlador {
    private $LoginModelo;

    public function __construct() {
        $db = new Conexion();
        $this->LoginModelo = new LoginModelo($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'];
            $contrasena = $_POST['contrasena'];
        
            $resultado = $this->LoginModelo->loginUsuario($usuario, $contrasena);
        
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