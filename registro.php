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

    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Consulta SQL actualizada para incluir tipo_usuario
    $query = "INSERT INTO usuarios (nombre, apellidos, dni, password, saldo, tipo_usuario) 
          VALUES ('$nombre', '$apellidos', '$dni', '$password_hash', '$saldo', '$tipo_usuario')";


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
    <link rel="stylesheet" href="registro.css">
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

<a href="index.php">
        <button style="margin-top: 10px;">Volver al inicio</button>
    </a>
</div>

</body>
</html>
