<?php
echo "----------------------------------------------------------<br>";
// Estructuras de control Switch
echo "<h3>Con un número aleatorio del 1 al 7 determinar qué día es según el número</h3>";

$dia = 8; // rand(1, 8);
echo "Número aleatorio: $dia<br>";

switch ($dia) {
    case 1:
        echo "Hoy es Lunes";
        break;
    case 2:
        echo "Hoy es Martes";
        break;
    case 3:
        echo "Hoy es Miércoles";
        break;
    case 4:
        echo "Hoy es Jueves";
        break;
    case 5:
        echo "Hoy es Viernes";
        break;
    case 6:
        echo "Hoy es Sábado";
        break;
    case 7:
        echo "Hoy es Domingo";
        break;
    case 8:
        $num = rand(1, 100);
        echo "Número = $num, aleatorio del 1 al 100<br>";
        if ($num % 2 == 0) {
            echo "El número es Par<br>";
        } else {
            echo "El número es Impar<br>";
        }
        break;
    default:
        echo "Día no válido";
}
?>
