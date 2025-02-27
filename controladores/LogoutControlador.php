<?php
// C:\wamp64\www\internet\controladores\LogoutControlador.php

session_start(); // Iniciar la sesión

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al login
header('Location: /internet/index.php');
exit();
?>