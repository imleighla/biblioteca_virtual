<?php
// Archivo principal de gestión de libros para el administrador.
// Permite listar, buscar y filtrar libros registrados en el sistema.

require_once "../includes/auth_admin.php";
require_once "../includes/conexion.php";

// Se cargan las categorías para usarlas en el formulario de filtros.
$sql_categorias = "SELECT * FROM categorias ORDER BY nombre ASC";
$stmt_categorias = $conexion->prepare($sql_categorias);
$stmt_categorias->execute();
$categorias = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);

// Se capturan los valores enviados desde los filtros de búsqueda.
$busqueda = isset($_GET["busqueda"]) ? trim($_GET["busqueda"]) : "";
$categoria_id = isset($_GET["categoria_id"]) ? trim($_GET["categoria_id"]) : "";
$anio = isset($_GET["anio"]) ? trim($_GET["anio"]) : "";

// Consulta base para mostrar los libros junto con el nombre de su categoría.
$sql = "SELECT libros.*, categorias.nombre AS categoria
        FROM libros
        INNER JOIN categorias ON libros.categoria_id = categorias.id
        WHERE 1=1";

$params = [];

// Se obtienen los totales para mostrar en el resumen de libros.
$sql_total = "SELECT COUNT(*) AS total FROM libros";
$stmt_total = $conexion->prepare($sql_total);
$stmt_total->execute();
$total_libros = $stmt_total->fetch(PDO::FETCH_ASSOC)["total"];

$sql_disponibles = "SELECT COUNT(*) AS total FROM libros WHERE estado = 'disponible'";
$stmt_disponibles = $conexion->prepare($sql_disponibles);
$stmt_disponibles->execute();
$total_disponibles = $stmt_disponibles->fetch(PDO::FETCH_ASSOC)["total"];

$sql_prestados = "SELECT COUNT(*) AS total FROM libros WHERE estado = 'prestado'";
$stmt_prestados = $conexion->prepare($sql_prestados);
$stmt_prestados->execute();
$total_prestados = $stmt_prestados->fetch(PDO::FETCH_ASSOC)["total"];

// Se aplica búsqueda por título, autor o edición si el usuario escribió un texto.
if (!empty($busqueda)) {
    $sql .= " AND (
        libros.titulo LIKE :busqueda 
        OR libros.autor LIKE :busqueda
        OR libros.edicion LIKE :busqueda
    )";
    $params[":busqueda"] = "%" . $busqueda . "%";
}

// Se aplica búsqueda por título, autor o edición si el usuario escribió un texto.
if (!empty($categoria_id)) {
    $sql .= " AND libros.categoria_id = :categoria_id";
    $params[":categoria_id"] = $categoria_id;
}

// Se aplica filtro por año si fue ingresado un valor.
if (!empty($anio)) {
    $sql .= " AND libros.anio_publicacion = :anio";
    $params[":anio"] = $anio;
}

// Orden actual
$sql .= " ORDER BY libros.id DESC";
// Se prepara y ejecuta la consulta final con los filtros aplicados.
$stmt = $conexion->prepare($sql);

foreach ($params as $clave => $valor) {
    $stmt->bindValue($clave, $valor);
}

$stmt->execute();
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mensajes
$mensaje = "";
$tipoMensaje = "";
// Se prepara y ejecuta la consulta final con los filtros aplicados.
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
        
        <div class="resumen-libros">
            <div class="card-resumen">
                <h3><?php echo $total_libros; ?></h3>
                <p>Total de libros</p>
            </div>

            <div class="card-resumen">
                <h3><?php echo $total_disponibles; ?></h3>
                <p>Libros disponibles</p>
            </div>

            <div class="card-resumen">
                <h3><?php echo $total_prestados; ?></h3>
                <p>Libros prestados</p>
            </div>
        </div>

        <?php if (!empty($mensaje)) : ?>
            <p class="mensaje <?php echo $tipoMensaje; ?>">
                <?php echo $mensaje; ?>
            </p>
        <?php endif; ?>
        <!-- Formulario para buscar y filtrar libros -->
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
      <!-- Tabla con scroll interno para visualizar muchos registros sin alargar la página -->  
      <div class="tabla-scroll">
        <table>
                <thead>
                    <tr>
                       <th>Título</th>
                       <th>Autor</th>
                       <th>Edición</th>
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
                            <td><?php echo htmlspecialchars($libro["titulo"]); ?></td>
                            <td><?php echo htmlspecialchars($libro["autor"]); ?></td>
                            <td><?php echo htmlspecialchars($libro["edicion"]); ?></td>
                            <td><?php echo $libro["anio_publicacion"]; ?></td>
                            <td><?php echo htmlspecialchars($libro["categoria"]); ?></td>
                            <td><?php echo ucfirst($libro["estado"]); ?></td>
                            <!-- Tabla con scroll interno para visualizar muchos registros sin alargar la página -->
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
      </div>
      <!-- Acciones disponibles para editar o eliminar cada libro -->
        <div class="acciones-inferiores">
            <a class="btn-secundario" href="agregar_libro.php">Agregar libro</a>
            <a class="btn-secundario" href="dashboard.php">Volver al panel</a>
            <a class="btn-secundario salir" href="../logout.php">Cerrar sesión</a>
        </div>
    </div>
</body>
</html>