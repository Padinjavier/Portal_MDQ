<?php
// Incluir el archivo de configuración
require_once __DIR__ . '/../../Config/Config.php';
?>
<!-- aaaaa  -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 - Municipalidad de Quilmaná</title>
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>/vistas/assets/dist/img/escudo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: #1e1e2f; /* Fondo oscuro */
        }
        .error-container {
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 2;
        }
        .error-container img {
            width: 100px;
            margin-bottom: 20px;
        }
        .error-container h1 {
            font-size: 48px;
            color: #ff6b6b;
            margin: 10px 0;
        }
        .error-container p {
            font-size: 18px;
            color: #ddd;
            margin-bottom: 20px;
        }
        .error-container a {
            display: inline-block;
            text-decoration: none;
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: background 0.3s, transform 0.3s;
        }
        .error-container a:hover {
            background: #0056b3;
            transform: translateY(-3px);
        }
        canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
    </style>
</head>
<body>
    <!-- Contenedor del error -->
    <div class="error-container">
        <img src="<?php echo BASE_URL; ?>/vistas/assets/dist/img/escudo.png" alt="Escudo de Quilmaná">
        <h1>¡Error 404!</h1>
        <p>La página que buscas no existe o ha sido movida.</p>
        <a href="<?php echo BASE_URL; ?>">Volver al inicio</a>
    </div>

    <!-- Canvas para las partículas -->
    <canvas id="particles"></canvas>

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
</body>
</html>