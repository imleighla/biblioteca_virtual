<?php
// Este archivo elimina un libro seleccionado por el administrador.
// Se incluye el archivo de autenticación para asegurar que solo los administradores puedan acceder a esta funcionalidad, y el archivo de conexión a la base de datos para realizar las operaciones necesarias.
require_once "../includes/auth_admin.php";
require_once "../includes/conexion.php";

// Se verifica que se haya recibido el identificador del libro a eliminar.
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("Location: libros.php?mensaje=error");
    exit();
}

$id = $_GET["id"];

// Antes de eliminar, se revisa que el libro exista en la base de datos.
$sql_verificar = "SELECT id FROM libros WHERE id = :id LIMIT 1";
$stmt_verificar = $conexion->prepare($sql_verificar);
$stmt_verificar->bindParam(":id", $id);
$stmt_verificar->execute();
$libro = $stmt_verificar->fetch(PDO::FETCH_ASSOC);

if (!$libro) {
    header("Location: libros.php?mensaje=no_encontrado");
    exit();
}

// Consulta SQL para eliminar el libro seleccionado.
$sql_eliminar = "DELETE FROM libros WHERE id = :id";
$stmt_eliminar = $conexion->prepare($sql_eliminar);
$stmt_eliminar->bindParam(":id", $id);
// Luego de eliminar, se redirige al listado con un mensaje de confirmación.
if ($stmt_eliminar->execute()) {
    header("Location: libros.php?mensaje=eliminado");
    exit();
} else {
    header("Location: libros.php?mensaje=error");
    exit();
}
?>