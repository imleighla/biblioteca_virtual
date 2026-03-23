<?php
// Este archivo permite al administrador registrar nuevos libros en el sistema.
// Se protege esta página para que solo el administrador tenga acceso.
require_once "../includes/auth_admin.php";
// Se incluye la conexión a la base de datos.
require_once "../includes/conexion.php";

$mensaje = "";
$color = "";

// Se obtienen las categorías disponibles para mostrarlas en el formulario.
$sql_categorias = "SELECT * FROM categorias ORDER BY nombre ASC";
$stmt_categorias = $conexion->prepare($sql_categorias);
$stmt_categorias->execute();
$categorias = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);
// Se comprueba si el formulario de agregar libro fue enviado.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Se capturan y limpian los datos del libro ingresados por el administrador.
    $titulo = trim($_POST["titulo"]);  
    $autor = trim($_POST["autor"]);
    $edicion = trim($_POST["edicion"]);
    $anio_publicacion = trim($_POST["anio_publicacion"]);
    $estado = trim($_POST["estado"]);
    $categoria_id = trim($_POST["categoria_id"]);
    $descripcion = trim($_POST["descripcion"]);
    // Se capturan y limpian los datos del libro ingresados por el administrador.
    if (empty($titulo) || empty($autor) || empty($edicion) || empty($anio_publicacion) || empty($estado) || empty($categoria_id)) {
        $mensaje = "Todos los campos obligatorios deben completarse.";
        $color = "red";
    // Se validan los campos obligatorios antes de guardar el libro.
    } elseif (!is_numeric($anio_publicacion) || strlen($anio_publicacion) != 4) {
        $mensaje = "El año de publicación no es válido.";
        $color = "red";
    } else {
        // Consulta SQL para insertar un nuevo libro en la base de datos.
        $sql = "INSERT INTO libros (titulo, autor, edicion, anio_publicacion, estado, categoria_id, descripcion)
                VALUES (:titulo, :autor, :edicion, :anio_publicacion, :estado, :categoria_id, :descripcion)";
        // Se prepara la consulta y se asignan los valores de forma segura.
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":titulo", $titulo);
        $stmt->bindParam(":autor", $autor);
        $stmt->bindParam(":edicion", $edicion);
        $stmt->bindParam(":anio_publicacion", $anio_publicacion);
        $stmt->bindParam(":estado", $estado);
        $stmt->bindParam(":categoria_id", $categoria_id);
        $stmt->bindParam(":descripcion", $descripcion);
        // Si el registro se realiza correctamente, se redirige al listado con un mensaje.
        if ($stmt->execute()) {
            header("Location: libros.php?mensaje=agregado");
            exit();
        } else {
            $mensaje = "Error al agregar el libro.";
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
    <title>Agregar libro</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="contenedor">
        <h2>Agregar libro</h2>

        <?php if (!empty($mensaje)) : ?>
            <p class="mensaje <?php echo ($color == 'green') ? 'exito' : 'error'; ?>">
                <?php echo $mensaje; ?>
            </p>
        <?php endif; ?>
        <!-- Formulario para registrar un nuevo libro -->
        <form action="" method="POST" id="formLibro">
            <label for="titulo">Título del libro:</label>
            <input type="text" name="titulo" id="titulo" required>

            <label for="autor">Autor:</label>
            <input type="text" name="autor" id="autor" required>

            <label for="edicion">Edición:</label>
            <input type="text" name="edicion" id="edicion" required>

            <label for="anio_publicacion">Año de publicación:</label>
            <input type="number" name="anio_publicacion" id="anio_publicacion" min="1000" max="9999" required>

            <label for="estado">Estado:</label>
            <select name="estado" id="estado" required>
                <option value="">Seleccione una opción</option>
                <option value="disponible">Disponible</option>
                <option value="prestado">Prestado</option>
            </select>

            <label for="categoria_id">Categoría:</label>
            <select name="categoria_id" id="categoria_id" required>
                <option value="">Seleccione una categoría</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?php echo $categoria["id"]; ?>">
                        <?php echo htmlspecialchars($categoria["nombre"]); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" rows="4"></textarea>

            <button type="submit">Guardar libro</button>
        </form>

        <div class="acciones-inferiores">
            <a class="btn-secundario" href="libros.php">Volver a libros</a>
            <a class="btn-secundario" href="dashboard.php">Panel</a>
            <a class="btn-secundario salir" href="../logout.php">Cerrar sesión</a>
        </div>
    </div>

      <script src="../js/validaciones.js"></script>

</body>
</html>