<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
</head>
<body>
    <!-- Formulario HTML -->
    <form action="formulario.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>
        <label for="apellido">apellido</label>
        <input type="text" id="apellido" name="apellido" required><br>
        <input type="sublimit" value="Enviar">

    </form>

    <?php
    // procesamiento del formulario PHP - servidor
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        echo "Formulario enviado con éxito.<br>";
        echo "Nombre: " . $nombre . "<br>";
        echo "Apellido: " . $apellido . "<br>";
    }
    ?>
</body>
</html>