<!-- Página principal del sistema Biblioteca Virtual -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <!-- Sección de presentación general del proyecto -->
    <div class="contenedor inicio-contenedor">
        <div class="inicio-badge">Proyecto Final PHP y MySQL</div>

        <h1 class="titulo-inicio">Biblioteca Virtual</h1>

        <p class="subtitulo-inicio">
            Sistema web para la gestión y consulta de libros, desarrollado con PHP, MySQL,
            HTML5, CSS3 y JavaScript.
        </p>
        <!-- Tarjetas informativas que explican las funciones de administrador y usuario -->
        <div class="info-inicio">
            <div class="mini-card">
                <h3>Administrador</h3>
                <p>Gestiona libros del catálogo con operaciones de agregar, editar y eliminar.</p>
            </div>

            <div class="mini-card">
                <h3>Usuario</h3>
                <p>Consulta libros disponibles y utiliza búsqueda por título, autor, categoría o año.</p>
            </div>
        </div>
        <!-- Accesos principales al inicio de sesión y al registro -->
        <div class="acciones-inferiores">
            <a class="btn-secundario" href="login.php">Iniciar sesión</a>
            <a class="btn-secundario" href="registro.php">Registrarse</a>
        </div>
    </div>
</body>
</html>