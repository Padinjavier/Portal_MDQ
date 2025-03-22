<?php
// C:\wamp64\www\internet\config\conexion.php

class Conexion {
    private $host = 'localhost'; // Servidor de la base de datos
    private $dbname = 'helpdesk'; // Nombre de la base de datos
    private $user = 'root'; // Usuario de la base de datos
    private $password = 'javier20'; // Contraseña de la base de datos
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