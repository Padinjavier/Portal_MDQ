<?php
// C:\wamp64\www\helpmdq\controladores\LoginControlador.php

require_once '../modelos/LoginModelo.php';
require_once '../Config/Config.php'; // Incluir Config.php

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
                header('Location: ' . BASE_URL); // Usar BASE_URL
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