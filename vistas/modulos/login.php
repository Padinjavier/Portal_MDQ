<?php
// C:\wamp64\www\helpmdq\vistas\modulos\login.php

// Incluir el archivo de configuración
require_once __DIR__ . '/../../Config/Config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Font Awesome -->
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>/vistas/assets/dist/img/escudo.png">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/vistas/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/vistas/assets/dist/css/adminlte.css">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <!-- Mensaje de Bienvenida -->
                <h3 class="login-box-msg">Iniciar Sesión</h3>

                <!-- Formulario de Login -->
                <form action="<?php echo BASE_URL; ?>/controladores/LoginControlador.php" method="POST">
                    <!-- Campo de Usuario -->
                    <div class="form-group mb-2">
                        <label for="username">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Nombre de Usuario" required>
                    </div>
                    <!-- Campo de Contraseña -->
                    <div class="form-group mb-2">
                        <label for="contrasena">Contraseña</label>
                        <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña" required>
                    </div>
                    <!-- Botón de Iniciar Sesión -->
                    <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                </form>

                <!-- Enlace para Registrarse -->
                <p class="mb-1 mt-3 text-center register-link">
                    ¿No tienes una cuenta? 
                    <a href="<?php echo BASE_URL; ?>/index.php?action=register" class="text-center">Regístrate aquí</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?php echo BASE_URL; ?>/vistas/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo BASE_URL; ?>/vistas/assets/plugins/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo BASE_URL; ?>/vistas/assets/dist/js/adminlte.js"></script>
</body>
</html>