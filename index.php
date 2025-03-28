<?php
session_start();

// Obtener la ruta solicitada
$ruta = isset($_GET['ruta']) ? $_GET['ruta'] : 'dashboard';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['Login_IdUsuario'])) {
    if ($ruta === 'registro') {
        include 'vistas/modulos/registro.php';
    } else {
        include 'vistas/modulos/login.php';
    }
    exit();
}

// Función para cargar controladores dinámicamente
function cargarControlador($ruta) {
    // Posibles rutas donde buscar el controlador ruta corta es momentania por si causa errores la ruta completa
    $posiblesRutas = [
        "controladores/$ruta/$ruta.php",
    ];

    foreach ($posiblesRutas as $archivo) {
        if (file_exists($archivo)) {
            require_once $archivo;
            return;
        }
    }

    // Si no existe, mostrar error
    include 'vistas/modulos/error404.php';
    exit();
}

// Cargar controlador de la plantilla
require_once "controladores/PlantillaControlador.php";

// Instanciar el controlador y cargar la plantilla
$plantilla = new PlantillaControlador();

// Cargar la plantilla con la ruta solicitada
$plantilla->cargarPlantilla($ruta);
?>