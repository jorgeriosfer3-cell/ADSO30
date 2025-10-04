<?php
ob_start(); // Inicia el buffer de salida
session_start();

/**
 * Conexión a la base de datos
 */
function conectarBD() {
    $host = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "usuario_php";
    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    return $conn;
}

/**
 * Procesar login
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if (empty($username) || empty($password)) {
        $error = "Por favor ingrese usuario y contraseña";
    } else {
        $conn = conectarBD();
        $sql = "SELECT id, username, password FROM login_user WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            // Comparación (sin hash en tu BD actual)
            if ($password === $user['password']) {
                // Crear sesión PHP
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['username']  = $user['username'];
                $_SESSION['loggedin']  = true;

                // 🔹 Generar token de 64 caracteres (sesion_id)
                $sesion_id = bin2hex(random_bytes(32));
                $_SESSION['sesion_id'] = $sesion_id;

                // 🔹 Registrar inicio de sesión en log_sistema
                $sqlLog = "INSERT INTO log_sistema (sesion_id, usuario, inicio_sesion) VALUES (?, ?, NOW())";
                $stmtLog = $conn->prepare($sqlLog);
                $stmtLog->bind_param("ss", $sesion_id, $user['username']);
                $stmtLog->execute();
                $stmtLog->close();

                // ✅ Redirigir directamente al CRUD de productos
                header("Location: productos.php");
                exit;
            } else {
                $error = "Contraseña incorrecta";
            }
        } else {
            $error = "Usuario no encontrado";
        }
        $stmt->close();
        $conn->close();
    }
}

/**
 * Procesar logout
 */
if (isset($_GET['logout'])) {
    if (isset($_SESSION['sesion_id'])) {
        $conn = conectarBD();
        $sqlCerrar = "UPDATE log_sistema SET cierre_sesion = NOW() WHERE sesion_id = ?";
        $stmtCerrar = $conn->prepare($sqlCerrar);
        $stmtCerrar->bind_param("s", $_SESSION['sesion_id']);
        $stmtCerrar->execute();
        $stmtCerrar->close();
        $conn->close();
    }

    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="estilo_login.css">
</head>
<body>
    <h2>Iniciar Sesión</h2>
    
    <?php if (isset($error)): ?>
        <div style="color:red;"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form action="login.php" method="post">
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        
        <input type="submit" name="login" value="Iniciar Sesión">
    </form>
</body>
</html>
