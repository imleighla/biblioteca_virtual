<?php
// Este archivo permite modificar la información de un libro ya registrado.
// Se protege esta página para que solo el administrador tenga acceso.
require_once "../includes/auth_admin.php";
require_once "../includes/conexion.php";

$mensaje = "";
$color = "";

// Se valida que se haya recibido el identificador del libro a editar. Si no, se redirige al listado.
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("Location: libros.php");
    exit();
}

$id = $_GET["id"];

// Se obtienen las categorías para mostrarlas en el formulario de edición.
$sql_categorias = "SELECT * FROM categorias ORDER BY nombre ASC";
$stmt_categorias = $conexion->prepare($sql_categorias);
$stmt_categorias->execute();
$categorias = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);

// Se buscan los datos actuales del libro seleccionado. 
$sql_libro = "SELECT * FROM libros WHERE id = :id LIMIT 1";
$stmt_libro = $conexion->prepare($sql_libro);
$stmt_libro->bindParam(":id", $id);
$stmt_libro->execute();
$libro = $stmt_libro->fetch(PDO::FETCH_ASSOC);

// Si el libro no existe, se regresa al listado principal.
if (!$libro) {
    header("Location: libros.php");
    exit();
}
// Si el libro no existe, se regresa al listado principal.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST["titulo"]);
    $autor = trim($_POST["autor"]);
    $edicion = trim($_POST["edicion"]);
    $anio_publicacion = trim($_POST["anio_publicacion"]);
    $estado = trim($_POST["estado"]);
    $categoria_id = trim($_POST["categoria_id"]);
    $descripcion = trim($_POST["descripcion"]);

    if (empty($titulo) || empty($autor) || empty($edicion) || empty($anio_publicacion) || empty($estado) || empty($categoria_id)) {
        $mensaje = "Todos los campos obligatorios deben completarse.";
        $color = "red";
    } elseif (!is_numeric($anio_publicacion) || strlen($anio_publicacion) != 4) {
        $mensaje = "El año de publicación no es válido.";
        $color = "red";
    } else {
        // Si el formulario fue enviado, se capturan los nuevos datos del libro.
        $sql_update = "UPDATE libros 
                       SET titulo = :titulo,
                           autor = :autor,
                           edicion = :edicion,
                           anio_publicacion = :anio_publicacion,
                           estado = :estado,
                           categoria_id = :categoria_id,
                           descripcion = :descripcion
                       WHERE id = :id";

        $stmt_update = $conexion->prepare($sql_update);
        $stmt_update->bindParam(":titulo", $titulo);
        $stmt_update->bindParam(":autor", $autor);
        $stmt_update->bindParam(":edicion", $edicion);
        $stmt_update->bindParam(":anio_publicacion", $anio_publicacion);
        $stmt_update->bindParam(":estado", $estado);
        $stmt_update->bindParam(":categoria_id", $categoria_id);
        $stmt_update->bindParam(":descripcion", $descripcion);
        $stmt_update->bindParam(":id", $id);
        // Si la actualización es exitosa, se redirige al listado con mensaje de confirmación.
        if ($stmt_update->execute()) {
            header("Location: libros.php?mensaje=actualizado");
            exit();
            // Recargar datos actualizados
            $stmt_libro = $conexion->prepare("SELECT * FROM libros WHERE id = :id LIMIT 1");
            $stmt_libro->bindParam(":id", $id);
            $stmt_libro->execute();
            $libro = $stmt_libro->fetch(PDO::FETCH_ASSOC);
        } else {
            $mensaje = "Error al actualizar el libro.";
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
    <title>Editar libro</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="contenedor">
        <h2>Editar libro</h2>

        <?php if (!empty($mensaje)) : ?>
            <p class="mensaje <?php echo ($color == 'green') ? 'exito' : 'error'; ?>">
                <?php echo $mensaje; ?>
            </p>
        <?php endif; ?>

        <form action="" method="POST" id="formLibro">
            <label for="titulo">Título del libro:</label>
            <input type="text" name="titulo" id="titulo" required value="<?php echo htmlspecialchars($libro['titulo']); ?>">

            <label for="autor">Autor:</label>
            <input type="text" name="autor" id="autor" required value="<?php echo htmlspecialchars($libro['autor']); ?>">

            <label for="edicion">Edición:</label>
            <input type="text" name="edicion" id="edicion" required value="<?php echo htmlspecialchars($libro['edicion']); ?>">

            <label for="anio_publicacion">Año de publicación:</label>
            <input type="number" name="anio_publicacion" id="anio_publicacion" min="1000" max="9999" required value="<?php echo $libro['anio_publicacion']; ?>">

            <label for="estado">Estado:</label>
            <select name="estado" id="estado" required>
                <option value="disponible" <?php echo ($libro['estado'] == 'disponible') ? 'selected' : ''; ?>>Disponible</option>
                <option value="prestado" <?php echo ($libro['estado'] == 'prestado') ? 'selected' : ''; ?>>Prestado</option>
            </select>

            <label for="categoria_id">Categoría:</label>
            <select name="categoria_id" id="categoria_id" required>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?php echo $categoria['id']; ?>"
                        <?php echo ($libro['categoria_id'] == $categoria['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($categoria['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" rows="4"><?php echo htmlspecialchars($libro['descripcion']); ?></textarea>

            <button type="submit">Actualizar libro</button>
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