<?php
session_start();
require_once "includes/conexion.php";

$mensaje = "";
$color = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {
        $mensaje = "Todos los campos son obligatorios.";
        $color = "red";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo electrónico no es válido.";
        $color = "red";
    } else {
        // Buscar usuario por correo
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario["password"])) {
            // Guardar datos en sesión
            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["usuario_nombre"] = $usuario["nombre"];
            $_SESSION["usuario_email"] = $usuario["email"];
            $_SESSION["usuario_rol"] = $usuario["rol"];

            // Redirigir según el rol
            if ($usuario["rol"] == "admin") {
                header("Location: admin/dashboard.php");
                exit();
            } else {
                header("Location: user/dashboard.php");
                exit();
            }
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