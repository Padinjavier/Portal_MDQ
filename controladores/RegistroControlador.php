<?php
// C:\wamp64\www\internet\controladores\RegistroControlador.php

require_once '../modelos/RegistroModelo.php';
require_once '../config/conexion.php';

class RegistroControlador {
    private $RegistroModelo;

    public function __construct() {
        $db = new Conexion();
        $this->RegistroModelo = new RegistroModelo($db);
    }

    public function registro() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'];
            $correo = $_POST['correo'];
            $contrasena = $_POST['contrasena'];
        
            $resultado = $this->RegistroModelo->registrarUsuario($usuario, $correo, $contrasena);
        
            if ($resultado === true) {
                header('Location: /internet/');
                exit();
            } else {
                echo $resultado;
            }
        }        
    }
}

$registroControlador = new RegistroControlador();
$registroControlador->registro();
?>