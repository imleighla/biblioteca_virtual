<?php
// Este archivo controla el inicio de sesión de los usuarios y redirige según su rol.
session_start();
// Se inicia la sesión para poder guardar la información del usuario autenticado.
require_once "includes/conexion.php";
// Se incluye la conexión a la base de datos.
$mensaje = "";
$color = "";
// Variables usadas para mostrar mensajes de error o confirmación en la interfaz.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Se verifica si el formulario fue enviado mediante el método POST.
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    // Se capturan y limpian los datos ingresados por el usuario en el formulario.
    if (empty($email) || empty($password)) {
        $mensaje = "Todos los campos son obligatorios.";
        $color = "red";
    // Se validan los campos obligatorios antes de consultar la base de datos.
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo electrónico no es válido.";
        $color = "red";
    } else {
        // Se valida que el correo tenga un formato correcto.
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        // Consulta SQL para buscar al usuario en la base de datos según su correo electrónico.
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        // La consulta se prepara y ejecuta de forma segura para evitar inyección SQL.
        if ($usuario && password_verify($password, $usuario["password"])) {
            // Se verifica que el usuario exista y que la contraseña ingresada coincida con la cifrada.
            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["usuario_nombre"] = $usuario["nombre"];
            $_SESSION["usuario_email"] = $usuario["email"];
            $_SESSION["usuario_rol"] = $usuario["rol"];

            // Se guardan los datos principales del usuario en variables de sesión.
            if ($usuario["rol"] == "admin") {
                header("Location: admin/dashboard.php");
                exit();
            } else {
                header("Location: user/dashboard.php");
                exit();
            }
        // Se redirige al panel correspondiente según el rol del usuario autenticado.
        } else {
            $mensaje = "Correo o contraseña incorrectos.";
            $color = "red";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <div class="contenedor">
        <h2>Iniciar sesión</h2>

        <?php if (!empty($mensaje)) : ?>
            <p class="mensaje <?php echo ($color == 'green') ? 'exito' : 'error'; ?>">
                <?php echo $mensaje; ?>
            </p>
        <?php endif; ?>
        <!-- Formulario de inicio de sesión -->
        <form action="" method="POST" id="formLogin">
            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Ingresar</button>
        </form>

        <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </div>
    
    <script src="js/validaciones.js"></script>
    
</body>
</html>