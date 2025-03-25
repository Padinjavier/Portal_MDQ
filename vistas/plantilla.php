<?php
// Incluir el archivo de configuración
require_once __DIR__ . '/../Config/Config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrar Sistema | Inicio</title>
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>/vistas/assets/dist/img/escudo.png">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Iconos Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- CSS STYLES -->
    <link rel="stylesheet" href="vistas/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="vistas/assets/dist/css/adminlte.css">
    <link rel="stylesheet" href="vistas/assets/dist/css/index.css">
    <!-- CSS PARA DATATABLES -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <!-- Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <!-- Notificaciones personalizadas -->
    <script src="<?php echo BASE_URL; ?>/vistas/assets/dist/js/toastNotifications.js"></script>
    <!-- Incluir SweetAlert2 desde un CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Incluir jQuery desde un CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <script src="vistas/assets/plugins/jquery/jquery.min.js"></script>
    <script src="vistas/assets/plugins/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="vistas/assets/dist/js/adminlte.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="vistas/assets/dist/js/demo.js"></script>
</body>


<!-- DataTables Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css">

<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<!-- CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">

<!-- JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

</html>