<?php
// C:\wamp64\www\internet\controladores\LogoutControlador.php

session_start();
session_destroy();
header('Location: /internet/modulos/login.php');
exit();
?>