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
        $sql = "SELECT id_usuario, password, nombre, apellidos, saldo FROM usuarios WHERE dni = '$dni'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($password == $row['password']) { // Comparación directa sin password_verify()
                $_SESSION['loggedin'] = true;
                $_SESSION['id_usuario'] = $row['id_usuario'];
                $_SESSION['nombre'] = $row['nombre'];
                $_SESSION['apellidos'] = $row['apellidos'];
                $_SESSION['saldo'] = $row['saldo'];
                $_SESSION['start'] = time();
                $_SESSION['expire'] = $_SESSION['start'] + (1 * 60); // Expira en 1 minuto

                header("Location: index.html");
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
<style>
body {margin: 0; font-family: 'Libre Baskerville', serif; background-color: #111; color: #eaeaea;}
.clase1 {background-color: #000; color: #d4af37; padding: 20px 0; font-size: 36px; text-align: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.7); position: sticky; top: 0; z-index: 1000; letter-spacing: 2px;}
.form-container {width: 30%; margin: 50px auto; padding: 20px; background-color: #222; border-radius: 10px; box-shadow: 0 4px 8px rgba(255, 255, 255, 0.2);}
.form-container h2 {text-align: center; color: #d4af37;}
.form-container input {width: 96%; padding: 10px; margin: 10px 0; border: none; border-radius: 5px; font-size: 16px;}
.form-container button {width: 100%; padding: 10px; background-color: #d4af37; border: none; color: #111; font-size: 18px; border-radius: 5px; cursor: pointer;}
.form-container button:hover {background-color: #b7952b;}
.error {color: red; text-align: center;}
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
