<html>

<head>
  <title>Problema</title>
</head>

<body>

  <?php

// Generar un número aleatorio entre 1 y 3
$valor = rand(1, 3);

// Imprimir el número en castellano según el valor generado
if ($valor == 1) {
    echo "uno";
} elseif ($valor == 2) {
    echo "dos";
} elseif ($valor == 3) {
    echo "tres";
}
?>


</body>

</html>