<?php
require_once "../includes/auth_admin.php";
require_once "../includes/conexion.php";

// Obtener categorías para el filtro
$sql_categorias = "SELECT * FROM categorias ORDER BY nombre ASC";
$stmt_categorias = $conexion->prepare($sql_categorias);
$stmt_categorias->execute();
$categorias = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);

// Capturar filtros
$busqueda = isset($_GET["busqueda"]) ? trim($_GET["busqueda"]) : "";
$categoria_id = isset($_GET["categoria_id"]) ? trim($_GET["categoria_id"]) : "";
$anio = isset($_GET["anio"]) ? trim($_GET["anio"]) : "";

// Consulta base
$sql = "SELECT libros.*, categorias.nombre AS categoria
        FROM libros
        INNER JOIN categorias ON libros.categoria_id = categorias.id
        WHERE 1=1";

$params = [];

// Filtro por búsqueda
if (!empty($busqueda)) {
    $sql .= " AND (libros.titulo LIKE :busqueda OR libros.autor LIKE :busqueda)";
    $params[":busqueda"] = "%" . $busqueda . "%";
}

// Filtro por categoría
if (!empty($categoria_id)) {
    $sql .= " AND libros.categoria_id = :categoria_id";
    $params[":categoria_id"] = $categoria_id;
}

// Filtro por año
if (!empty($anio)) {
    $sql .= " AND libros.anio_publicacion = :anio";
    $params[":anio"] = $anio;
}

// Orden actual
$sql .= " ORDER BY libros.id DESC";

$stmt = $conexion->prepare($sql);

foreach ($params as $clave => $valor) {
    $stmt->bindValue($clave, $valor);
}

$stmt->execute();
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mensajes
$mensaje = "";
$tipoMensaje = "";

if (isset($_GET["mensaje"])) {
    if ($_GET["mensaje"] == "eliminado") {
        $mensaje = "Libro eliminado correctamente.";
        $tipoMensaje = "exito";
    } elseif ($_GET["mensaje"] == "agregado") {
        $mensaje = "Libro agregado correctamente.";
        $tipoMensaje = "exito";
    } elseif ($_GET["mensaje"] == "actualizado") {
        $mensaje = "Libro actualizado correctamente.";
        $tipoMensaje = "exito";
    } elseif ($_GET["mensaje"] == "error") {
        $mensaje = "Ocurrió un error al realizar la operación.";
        $tipoMensaje = "error";
    } elseif ($_GET["mensaje"] == "no_encontrado") {
        $mensaje = "El libro no fue encontrado.";
        $tipoMensaje = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Libros</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="contenedor contenedor-tabla">
        <h2>Gestión de Libros</h2>

        <?php if (!empty($mensaje)) : ?>
            <p class="mensaje <?php echo $tipoMensaje; ?>">
                <?php echo $mensaje; ?>
            </p>
        <?php endif; ?>

        <form method="GET" class="form-filtros">
            <input type="text" name="busqueda" placeholder="Buscar por título o autor" value="<?php echo htmlspecialchars($busqueda); ?>">

            <select name="categoria_id">
                <option value="">Todas las categorías</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?php echo $categoria["id"]; ?>" <?php echo ($categoria_id == $categoria["id"]) ? "selected" : ""; ?>>
                        <?php echo htmlspecialchars($categoria["nombre"]); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="number" name="anio" placeholder="Año" value="<?php echo htmlspecialchars($anio); ?>" min="1000" max="9999">

            <button type="submit">Filtrar</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Año</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($libros) > 0): ?>
                    <?php foreach ($libros as $libro): ?>
                        <tr>
                            <td><?php echo $libro["id"]; ?></td>
                            <td><?php echo htmlspecialchars($libro["titulo"]); ?></td>
                            <td><?php echo htmlspecialchars($libro["autor"]); ?></td>
                            <td><?php echo $libro["anio_publicacion"]; ?></td>
                            <td><?php echo htmlspecialchars($libro["categoria"]); ?></td>
                            <td><?php echo ucfirst($libro["estado"]); ?></td>
                            <td>
                                <a class="btn-accion editar" href="editar_libro.php?id=<?php echo $libro["id"]; ?>">Editar</a>
                                <a class="btn-accion eliminar" href="eliminar_libro.php?id=<?php echo $libro["id"]; ?>" onclick="return confirm('¿Seguro que deseas eliminar este libro?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No se encontraron libros con esos filtros.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="acciones-inferiores">
            <a class="btn-secundario" href="agregar_libro.php">Agregar libro</a>
            <a class="btn-secundario" href="dashboard.php">Volver al panel</a>
            <a class="btn-secundario salir" href="../logout.php">Cerrar sesión</a>
        </div>
    </div>
</body>
</html>