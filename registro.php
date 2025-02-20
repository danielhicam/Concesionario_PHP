<?php
$conexion = new mysqli("localhost", "root", "rootroot", "concesionario");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $password = $_POST['password'];
    $tipo_usuario = $_POST['tipo_usuario']; // Obtener tipo de usuario
    $saldo = 0;

    // Consulta SQL actualizada para incluir tipo_usuario
    $query = "INSERT INTO usuarios (nombre, apellidos, dni, password, saldo, tipo_usuario) 
              VALUES ('$nombre', '$apellidos', '$dni', '$password', '$saldo', '$tipo_usuario')";

    if ($conexion->query($query) === TRUE) {
        $mensaje = "Registro exitoso. <br><a href='index.php'>Volver al inicio</a>";
    } else {
        $mensaje = "Error al registrar: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body {font-family: Arial, sans-serif; background-color: #111; color: #eaeaea; margin: 0; padding: 0;}
        .form-container {width: 320px; margin: 50px auto; padding: 30px; background-color: #222; border-radius: 10px; box-shadow: 0 0 10px rgba(255, 215, 0, 0.2);}
        .form-container h2 {text-align: center; margin-bottom: 20px; color: #d4af37;}
        .form-container input, .form-container select {
            width: 92%;
            padding: 12px;
            margin-bottom: 15px; /* Espacio entre los inputs */
            background-color: #333;
            color: #fff;
            border: 1px solid #555;
            border-radius: 5px;
        }
        .form-container button {width: 100%; padding: 12px; background-color: #d4af37; color: #111; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;}
        .form-container button:hover {background-color: #f0c674;}
        .mensaje {text-align: center; padding: 15px; margin-top: 20px; background-color: #444; color: #d4af37; border-radius: 5px; font-size: 16px;}
        .mensaje a {color: #d4af37; text-decoration: none; font-weight: bold;}
        .mensaje a:hover {text-decoration: underline;}
        .form-container p {text-align: center; margin-top: 20px;}
    </style>
</head>
<body>

<div class="form-container">
    <h2>Registro de Usuario</h2>
    <form method="POST" action="">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellidos" placeholder="Apellidos" required>
        <input type="text" name="dni" placeholder="DNI" required>
        <input type="password" name="password" placeholder="Contraseña" required>

        <!-- Campo para seleccionar tipo de usuario -->
        <label for="tipo_usuario" style="color: #eaeaea;">Tipo de Usuario</label>
        <select name="tipo_usuario" required>
            <option value="comprador">Comprador</option>
            <option value="vendedor">Vendedor</option>
        </select>

        <button type="submit">Registrar</button>
    </form>

    <?php
    if ($mensaje != "") {
        echo "<div class='mensaje'>$mensaje</div>";
    }
    ?>
</div>

</body>
</html>
