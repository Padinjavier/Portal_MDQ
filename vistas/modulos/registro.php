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
        <!-- /.register-logo -->
        <div class="card">
            <div class="card-body register-card-body p-2 m-2">
                
                <h3 class="login-box-msg p-2">Regístrate para comenzar</h3>

                <form action="/internet/controladores/RegistroControlador.php" method="POST">
                    <!-- Campo de Usuario -->
                    <div class="form-group mb-2">
                        <label for="usuario">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" required>
                    </div>
                    <!-- Campo de Correo -->
                    <div class="form-group mb-2">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo Electrónico" required>
                    </div>
                    <!-- Campo de Contraseña -->
                    <div class="form-group mb-2">
                        <label for="contrasena">Contraseña</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña" required>
                            <div class="input-group-append">
                                <div class="input-group-text" onclick="togglePasswordVisibility('contrasena')">
                                    <span class="fas fa-eye" id="eye-icon-contrasena"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Campo de Confirmar Contraseña -->
                    <div class="form-group">
                        <label for="confirmar_contrasena">Confirmar Contraseña</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Confirmar Contraseña" required>
                            <div class="input-group-append">
                                <div class="input-group-text" onclick="togglePasswordVisibility('confirmar_contrasena')">
                                    <span class="fas fa-eye" id="eye-icon-confirmar_contrasena"></span>
                                </div>
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
                    ¿Ya tienes una cuenta? <a href="/internet/index.php?action=login"  class="text-center">Inicia sesión aquí</a>
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
    <script>
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const eyeIcon = document.getElementById(`eye-icon-${inputId}`);
            if (input.type === "password") {
                input.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>