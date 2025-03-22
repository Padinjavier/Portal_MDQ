<?php
class PlantillaControlador {

    public function cargarPlantilla($ruta) {
        // Verificar si la ruta existe
        if (file_exists("vistas/modulos/$ruta.php")) {
            // Incluir la plantilla principal
            include 'vistas/Plantilla.php';
        } else {
            // Si la ruta no existe, cargar un error 404
            include 'vistas/modulos/error404.php';
        }
    }
}
?>