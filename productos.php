<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Productos</title>
    <link rel="stylesheet" href="estilo_nuevo.css">
</head>
<body>
<?php
session_start();

/**
 * Conexión a la base de datos
 */
function conectarBD() {
    $host = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "usuario_php"; // cambia por la BD que usas para productos
    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error) {
        die("<h6 style='color:red;'>Error al conectar a la base de datos: " . $conn->connect_error . "</h6>");
    }
    return $conn;
}

/**
 * Consulta productos registrados
 */
function consultarBD() {
    $conn = conectarBD();
    $sql = "SELECT id, nombre, descripcion, precio, cantidad, imagen, created_at, updated_at FROM productos";
    $result = $conn->query($sql);
    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }
    return $result;
}

$result = consultarBD();

/**
 * Cargar datos de producto a editar
 */
$editar_producto = null;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar_id'])) {
    $conn = conectarBD();
    $id = intval($_POST['editar_id']);
    $sql = "SELECT * FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $editar_producto = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
?>

<!-- Formulario de registro/edición -->
<div class="form-container">
    <h2 class="form-title"><?php echo $editar_producto ? "Editar Producto" : "Formulario de Productos"; ?></h2>
    <form action="productos.php" method="post" enctype="multipart/form-data">
        <div style="text-align: right; margin: 10px 5%;">
            <?php
            echo "User Id: " . $_SESSION['user_id'];
            $nombreSession = session_name();
            $idSession = session_id();
            echo " |  Session Name: " . $nombreSession . "  |   Session Id: " . $idSession . "  |";
            ?>
            Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?> | 
            <a href="login.php?logout">Cerrar sesión</a>
        </div>
        <?php if ($editar_producto): ?>
            <input type="hidden" name="id" value="<?php echo $editar_producto['id']; ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" placeholder="Nombre del producto" 
                value="<?php echo $editar_producto ? htmlspecialchars($editar_producto['nombre']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <input type="text" name="descripcion" placeholder="Descripción" 
                value="<?php echo $editar_producto ? htmlspecialchars($editar_producto['descripcion']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="number" step="0.01" name="precio" placeholder="Precio" 
                value="<?php echo $editar_producto ? $editar_producto['precio'] : ''; ?>">
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" placeholder="Cantidad" 
                value="<?php echo $editar_producto ? $editar_producto['cantidad'] : ''; ?>">
        </div>

        <div class="form-group">
            <label for="imagen">Imagen</label>
            <input type="file" name="imagen">
            <p>Imagen actual: 
                <?php 
                $imagenMostrar = ($editar_producto && $editar_producto['imagen']) 
                                 ? "uploads/" . $editar_producto['imagen'] 
                                 : "/ADSO30/img/pexels-valeriiamiller-19147427.jpg";
                ?>
                <img src="<?php echo $imagenMostrar; ?>" width="50" alt="Imagen del producto">
            </p>
        </div>

        <div class="form-actions">
            <input type="submit" class="btn btn-primary" 
                name="<?php echo $editar_producto ? 'actualizar' : 'registrar'; ?>" 
                value="<?php echo $editar_producto ? 'Actualizar' : 'Registrar'; ?>">
            <?php if ($editar_producto): ?>
                <a href="productos.php" class="cancel-btn">Cancelar</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<?php
$conn = conectarBD();

/**
 * Registrar producto
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar'])) {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $cantidad = $_POST["cantidad"];

    $imagen = null;
    if (!empty($_FILES['imagen']['name'])) {
        $imagen = basename($_FILES['imagen']['name']);
        move_uploaded_file($_FILES['imagen']['tmp_name'], "uploads/" . $imagen);
    }

    $sql = "INSERT INTO productos (nombre, descripcion, precio, cantidad, imagen) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdis", $nombre, $descripcion, $precio, $cantidad, $imagen);
    if ($stmt->execute()) {
        echo "<h3 style='color:green;'>Producto registrado correctamente.</h3>";
    } else {
        echo "Error al registrar producto: " . $conn->error;
    }
    $stmt->close();
    $result = consultarBD();
}

/**
 * Actualizar producto
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar']) && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $cantidad = $_POST["cantidad"];

    $imagen = null;
    if (!empty($_FILES['imagen']['name'])) {
        $imagen = basename($_FILES['imagen']['name']);
        move_uploaded_file($_FILES['imagen']['tmp_name'], "uploads/" . $imagen);
    }

    if ($imagen) {
        $sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, cantidad=?, imagen=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdisi", $nombre, $descripcion, $precio, $cantidad, $imagen, $id);
    } else {
        $sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, cantidad=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $cantidad, $id);
    }

    if ($stmt->execute()) {
        echo "<h3 style='color:green;'>Producto actualizado correctamente.</h3>";
    } else {
        echo "Error al actualizar producto: " . $conn->error;
    }
    $stmt->close();
    $result = consultarBD();
}

/**
 * Eliminar producto
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar_id'])) {
    $id = intval($_POST['eliminar_id']);
    $sql = "DELETE FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<h3 style='color:red;'>Producto eliminado correctamente.</h3>";
    } else {
        echo "<h3 style='color:red;'>Error al eliminar producto: " . $conn->error . "</h3>";
    }
    $stmt->close();
}
$result = consultarBD();
?>

<!-- Tabla de productos -->
<table border="1" cellpadding="5" cellspacing="0" style="margin-top:30px; width:100%;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Creado</th>
            <th>Actualizado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td>
                        <?php 
                        $imgTabla = $row['imagen'] ? "uploads/" . htmlspecialchars($row['imagen']) 
                                                    : "/ADSO30/img/pexels-valeriiamiller-19147427.jpg";
                        ?>
                        <img src="<?php echo $imgTabla; ?>" width="50" alt="Imagen del producto">
                    </td>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($row['precio']); ?></td>
                    <td><?php echo htmlspecialchars($row['cantidad']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    <td><?php echo htmlspecialchars($row['updated_at']); ?></td>
                    <td>
                        <form method="post" style="display:inline;" onsubmit="return confirm('¿Eliminar este producto?');">
                            <input type="hidden" name="eliminar_id" value="<?php echo $row['id']; ?>">
                            <input type="submit" value="Eliminar">
                        </form>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="editar_id" value="<?php echo $row['id']; ?>">
                            <input type="submit" value="Editar">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>     
        <?php else: ?>
            <tr><td colspan="9" style="text-align:center;">No hay productos registrados</td></tr>
        <?php endif; ?>
    </tbody>
</table>
</body>
</html>
