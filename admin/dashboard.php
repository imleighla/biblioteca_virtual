<?php
// Panel principal del administrador con acceso rápido a la gestión de libros.
// Se verifica que solo el administrador pueda entrar a esta página.-  
require_once "../includes/auth_admin.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de administrador</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="contenedor dashboard-contenedor">
        <h2>Panel de Administrador</h2>
        <p class="bienvenida">
            Bienvenido, <strong><?php echo htmlspecialchars($_SESSION["usuario_nombre"]); ?></strong>.
        </p>
        <p class="descripcion-panel">
            Desde este panel puedes gestionar los libros registrados en el sistema.
        </p>
        <!-- Tarjetas principales con accesos rápidos del administrador -->
        <div class="tarjetas-panel">
            <div class="tarjeta">
                <h3>Gestión de libros</h3>
                <p>Agrega, edita, consulta y elimina libros del catálogo.</p>
                <a class="btn-panel" href="libros.php">Ir a libros</a>
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