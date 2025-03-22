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
    <title>Iniciar Sesión - Municipalidad Distrital de Quilmaná</title>
    <!-- Font Awesome -->
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>/vistas/assets/dist/img/escudo.png">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/vistas/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/vistas/assets/dist/css/adminlte.css">
    <!-- Toastify CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- Estilos personalizados -->
    <style>
        .login-page {
            background: rgb(41, 48, 64);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .login-box {
            width: 100%;
            max-width: 400px;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-logo img {
            width: 100px;
            height: auto;
        }
        .login-logo h3 {
            color: #fff;
            font-weight: bold;
            margin-top: 10px;
        }
        .login-card-body {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .input-group-text {
            cursor: pointer;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <!-- Logo y título -->
        <div class="login-logo">
            <img src="<?php echo BASE_URL; ?>/vistas/assets/dist/img/escudo.png" alt="Escudo de Quilmaná">
            <h3>Municipalidad Distrital de Quilmaná</h3>
        </div>

        <!-- Formulario de Login -->
        <div class="card">
            <div class="card-body login-card-body">
                <h3 class="login-box-msg">Iniciar Sesión</h3>

                <form action="<?php echo BASE_URL; ?>/controladores/LoginControlador.php" method="POST">
                    <!-- Campo de Usuario -->
                    <div class="form-group mb-3">
                        <label for="username">Nombre de Usuario</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Nombre de Usuario" required>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="bi bi-person-fill"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Campo de Contraseña -->
                    <div class="form-group mb-3">
                        <label for="contrasena">Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña" required>
                            <div class="input-group-append">
                                <span class="input-group-text" onclick="togglePasswordVisibility('contrasena')">
                                    <i class="bi bi-eye-fill" id="eye-icon-contrasena"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Botón de Iniciar Sesión -->
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                    </button>
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
    <!-- Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <!-- Script para mostrar/ocultar contraseña -->
    <script>
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const eyeIcon = document.getElementById(`eye-icon-${inputId}`);
            if (input.type === "password") {
                input.type = "text";
                eyeIcon.classList.remove("bi-eye-fill");
                eyeIcon.classList.add("bi-eye-slash-fill");
            } else {
                input.type = "password";
                eyeIcon.classList.remove("bi-eye-slash-fill");
                eyeIcon.classList.add("bi-eye-fill");
            }
        }

        // Mostrar notificación si el registro fue exitoso
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('registro') && urlParams.get('registro') === 'exitoso') {
            Toastify({
                text: "Registro exitoso. Ahora inicia sesión.",
                duration: 3000, // Duración de la notificación en milisegundos
                close: false, // Mostrar botón de cierre
                gravity: "top", // Posición de la notificación (top, bottom)
                position: "right", // Alineación (left, center, right)
                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)", // Color de fondo
                stopOnFocus: true, // Detener el temporizador al hacer hover
            }).showToast();
        }
    </script>
</body>
</html>