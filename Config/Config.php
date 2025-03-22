<?php
// C:\wamp64\www\internet\Config\Config.php

$ip = $_SERVER['SERVER_ADDR'];
$link = 'http://' . $ip . '/helpmdq';
define('BASE_URL', $link);

//Zona horaria
date_default_timezone_set('America/Lima');
//Datos de conexión a Base de Datos
const DB_HOST = "localhost";
const DB_NAME = "helpdesk";
const DB_USER = "root";
const DB_PASSWORD = "javier20";
const DB_CHARSET = "utf8";


class Conexion {
    private $host = DB_HOST;
    private $dbname = DB_NAME;
    private $user = DB_USER;
    private $password = DB_PASSWORD;
    private $conexion;

    public function __construct() {
        try {
            // Crear la conexión usando PDO
            $this->conexion = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",
                $this->user,
                $this->password
            );

            // Configurar PDO para que lance excepciones en caso de errores
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Configurar el juego de caracteres a UTF-8
            $this->conexion->exec("SET NAMES 'utf8'");
        } catch (PDOException $e) {
            // En caso de error, mostrar un mensaje y detener la ejecución
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    public function getConexion() {
        return $this->conexion;
    }
}
?>