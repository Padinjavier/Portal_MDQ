<?php
// Incluir el archivo de configuración
require_once __DIR__ . '/../Config/Config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal MDQ</title>
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>/vistas/assets/dist/img/escudo.png">

    <!-- ⭐ Fuente de Google utilizada para estilizar el texto de la página -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- ⭐ Biblioteca de iconos de Bootstrap que se usa en la interfaz para representar acciones -->
    <link rel="stylesheet" href="vistas/assets/plugins/fontawesome-free/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- ⭐ Estilos básicos para la interfaz, incluyendo diseño y colores -->
    <link rel="stylesheet" href="vistas/assets/dist/css/adminlte.css">

    <!-- ⭐ Estilos adicionales específicos de la página o sistema -->
    <link rel="stylesheet" href="vistas/assets/dist/css/index.css">

    <!-- CSS PARA DATATABLES -->
    <!-- ⭐ Estilos necesarios para el componente DataTables (tablas interactivas) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">

    <!-- ⭐ Librería para mostrar alertas personalizadas en la página -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ⭐ Librería de JavaScript para manipulación eficiente del DOM -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- ⭐ Summernote CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css" rel="stylesheet">


    <!-- Toastify JS -->
    <!-- Librería de notificaciones emergentes que aparece en la parte superior de la pantalla -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- Notificaciones personalizadas -->
    <!-- Funciones adicionales para personalizar las notificaciones de Toastify -->
    <script src="<?php echo BASE_URL; ?>/vistas/assets/dist/js/toastNotifications.js"></script>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php
        // Incluir el header
        include "modulos/layout/header_navbar.php";

        // Incluir el menú lateral
        include "modulos/layout/sidebar_lateral.php";

        // Contenido de la página
        echo '<div class="content-wrapper mt-5 pt-2">';
        // Cargar el contenido según la ruta
        $ruta = isset($_GET['ruta']) ? $_GET['ruta'] : 'dashboard';
        include "modulos/$ruta.php";
        echo '</div>';

        // Incluir el footer
        include "modulos/layout/footer.php";
        ?>
    </div>
    <!-- Scripts -->

    <!-- ⭐ Funciones interactivas de Bootstrap, como los modales y las pestañas -->
    <script src="vistas/assets/plugins/bootstrap/js/bootstrap.bundle.js"></script>

    <!-- ⭐Funciones y configuración específicas para la plantilla AdminLTE -->
    <script src="vistas/assets/dist/js/adminlte.js"></script>

    <!-- ⭐ Funcionalidades de DataTables, como búsqueda, paginación y ordenamiento -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

    <!-- Demo JS -->
    <!-- ❌Código adicional de demostración o ejemplo para el sistema -->
    <!-- <script src="vistas/assets/dist/js/demo.js"></script> -->

    <!-- Librerías necesarias para exportar a Excel y PDF -->
    <!-- JSZip: Para exportación a Excel, PDFMake: Para exportación a PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>


    <!-- ❌ Popper.js (Requerido por Bootstrap 4) -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script> -->

    <!-- ⭐ Summernote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script>


    <!-- ⭐ Chart JS para graficos del dashboard exportar a JPG y PDF-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</body>

</html>