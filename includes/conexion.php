<?php
// Datos de conexión a la base de datos
$host = "localhost";
$dbname = "biblioteca_virtual";
$username = "root";
$password = "";

// Intentar conexión con PDO
try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Configurar PDO para mostrar errores
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?> 