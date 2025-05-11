<?php
// C:\wamp64\www\internet\Config\Config.php

$ip = $_SERVER['SERVER_ADDR'];
$link = 'http://' . $ip . '/Portal_MDQ';
// $link = 'https://f34e-187-102-210-140.ngrok-free.app/helpmdq';
define('BASE_URL', $link);

//Zona horaria
date_default_timezone_set('America/Lima');
//Datos de conexión a Base de Datos
const DB_HOST = "localhost";
const DB_NAME = "helpdesk";
const DB_USER = "root";
const DB_PASSWORD = "javier20";
const DB_CHARSET = "utf8";

class Conexion
{
    private $host = DB_HOST;
    private $dbname = DB_NAME;
    private $user = DB_USER;
    private $password = DB_PASSWORD;
    private $conexion;

    public function __construct()
    {
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

    public function getConexion()
    {
        return $this->conexion;
    }
}





// Información General del Reporte
const MUNICIPALIDAD = "Municipalidad Distrital de Quilmaná";
const UNIDAD_INFORMATICA = "Unidad de Informática";
const DIRECCION = "Av. Principal 123, Quilmaná, Cañete";
const TELEFONO = "(01) 555-1234";
const EMAIL = "soporte@quilmanacanete.gob.pe";
const LOGO_EMPRESA = BASE_URL . "/vistas/assets/dist/img/fondopdf.png";

// Nombres de los años
const NOMBREAÑO2023 = "Año de la unidad, la paz y el desarrollo";
const NOMBREAÑO2024 = "Año del Bicentenario, de la consolidación de nuestra Independencia, y de la conmemoración de las heroicas batallas de Junín y Ayacucho";
const NOMBREAÑO2025 = "Año de la recuperación y consolidación de la economía peruana";

/**
 * Función para obtener el nombre del año dinámicamente.
 * 
 * @param string $fecha Fecha en formato YYYY-MM-DD
 * @return string Nombre del año correspondiente.
 */
function getNombreAño($fecha)
{
    $año = date('Y', strtotime($fecha));
    $constante = "NOMBREAÑO" . $año;

    if (defined($constante)) {
        return constant($constante);
    }

    return "Año no registrado";
}


/**
 * Función para obtener el estado del ticket.
 */
function getEstadoTicket($estado)
{
    $estados = [
        0 => "Eliminado",
        1 => "Abierto",
        2 => "En Atención",
        3 => "Resuelto",
        4 => "Reabierto",
        5 => "Cerrado"
    ];

    return $estados[$estado] ?? "Estado no definido";
}


/**
 * Función para obtener el mes en español.
 */
function getMesEnEspañol($fecha)
{
    $meses = [
        'January' => 'Enero',
        'February' => 'Febrero',
        'March' => 'Marzo',
        'April' => 'Abril',
        'May' => 'Mayo',
        'June' => 'Junio',
        'July' => 'Julio',
        'August' => 'Agosto',
        'September' => 'Septiembre',
        'October' => 'Octubre',
        'November' => 'Noviembre',
        'December' => 'Diciembre'
    ];

    $mesIngles = date('F', strtotime($fecha));
    return $meses[$mesIngles] ?? "Mes no definido";
}
?>