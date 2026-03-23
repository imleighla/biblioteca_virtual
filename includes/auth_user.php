<?php
// Este archivo protege las páginas reservadas para los usuarios del sistema.
// Se inicia la sesión para validar el acceso del usuario.
session_start();

// Se comprueba que exista sesión activa y que el rol corresponda a usuario.
if (!isset($_SESSION["usuario_id"]) || $_SESSION["usuario_rol"] != "usuario") {
    header("Location: ../login.php");
    exit();
}
?>