<?php
require_once "includes/conexion.php";

$mensaje = "";
$color = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y limpiar datos del formulario
    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirmar_password = trim($_POST["confirmar_password"]);

    // Validaciones del lado del servidor
    if (empty($nombre) || empty($email) || empty($password) || empty($confirmar_password)) {
        $mensaje = "Todos los campos son obligatorios.";
        $color = "red";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo electrónico no es válido.";
        $color = "red";
    } elseif ($password !== $confirmar_password) {
        $mensaje = "Las contraseñas no coinciden.";
        $color = "red";
    } elseif (strlen($password) < 6) {
        $mensaje = "La contraseña debe tener al menos 6 caracteres.";
        $color = "red";
    } else {
        // Verificar si el correo ya existe
        $sql = "SELECT id FROM usuarios WHERE email = :email";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $mensaje = "Este correo ya está registrado.";
            $color = "red";
        } else {
            // Cifrar contraseña
            $password_cifrada = password_hash($password, PASSWORD_DEFAULT);

            // Insertar usuario con rol por defecto = usuario
            $sql = "INSERT INTO usuarios (nombre, email, password, rol) 
                    VALUES (:nombre, :email, :password, 'usuario')";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password_cifrada);

            if ($stmt->execute()) {
                $mensaje = "Usuario registrado correctamente.";
                $color = "green";
            } else {
                $mensaje = "Error al registrar el usuario.";
                $color = "red";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <div class="contenedor">
        <h2>Registro de Usuario</h2>

        <?php if (!empty($mensaje)) : ?>
            <p class="mensaje <?php echo ($color == 'green') ? 'exito' : 'error'; ?>">
              <?php echo $mensaje; ?>
            </p>
        <?php endif; ?>

        <form action="" method="POST" id="formRegistro">
            <label for="nombre">Nombre completo:</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>

            <label for="confirmar_password">Confirmar contraseña:</label>
            <input type="password" name="confirmar_password" id="confirmar_password" required>

            <button type="submit">Registrarse</button>
        </form>

        <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </div>

    <script src="js/validaciones.js"></script>

</body>
</html>