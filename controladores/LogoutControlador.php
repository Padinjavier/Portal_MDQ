<?php
// C:\wamp64\www\internet\controladores\LogoutControlador.php

// Incluir el archivo de configuración
require_once __DIR__ . '/../Config/Config.php';
session_start(); // Iniciar la sesión

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al login con un mensaje de éxito
header('Location: ' . BASE_URL . '/index.php');
exit();
?>