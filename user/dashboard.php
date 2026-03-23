<?php
// Panel principal del usuario con acceso al catálogo de libros.
// Se verifica que solo los usuarios autenticados con rol usuario entren aquí.
require_once "../includes/auth_user.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de usuario</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="contenedor dashboard-contenedor">
        <h2>Panel de Usuario</h2>
        <p class="bienvenida">
            Bienvenido, <strong><?php echo htmlspecialchars($_SESSION["usuario_nombre"]); ?></strong>.
        </p>
        <p class="descripcion-panel">
            Desde este panel puedes consultar el catálogo de libros disponibles en la biblioteca virtual.
        </p>

        <div class="tarjetas-panel">
            <div class="tarjeta">
                <h3>Catálogo de libros</h3>
                <p>Consulta libros por título, autor, categoría, año y estado.</p>
                <a class="btn-panel" href="catalogo.php">Ver catálogo</a>
            </div>

            <div class="tarjeta">
                <h3>Cerrar sesión</h3>
                <p>Finaliza la sesión actual de forma segura.</p>
                <a class="btn-panel salir" href="../logout.php">Cerrar sesión</a>
            </div>
        </div>
    </div>
</body>
</html>