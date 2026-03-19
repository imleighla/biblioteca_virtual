<?php
require_once "../includes/auth_user.php";
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

// Filtro de búsqueda por título o autor
if (!empty($busqueda)) {
    $sql .= " AND (
        libros.titulo LIKE :busqueda 
        OR libros.autor LIKE :busqueda
        OR libros.edicion LIKE :busqueda
    )";
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

$sql .= " ORDER BY libros.id DESC";

$stmt = $conexion->prepare($sql);

foreach ($params as $clave => $valor) {
    $stmt->bindValue($clave, $valor);
}

$stmt->execute();
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de libros</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="contenedor contenedor-tabla">
        <h2>Catálogo de Libros</h2>

        <form method="GET" class="form-filtros">
            <input type="text" name="busqueda" placeholder="Buscar por título, autor o edición" value="<?php echo htmlspecialchars($busqueda); ?>">

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
            <a class="btn-limpiar" href="libros.php">Limpiar</a>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Edición</th>
                    <th>Año</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($libros) > 0): ?>
                    <?php foreach ($libros as $libro): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($libro["titulo"]); ?></td>
                            <td><?php echo htmlspecialchars($libro["autor"]); ?></td>
                            <td><?php echo htmlspecialchars($libro["edicion"]); ?></td>
                            <td><?php echo $libro["anio_publicacion"]; ?></td>
                            <td><?php echo htmlspecialchars($libro["categoria"]); ?></td>
                            <td><?php echo ucfirst($libro["estado"]); ?></td>
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
            <a class="btn-secundario" href="dashboard.php">Volver al panel</a>
            <a class="btn-secundario salir" href="../logout.php">Cerrar sesión</a>
        </div>
    </div>
</body>
</html>