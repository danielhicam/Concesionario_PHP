<?php
session_start();

// Conexión a la base de datos
$server = "localhost";
$db_user = "root"; 
$db_password = "rootroot"; 
$db_name = "concesionario"; 

$conn = new mysqli($server, $db_user, $db_password, $db_name);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id_usuario']; // ID del usuario logueado

// Obtener los datos del usuario logueado
$sql = "SELECT * FROM usuarios WHERE id_usuario = $user_id";
$resultado = $conn->query($sql);
$usuario = $resultado->fetch_assoc();

// Si el formulario fue enviado, actualizamos los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['campo_a_actualizar'])) {
        $campo = $_POST['campo_a_actualizar'];
        $nuevo_valor = $_POST['nuevo_valor'];

        // Actualizamos solo el campo que fue modificado
        $actualizarSql = "UPDATE usuarios SET $campo = '$nuevo_valor' WHERE id_usuario = $user_id";
        if ($conn->query($actualizarSql) === TRUE) {
            $mensaje_exito = "$campo actualizado correctamente.";
            $_SESSION[$campo] = $nuevo_valor; // Actualizamos el valor en la sesión
        } else {
            $mensaje_error = "Error al actualizar el campo: " . $conn->error;
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
    <title>Mi Cuenta</title>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Raleway:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="usuarios.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($usuario['nombre']); ?>!</h1>
        <?php if (isset($mensaje_error)) echo "<p class='error'>$mensaje_error</p>"; ?>
        <?php if (isset($mensaje_exito)) echo "<p class='success'>$mensaje_exito</p>"; ?>

        <div class="user-data">
            <div class="data-field">
                <label>Nombre:</label>
                <span><?php echo htmlspecialchars($usuario['nombre']); ?></span>
                <form action="usuarios.php" method="post" class="mod-form">
                    <input type="text" name="nuevo_valor" placeholder="Nuevo nombre" required>
                    <input type="hidden" name="campo_a_actualizar" value="nombre">
                    <button type="submit">Modificar</button>
                </form>
            </div>

            <div class="data-field">
                <label>Apellidos:</label>
                <span><?php echo htmlspecialchars($usuario['apellidos']); ?></span>
                <form action="usuarios.php" method="post" class="mod-form">
                    <input type="text" name="nuevo_valor" placeholder="Nuevos apellidos" required>
                    <input type="hidden" name="campo_a_actualizar" value="apellidos">
                    <button type="submit">Modificar</button>
                </form>
            </div>

            <div class="data-field">
                <label>DNI:</label>
                <span><?php echo htmlspecialchars($usuario['dni']); ?></span>
                <form action="usuarios.php" method="post" class="mod-form">
                    <input type="text" name="nuevo_valor" placeholder="Nuevo DNI" required>
                    <input type="hidden" name="campo_a_actualizar" value="dni">
                    <button type="submit">Modificar</button>
                </form>
            </div>

            <div class="data-field">
                <label>Saldo:</label>
                <span><?php echo htmlspecialchars($usuario['saldo']); ?></span>
                <form action="usuarios.php" method="post" class="mod-form">
                    <input type="number" name="nuevo_valor" placeholder="Nuevo saldo" required>
                    <input type="hidden" name="campo_a_actualizar" value="saldo">
                    <button type="submit">Modificar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
