<?php 
// Esto es código PHP
$nombre = "Jorge Rios";
$doc = 1012654213;

// Mostrar nombre y documento
echo "<h3>Nombre: $nombre</h3>";
echo "<h4>Documento: $doc</h4>";
echo "<p>El número de $nombre es: $doc</p>";

// Mostrar sexo de manera legible
$sexo = true; // true = hombre, false = mujer
echo "<p>El sexo de $nombre es: " . ($sexo ? "hombre" : "mujer") . "</p>";

// Ejemplos adicionales de variables sin sobrescribir
$numero = 16288432;
echo "<h3>El número de Jorge es: $numero</h3>";

$decimal = 1.345;
echo "<h3>Otro número: $decimal</h3>";

$texto = "es su nombre";
echo "<p>Texto: $texto</p>";

// Otro ejemplo de sexo usando booleano
$sexoJorge = false; // false = mujer
echo "<p>El sexo de Jorge es: " . ($sexoJorge ? "hombre" : "mujer") . "</p>";
?>
