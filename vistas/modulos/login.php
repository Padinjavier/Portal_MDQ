<!-- C:\wamp64\www\internet\vistas\modulos\login.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/internet/vistas/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="/internet/vistas/assets/dist/css/adminlte.css">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="/internet/"><b>Admin</b>LTE</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Inicia sesión para comenzar</p>

                <form action="/internet/controladores/LoginControlador.php" method="POST">
                    <!-- Campo de Usuario -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="usuario" placeholder="Usuario" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <!-- Campo de Contraseña -->
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="contrasena" placeholder="Contraseña" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <!-- Botón de Iniciar Sesión -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                        </div>
                    </div>
                </form>

                <!-- Enlace para Registrarse -->
                <p class="mb-1 mt-3 text-center">
                    ¿No tienes una cuenta? 
                    <a href="/internet/index.php?action=register" class="text-center">Regístrate aquí</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="/internet/vistas/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/internet/vistas/assets/plugins/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- AdminLTE App -->
    <script src="/internet/vistas/assets/dist/js/adminlte.js"></script>
</body>
</html>