<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Login</title>
</head>
<body>
<h2>Login</h2>
<form method="post">
    Usuario: <input type="text" name="usuario"><br><br>
    Contraseña: <input type="password" name="clave"><br><br>
    <input type="submit" value="Enviar">
</form>

<?php
class Login {
    private $usuario;
    private $clave;

    public function __construct($usuario, $clave) {
        $this->usuario = $usuario;
        $this->clave = $clave;
    }

    public function mostrar() {
        echo "<h3>Datos ingresados:</h3>";
        echo "Usuario: " . $this->usuario . "<br>";
        echo "Contraseña: " . $this->clave . "<br>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = new Login($_POST['usuario'], $_POST['clave']);
    $login->mostrar();
}
?>
</body>
</html>
