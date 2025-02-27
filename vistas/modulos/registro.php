<!-- C:\wamp64\www\internet\vistas\modulos\registro.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/internet/vistas/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="/internet/vistas/assets/dist/css/adminlte.css">
</head>
<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="/internet/"><b>Admin</b>LTE</a>
        </div>
        <!-- /.register-logo -->
        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Regístrate para comenzar</p>

                <form action="/internet/controladores/RegistroControlador.php" method="POST">
                    <!-- Campo de Usuario -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="usuario" placeholder="Usuario" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <!-- Campo de Correo -->
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="correo" placeholder="Correo Electrónico" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
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
                    <!-- Botón de Registro -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                        </div>
                    </div>
                </form>

                <!-- Enlace para Iniciar Sesión -->
                <p class="mb-1 mt-3 text-center">
                    ¿Ya tienes una cuenta? <a href="/internet/modulos/login.php" class="text-center">Inicia sesión aquí</a>
                </p>
            </div>
            <!-- /.register-card-body -->
        </div>
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="/internet/vistas/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/internet/vistas/assets/plugins/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- AdminLTE App -->
    <script src="/internet/vistas/assets/dist/js/adminlte.js"></script>
</body>
</html>