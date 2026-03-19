<?php
require_once "../includes/auth_admin.php";
require_once "../includes/conexion.php";

// Verificar si se recibió el id
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("Location: libros.php?mensaje=error");
    exit();
}

$id = $_GET["id"];

// Verificar si el libro existe
$sql_verificar = "SELECT id FROM libros WHERE id = :id LIMIT 1";
$stmt_verificar = $conexion->prepare($sql_verificar);
$stmt_verificar->bindParam(":id", $id);
$stmt_verificar->execute();
$libro = $stmt_verificar->fetch(PDO::FETCH_ASSOC);

if (!$libro) {
    header("Location: libros.php?mensaje=no_encontrado");
    exit();
}

// Eliminar libro
$sql_eliminar = "DELETE FROM libros WHERE id = :id";
$stmt_eliminar = $conexion->prepare($sql_eliminar);
$stmt_eliminar->bindParam(":id", $id);

if ($stmt_eliminar->execute()) {
    header("Location: libros.php?mensaje=eliminado");
    exit();
} else {
    header("Location: libros.php?mensaje=error");
    exit();
}
?>