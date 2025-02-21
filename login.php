<?php
session_start();

// Conexión a la base de datos dentro del mismo archivo
$servername = "localhost";
$username = "root"; 
$password = "rootroot"; 
$database = "concesionario"; 

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_REQUEST['dni']) && isset($_REQUEST['password'])) {
        $dni = $_REQUEST['dni'];
        $password = $_REQUEST['password'];

        // Consulta sin prepare() basada en dni
        $sql = "SELECT id_usuario, password, nombre, apellidos, saldo, tipo_usuario FROM usuarios WHERE dni = '$dni'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($password == $row['password']) {

                $_SESSION['loggedin'] = true;
                $_SESSION['id_usuario'] = $row['id_usuario'];
                $_SESSION['nombre'] = $row['nombre'];
                $_SESSION['apellidos'] = $row['apellidos'];
                $_SESSION['saldo'] = $row['saldo'];
                $_SESSION['tipo_usuario'] = $row['tipo_usuario'];
                $_SESSION['start'] = time();
                $_SESSION['expire'] = $_SESSION['start'] + (1 * 60);

                header("Location: index.php");
                exit;
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "No se encontró una cuenta con ese DNI.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Raleway:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
    <style>
        body {margin: 0; font-family: 'Libre Baskerville', serif; background-color: #111; color: #eaeaea;}
        .clase1 {background-color: #000; color: #d4af37; padding: 20px 0; font-size: 36px; text-align: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.7); position: sticky; top: 0; z-index: 1000; letter-spacing: 2px;}
        .form-container { width: 320px; margin: 50px auto; padding: 30px; background-color: #222; border-radius: 10px; box-shadow: 0 0 10px rgba(255, 215, 0, 0.2); }
        .form-container h2 { text-align: center; margin-bottom: 20px; color: #d4af37; }
        .form-container input { width: 92%; padding: 12px; margin-bottom: 15px; background-color: #333; color: #fff; border: 1px solid #555; border-radius: 5px; }
        .form-container button { width: 100%; padding: 12px; background-color: #d4af37; color: #111; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        .form-container button:hover { background-color: #f0c674; }
        .mensaje { text-align: center; padding: 15px; margin-top: 20px; background-color: #444; color: #d4af37; border-radius: 5px; font-size: 16px; }
        .mensaje a { color: #d4af37; text-decoration: none; font-weight: bold; }
        .mensaje a:hover { text-decoration: underline; }
        .form-container p { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="clase1">Iniciar Sesión</div>
    <div class="form-container">
        <h2>Accede a tu cuenta</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form action="login.php" method="post">
            <label>DNI:</label>
            <input type="text" name="dni" required>
            <label>Contraseña:</label>
            <input type="password" name="password" required>
            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>
