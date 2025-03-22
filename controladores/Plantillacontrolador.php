<?php
// C:\wamp64\www\internet\controladores\plantilla_controlador.php

session_start();

class PlantillaControlador {

    public function plantilla() {
        // Verificar si la sesión está iniciada
        if (!isset($_SESSION['Login_IdUsuario'])) {
            // Manejar acciones desde la URL para login/registro
            if (isset($_GET['action'])) {
                if ($_GET['action'] == 'register') {
                    include 'vistas/modulos/registro.php';
                } else {
                    include 'vistas/modulos/login.php';
                }
            } else {
                include 'vistas/modulos/login.php';
            }
        } else {
            // Si el usuario está autenticado, manejar rutas específicas
            $ruta = isset($_GET['ruta']) ? $_GET['ruta'] : 'dashboard';

            switch ($ruta) {
                case 'usuarios':
                    include 'vistas/modulos/usuarios.php';
                    break;
                case 'roles':
                    include 'vistas/modulos/roles.php';
                    break;
                case 'dashboard':
                default:
                    include 'vistas/Plantilla.php';
                    break;
            }
        }
    }
}
?>