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
    <title>Registro - Municipalidad Distrital de Quilmaná</title>
    <!-- Font Awesome -->
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>/vistas/assets/dist/img/escudo.png">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/vistas/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/vistas/assets/dist/css/adminlte.css">
    <!-- Estilos personalizados -->
     <!-- Toastify CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<!-- Toastify JS -->
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <style>
        .register-page {
            background: rgb(41, 48, 64);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .register-box {
            width: 100%;
            max-width: 800px;
        }
        .register-logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .register-logo img {
            width: 100px;
            height: auto;
        }
        .register-logo h3 {
            color: #fff;
            font-weight: bold;
            margin-top: 10px;
        }
        .register-card-body {
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
<body class="hold-transition register-page">
    <div class="register-box">
        <!-- Logo y título -->
        <div class="register-logo">
            <img src="<?php echo BASE_URL; ?>/vistas/assets/dist/img/escudo.png" alt="Escudo de Quilmaná">
            <h3>Municipalidad Distrital de Quilmaná</h3>
        </div>

        <!-- Formulario de Registro -->
        <div class="card">
            <div class="card-body register-card-body">
                <h3 class="login-box-msg">Regístrate para comenzar</h3>

                <form action="<?php echo BASE_URL; ?>/controladores/RegistroControlador.php" method="POST">
                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-6">
                            <!-- Campo de Nombres -->
                            <div class="form-group mb-3">
                                <label for="nombres">Nombres</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="bi bi-person-fill"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Campo de Apellidos -->
                            <div class="form-group mb-3">
                                <label for="apellidos">Apellidos</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="bi bi-person-fill"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Campo de Teléfono -->
                            <div class="form-group mb-3">
                                <label for="telefono">Teléfono</label>
                                <div class="input-group">
                                    <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="bi bi-telephone-fill"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Campo de DNI -->
                            <div class="form-group mb-3">
                                <label for="dni">DNI</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="dni" name="dni" placeholder="DNI" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="bi bi-card-text"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Columna 2 -->
                        <div class="col-md-6">
                            <!-- Campo de Correo -->
                            <div class="form-group mb-3">
                                <label for="correo">Correo Electrónico</label>
                                <div class="input-group">
                                    <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo Electrónico" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="bi bi-envelope-fill"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Campo de Username -->
                            <div class="form-group mb-3">
                                <label for="username">Nombre de Usuario</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Nombre de Usuario" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="bi bi-person-badge-fill"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Campo de Contraseña -->
                            <div class="form-group mb-3">
                                <label for="password">Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" onclick="togglePasswordVisibility('password')">
                                            <i class="bi bi-eye-fill" id="eye-icon-password"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Campo de Confirmar Contraseña -->
                            <div class="form-group mb-3">
                                <label for="confirmar_password">Confirmar Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" placeholder="Confirmar Contraseña" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" onclick="togglePasswordVisibility('confirmar_password')">
                                            <i class="bi bi-eye-fill" id="eye-icon-confirmar_password"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botón de Registro -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="bi bi-person-plus-fill"></i> Registrarse
                            </button>
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
    </script>
</body>
</html>