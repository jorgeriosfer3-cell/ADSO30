https://www.pexels.com/es-es/foto/moda-amarillo-lujo-naranja-19147427/<?php
session_start();

// Conexión a la base de datos
function conectarBD() {
    $host = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "usuario_php";

    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error) {
        die("<h3 style='color:red;'>Error al conectar a la base de datos: " . $conn->connect_error . "</h3>");
    }
    return $conn;
}

$conn = conectarBD();

// --- AGREGAR PRODUCTO ---
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    // Si eliges subir archivo desde el formulario
    $archivo = null;
    if (!empty($_POST['imagen_existente'])) {
        // Usar imagen ya existente en la carpeta img/
        $archivo = $_POST['imagen_existente'];
    } elseif (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $archivo = $_FILES['imagen']['name'];
        $temporal = $_FILES['imagen']['tmp_name'];
        $destino = "img/" . $archivo;
        move_uploaded_file($temporal, $destino);
    }

    $sql = "INSERT INTO productos (imagen, nombre, descripcion, precio, cantidad) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdi", $archivo, $nombre, $descripcion, $precio, $cantidad);
    if ($stmt->execute()) {
        $mensaje = "Producto agregado correctamente.";
    } else {
        $error = "Error al agregar producto: " . $conn->error;
    }
    $stmt->close();
}

// --- LEER PRODUCTOS ---
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="nuevo.css">
</head>
<body>
    <h2>Agregar Producto</h2>

    <?php if (isset($mensaje)) echo "<h3 style='color:green;'>$mensaje</h3>"; ?>
    <?php if (isset($error)) echo "<h3 style='color:red;'>$error</h3>"; ?>

    <form action="productos.php" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>

        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion">

        <label for="precio">Precio:</label>
        <input type="number" step="0.01" name="precio" required>

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" required>

        <label>Seleccionar imagen existente:</label>
        <select name="imagen_existente">
            <option value="">-- Ninguna --</option>
            <?php
            $imagenes = glob("img/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
            foreach($imagenes as $img) {
                $archivo = basename($img);
                echo "<option value='$archivo'>$archivo</option>";
            }
            ?>
        </select>

        <label>O subir nueva imagen:</label>
        <input type="file" name="imagen" accept="image/*">

        <input type="submit" name="agregar" value="Agregar Producto">
    </form>

    <h2>Lista de Productos</h2>
    <table>
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
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td>
                            <?php if($row['imagen']): ?>
                                <img src="img/<?php echo htmlspecialchars($row['imagen']); ?>" width="50" alt="miniatura">
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($row['precio']); ?></td>
                        <td><?php echo htmlspecialchars($row['cantidad']); ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td><?php echo $row['updated_at']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8" style="text-align:center;">No hay productos registrados</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
