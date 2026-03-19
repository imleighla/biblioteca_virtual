<?php
session_start();

// Verifica si el usuario inició sesión y si su rol es usuario
if (!isset($_SESSION["usuario_id"]) || $_SESSION["usuario_rol"] != "usuario") {
    header("Location: ../login.php");
    exit();
}
?>