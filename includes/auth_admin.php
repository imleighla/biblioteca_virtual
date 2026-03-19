<?php
session_start();

// Verifica si el usuario inició sesión y si su rol es administrador
if (!isset($_SESSION["usuario_id"]) || $_SESSION["usuario_rol"] != "admin") {
    header("Location: ../login.php");
    exit();
}
?>