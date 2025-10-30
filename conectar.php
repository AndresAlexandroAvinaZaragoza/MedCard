<?php
@session_start();
date_default_timezone_set('America/Mexico_City');
$dsn = "mysql:host=localhost;dbname=web";
$usuario = "root";
$contrasena = "123456789";
$opciones = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"
];

try {
    $consulta = new PDO($dsn, $usuario, $contrasena, $opciones);
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
