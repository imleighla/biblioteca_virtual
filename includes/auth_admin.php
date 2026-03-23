<?php
// Este archivo protege las páginas reservadas para el administrador.
// Se inicia la sesión para comprobar si el usuario ya inició sesión.
session_start();

// Se valida que exista una sesión activa y que el rol sea administrador.
if (!isset($_SESSION["usuario_id"]) || $_SESSION["usuario_rol"] != "admin") {
    // Si no cumple con los permisos, se redirige al formulario de inicio de sesión.
    header("Location: ../login.php");
    exit();
}
?>