<?php
// C:\wamp64\www\internet\controladores\plantilla_controlador.php

session_start();

class PlantillaControlador {

    public function plantilla() {
        // Verificar si la sesión está iniciada
        if (!isset($_SESSION['usuario_id'])) {
            // Inicializar la variable de sesión login_register si no existe
            if (!isset($_SESSION['login_register'])) {
                $_SESSION['login_register'] = 1; // Valor por defecto: 1 (login)
            }

            // Manejar acciones desde la URL
            if (isset($_GET['action'])) {
                if ($_GET['action'] == 'register') {
                    $_SESSION['login_register'] = 2; // Cambiar a registro
                } else {
                    $_SESSION['login_register'] = 1; // Cambiar a login
                }
            }

            // Redirigir según el valor de login_register
            if ($_SESSION['login_register'] == 1) {
                include 'vistas/modulos/login.php';
            } elseif ($_SESSION['login_register'] == 2) {
                include 'vistas/modulos/registro.php';
            }
        } else {
            // Si el usuario está autenticado, cargar la plantilla principal
            include 'vistas/Plantilla.php';
        }
    }
}
?>