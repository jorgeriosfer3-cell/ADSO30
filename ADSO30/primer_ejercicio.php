<?php
$nombre = "Jorge Rios";
$doc = 1012654213;
$sexo = true;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo PHP</title>
</head>
<body>
    <h3>Nombre: <?= $nombre ?></h3>
    <h4>Documento: <?= $doc ?></h4>
    <p>El número de <?= $nombre ?> es: <?= $doc ?></p>
    <p>El sexo de <?= $nombre ?> es: <?= $sexo ? "Masculino" : "Femenino" ?></p>
</body>
</html>
