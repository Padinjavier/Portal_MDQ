<?php
session_start();

// Obtener la ruta solicitada
$ruta = isset($_GET['ruta']) ? $_GET['ruta'] : 'dashboard';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['Login_IdUsuario'])) {
    // Si no está autenticado, redirigir al login o register según la ruta
    if ($ruta === 'registro') {
        include 'vistas/modulos/registro.php';
    } else {
        include 'vistas/modulos/login.php';
    }
    exit();
}

// Incluir el controlador de plantilla
require_once "controladores/PlantillaControlador.php";

// Crear una instancia del controlador de plantilla
$plantilla = new PlantillaControlador();

// Cargar la plantilla con la ruta solicitada
$plantilla->cargarPlantilla($ruta);
?>