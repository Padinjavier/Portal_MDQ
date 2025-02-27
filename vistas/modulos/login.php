<!-- C:\wamp64\www\internet\vistas\modulos\login.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Gestión de Proveedores</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/internet/vistas/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="/internet/vistas/assets/dist/css/adminlte.css">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                                <!-- Mensaje de Bienvenida -->
                <h3 class="login-box-msg">Iniciar Sesión</h3>

                <!-- Formulario de Login -->
                <form action="/internet/controladores/LoginControlador.php" method="POST">
                    <!-- Campo de Usuario -->
                    <div class="form-group mb-2">
                        <label for="usuario">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" required>
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