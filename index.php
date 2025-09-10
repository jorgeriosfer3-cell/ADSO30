<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clase de PHP</title>
</head>
<body>
    <?php 
        //esto es un ejercicio de variables en php
        //estos son arrays
        $numero = "123";
        $array = array("uno","dos","tres");
        echo "<h1>Array de ejemplo:</h1>";
        echo "<p>Los Elementos: ".$array[0].", ".$array[1]." y ".$array[2]."</p>"; #el punto . se usa para concatenar
        //Ejercicios de operadores aritmeticos.
        $a = 10;
        $b = 5;
        $suma = $a + $b;
        $resta = $a - $b;
        $multiplica = $a * $b;
        $divide = $a / $b;

        echo "<h1>Operadores Aritmeticos</h1>";
        echo "<p>La Suma de $a y $b es: $suma </p>";
        echo "<p>La Resta de $a y $b es: $resta </p>";
        echo "<p>La Multiplicacion de $a y $b es: $multiplica</p>";
        echo "<p>La Divicion de $a y $b es: $divide</p>";

        //Ejercicio en clase
        /*
        El señor carlos y su esposa tiene 5 hijos y 2 nietos
        los nietos tuvieron 5 hijos cada uno
        pasado el tiempo fallecieron 2 hijos y un nieto
        el señor carlos muy triste cuenta cuantas personas quedan en su familia
        incluyendolo a el y la esposa.
        Realizar la formula e imprimir el resultado.
        */
        $nombre = "Carlos";
        $can_hijos = 5;
        $can_nietos = 2;
        $hijos_nietos = $can_nietos * 5;
        $hijos_fallecidos = 2;
        $nietos_fallecidos =1;
        $total_familiares = 2 + $can_hijos + $can_nietos + $hijos_nietos - $hijos_fallecidos - $nietos_fallecidos;
        echo "<p>El señor $nombre Lequeda un total de $total_familiares Familiares con vida incluyendolo a el</p>";
        echo "Total Hijos restantes: ". ($can_hijos - $hijos_fallecidos)."<br>";
        echo "Total Nietos restantes:". ($can_nietos-$nietos_fallecidos)."<br>";
        echo "Total Bis Nietos restantes:".($hijos_nietos)."<br>";

        //Ejerciciosde estructuras de control
        //Determinar el numero mayor de dos numeros
        $num1 = 15;
        $num2 = 20;
        $num3 = 30;
        if ($num1 > $num2){
            echo "El numero mayor es: $num1";
        }else{
            echo "El numero mayor es: $num2 <br>";
        }
        // determinar el numero mayor de 3 numeros
        
        if ($num1 > $num2 && $num1 > $num3){
            echo "El numero mayor es: $num1";
        }elseif($num2 > $num1 && $num2 > $num3) {
            echo "El numero mayor es: $num2";
        }else{
            echo "El numero mayor es: $num3 <br>";
        }

        //Detirminar el indice de masa corporal
        //IMC = Peso(kg)/Estatura(m*m) leer desde la 17 a 45 n el manual
        //ejercicios del 1 al 7 en la plataforma
        $altura = 1.7;
        $peso = 85;
        $imc = $peso/($altura*2);
        echo "Altura: $altura m <BR>";
        echo "Peso: $peso KG";
        echo "Indice de masa corporal:"."IMC=" .$peso / ($altura*2)."<br>";
        echo "Resultado $imc";
        
        ?>
</body>
</html>