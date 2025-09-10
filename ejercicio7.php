<html>

<head>
  <title>Problema</title>
</head>

<body>

  <?php
  //Generar un valor aleatorio entre 1 y 100. Luego mostrar
  //si tiene 1,2 o 3 dígitos.

  $valor = rand(1, 100);
  echo "El valor sorteado es $valor<br>";
  if ($valor <= 9) {
    echo "Tiene un dígito";
  } else {
    if ($valor < 100) {
      echo "Tiene 2 dígitos";
    } else {
      echo "Tiene 3 dígitos";
    }
  }
  ?>

</body>

</html>