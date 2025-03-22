<?php
// C:\wamp64\www\helpmdq\vistas\modulos\registro.php

// Incluir el archivo de configuración
require_once __DIR__ . '/../../Config/Config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <!-- Font Awesome -->
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>/vistas/assets/dist/img/escudo.png">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/vistas/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/vistas/assets/dist/css/adminlte.css">
</head>
<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card">
            <div class="card-body register-card-body p-2 m-2">
                <h3 class="login-box-msg p-2">Regístrate para comenzar</h3>

                <form action="<?php echo BASE_URL; ?>/controladores/RegistroControlador.php" method="POST">
                    <!-- Campo de Nombres -->
                    <div class="form-group mb-2">
                        <label for="nombres">Nombres</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres" required>
                    </div>
                    <!-- Campo de Apellidos -->
                    <div class="form-group mb-2">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" required>
                    </div>
                    <!-- Campo de Teléfono -->
                    <div class="form-group mb-2">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required>
                    </div>
                    <!-- Campo de DNI -->
                    <div class="form-group mb-2">
                        <label for="dni">DNI</label>
                        <input type="text" class="form-control" id="dni" name="dni" placeholder="DNI" required>
                    </div>
                    <!-- Campo de Correo -->
                    <div class="form-group mb-2">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo Electrónico" required>
                    </div>
                    <!-- Campo de Username -->
                    <div class="form-group mb-2">
                        <label for="username">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Nombre de Usuario" required>
                    </div>
                    <!-- Campo de Contraseña -->
                    <div class="form-group mb-2">
                        <label for="password">Contraseña</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                            <div class="input-group-append">
                                <div class="input-group-text" onclick="togglePasswordVisibility('password')">
                                    <span class="fas fa-eye" id="eye-icon-password"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Campo de Confirmar Contraseña -->
                    <div class="form-group">
                        <label for="confirmar_password">Confirmar Contraseña</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" placeholder="Confirmar Contraseña" required>
                            <div class="input-group-append">
                                <div class="input-group-text" onclick="togglePasswordVisibility('confirmar_password')">
                                    <span class="fas fa-eye" id="eye-icon-confirmar_password"></span>
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
                    ¿Ya tienes una cuenta? <a href="<?php echo BASE_URL; ?>/index.php?action=login" class="text-center">Inicia sesión aquí</a>
                </p>
            </div>
            <!-- /.register-card-body -->
        </div>
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="<?php echo BASE_URL; ?>/vistas/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo BASE_URL; ?>/vistas/assets/plugins/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo BASE_URL; ?>/vistas/assets/dist/js/adminlte.js"></script>
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