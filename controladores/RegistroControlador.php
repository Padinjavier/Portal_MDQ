<?php
// C:\wamp64\www\internet\controladores\RegistroControlador.php

require_once '../modelos/RegistroModelo.php';
require_once '../Config/Config.php';

class RegistroControlador {
    private $RegistroModelo;

    public function __construct() {
        $db = new Conexion();
        $this->RegistroModelo = new RegistroModelo($db);
    }

    public function registro() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $telefono = $_POST['telefono'];
            $dni = $_POST['dni'];
            $correo = $_POST['correo'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirmar_password = $_POST['confirmar_password'];
        
            // Validar que las contraseñas coincidan
            if ($password !== $confirmar_password) {
                echo "Las contraseñas no coinciden.";
                return;
            }

            // Registrar el usuario
            $resultado = $this->RegistroModelo->registrarUsuario($nombres, $apellidos, $telefono, $dni, $correo, $username, $password);
        
            if ($resultado === true) {
                // Redirigir al login con un mensaje de éxito
                header('Location: ' . BASE_URL . '/index.php?action=login&registro=exitoso');
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