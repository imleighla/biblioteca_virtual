<?php
// Este archivo se encarga de establecer la conexión con la base de datos usando PDO.

// Datos principales de conexión al servidor local y a la base de datos del proyecto.
$host = "localhost";
$dbname = "biblioteca_virtual";
$username = "root";
$password = "";

// Se intenta realizar la conexión con MySQL mediante PDO.
try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Se intenta realizar la conexión con MySQL mediante PDO.
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
// Se activa el modo de errores para detectar problemas durante la ejecución.
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?> 