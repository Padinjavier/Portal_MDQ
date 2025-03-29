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
    <!-- Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <!-- Notificaciones personalizadas -->
    <script src="<?php echo BASE_URL; ?>/vistas/assets/dist/js/toastNotifications.js"></script>
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
                        <label for="usernameusuario">Nombre de Usuario</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="usernameusuario" name="usernameusuario"
                                placeholder="Nombre de Usuario" required>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="bi bi-person-fill"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Campo de Contraseña -->
                    <div class="form-group mb-3">
                        <label for="passwordusuario">Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="passwordusuario" name="passwordusuario"
                                placeholder="Contraseña" required>
                            <div class="input-group-append">
                                <span class="input-group-text" onclick="togglePasswordVisibility('passwordusuario')">
                                    <i class="bi bi-eye-fill" id="eye-icon-passwordusuario"></i>
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
                    <a href="<?php echo BASE_URL; ?>/index.php?ruta=registro" class="text-center">Regístrate aquí</a>
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
            showToast(
                'correcto',
                'Registro exitoso. Ahora inicia sesión.'
            );
        }
    </script>
</body>
 <!-- Canvas para las partículas -->
 <canvas id="particles"></canvas>
<style>
    canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
</style>
<!-- Script para animar las partículas -->
<script>
    const canvas = document.getElementById('particles');
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    // Configuración de las partículas
    const particlesArray = [];
    const numberOfParticles = 100;

    class Particle {
        constructor(x, y, directionX, directionY, size, color) {
            this.x = x;
            this.y = y;
            this.directionX = directionX;
            this.directionY = directionY;
            this.size = size;
            this.color = color;
        }
        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2, false);
            ctx.fillStyle = this.color;
            ctx.fill();
        }
        update() {
            if (this.x + this.size > canvas.width || this.x - this.size < 0) {
                this.directionX = -this.directionX;
            }
            if (this.y + this.size > canvas.height || this.y - this.size < 0) {
                this.directionY = -this.directionY;
            }
            this.x += this.directionX;
            this.y += this.directionY;
            this.draw();
        }
    }

    // Inicializar las partículas
    function init() {
        particlesArray.length = 0;
        for (let i = 0; i < numberOfParticles; i++) {
            const size = Math.random() * 3 + 1;
            const x = Math.random() * (canvas.width - size * 2) + size;
            const y = Math.random() * (canvas.height - size * 2) + size;
            const directionX = (Math.random() * 0.4) - 0.2;
            const directionY = (Math.random() * 0.4) - 0.2;
            const color = '#ffffff';
            particlesArray.push(new Particle(x, y, directionX, directionY, size, color));
        }
    }

    // Animar las partículas
    function animate() {
        requestAnimationFrame(animate);
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particlesArray.forEach(particle => particle.update());
    }

    // Redimensionar el canvas al cambiar el tamaño de la ventana
    window.addEventListener('resize', () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        init();
    });

    // Iniciar la animación
    init();
    animate();
</script>
</html>