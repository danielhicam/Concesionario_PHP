<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $loggedIn = false;
} else {
    $loggedIn = true;
    $nombre = $_SESSION['nombre'];
    $apellidos = $_SESSION['apellidos'];
    $saldo = $_SESSION['saldo'];
    $tipo_usuario = $_SESSION['tipo_usuario'];
}
if (isset($_POST['logout'])) {
    session_destroy();  
    $_SESSION = [];     
    header('Location: index.php'); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Buscar Coches</title>
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Raleway:wght@300;400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="listar.css">
</head>
<body>
<div class="clase1">Agenda de Alquileres
<div class="clase2">

<div class="clase3">Coches<div class="clase6"> 
<?php if (isset($_SESSION['nombre']) && $_SESSION['tipo_usuario'] === "comprador") 
{ ?> <a href="index.php">Inicio</a><a href="listar.php">Catalogo de Alquileres</a> <?php } 
elseif (isset($_SESSION['nombre']) && $_SESSION['tipo_usuario'] === "admin") 
{ ?><a href="index.php">Inicio</a><a href="añadir.php">Añadir</a><a href="listar.php">Listar</a><a href="buscar.php">Buscar</a><a href="modificar.php">Modificar</a><a href="borrar.php">Borrar</a> <?php } 
elseif (isset($_SESSION['nombre']) && $_SESSION['tipo_usuario'] === "vendedor") 
{ ?> <a href="index.php">Inicio</a><a href="listar.php">Listar</a><a href="buscar.php">Buscar</a> <a href="añadir.php">Anunciar Alquiler</a><a href="borrar.php">Borrar mis Coches</a> <a href="modificar.php">Modificar mis Coches</a><?php } 
else 
{ ?> <a href="index.php">Inicio</a><a href="listar.php">Listar</a> <a href="buscar.php">Buscar</a> <?php } ?>
</div>
</div>

<div class="clase3">Usuarios<div class="clase6"> 
<?php if (isset($_SESSION['nombre']) && $_SESSION['tipo_usuario'] === "comprador") 
{ ?> <a href="index.php">No hay Permisos</a> <?php } 
elseif (isset($_SESSION['nombre']) && $_SESSION['tipo_usuario'] === "admin") 
{ ?><a href="index2.php">Inicio</a><a href="añadir2.php">Añadir</a><a href="listar2.php">Listar</a><a href="buscar2.php">Buscar</a><a href="modificar2.php">Modificar</a><a href="borrar2.php">Borrar</a> <?php } 
elseif (isset($_SESSION['nombre']) && $_SESSION['tipo_usuario'] === "vendedor") 
{ ?><a href="index.php">No hay Permisos</a> <?php } 
else 
{ ?> <a href="index.php">No hay Permisos</a> <?php } ?>
</div>
</div>

<div class="clase3">Alquiler<div class="clase6"> 
<?php if (isset($_SESSION['nombre']) && $_SESSION['tipo_usuario'] === "comprador") 
{ ?> <a href="index.php">Inicio</a><a href="listar_alquileres.php">Listar todos los Alquileres</a><a href="historial_alquiler.php">Historial de Alquileres</a> <a href="devolver_alquiler.php">Devolver Alquileres</a> <?php } 
elseif (isset($_SESSION['nombre']) && $_SESSION['tipo_usuario'] === "admin") 
{ ?><a href="index.php">Inicio</a><a href="añadir.php">Añadir</a><a href="listar.php">Listar</a><a href="buscar.php">Buscar</a><a href="modificar.php">Modificar</a><a href="borrar.php">Borrar</a> <?php } 
elseif (isset($_SESSION['nombre']) && $_SESSION['tipo_usuario'] === "vendedor") 
{ ?> <a href="index.php">Inicio</a><a href="listar.php">Listar Alquiler</a> <a href="buscar.php">Buscar Alquiler</a> <?php } 
else 
{ ?> <a href="registro.php">Registrate Para Acceder</a> <?php } ?>
</div></div></div>
<div class="claseR">
<?php if ($loggedIn): ?>
    <div class="clase3">Hola, <?php echo $nombre; ?> <?php echo $apellidos; ?></div>
    <form method="post">
        <button class="clase3" name="logout" type="submit">Log Out</button>
    </form>
<?php else: ?>
    <div class="clase3"><a href="registro.php">Registrarse</a></div>
    <div class="clase3"><a href="login.php">Login</a></div>
<?php endif; ?>

</div>
</div>
<div class="clase4">
<?php
$conn = mysqli_connect("localhost", "root", "rootroot", "concesionario");
if (!$conn) {
    die("<h2>Error de conexión: " . mysqli_connect_error() . "</h2>");
}

// Consultar los alquileres
$sql = "SELECT alquileres.id_alquiler, alquileres.id_usuario, alquileres.id_coche, alquileres.prestado, alquileres.devuelto, coches.modelo, coches.marca 
        FROM alquileres
        JOIN coches ON alquileres.id_coche = coches.id_coche
        ORDER BY alquileres.prestado DESC";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    echo "<h1>Listado de Alquileres</h1>";

    echo "<table>";
    echo "<tr>
            <th>Usuario</th>
            <th>Coche</th>
            <th>Fecha de Alquiler</th>
            <th>Fecha de Devolución</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        $usuario_id = $row['id_usuario'];
        $coche_id = $row['id_coche'];

        // Obtener el nombre del usuario
        $sql_usuario = "SELECT nombre, apellidos FROM usuarios WHERE id_usuario = '$usuario_id'";
        $result_usuario = mysqli_query($conn, $sql_usuario);
        $usuario = mysqli_fetch_assoc($result_usuario);
        
        // Obtener los datos del coche
        $sql_coche = "SELECT modelo, marca FROM coches WHERE id_coche = '$coche_id'";
        $result_coche = mysqli_query($conn, $sql_coche);
        $coche = mysqli_fetch_assoc($result_coche);

        echo "<tr>";
        echo "<td>" . htmlspecialchars($usuario['nombre']) . " " . htmlspecialchars($usuario['apellidos']) . "</td>";
        echo "<td>" . htmlspecialchars($coche['modelo']) . " " . htmlspecialchars($coche['marca']) . "</td>";
        echo "<td>" . htmlspecialchars($row['prestado']) . "</td>";
        echo "<td>" . ($row['devuelto'] ? htmlspecialchars($row['devuelto']) : 'No devuelto') . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No hay alquileres registrados.</p>";
}

mysqli_close($conn);
?>
</div>
</body>
</html>
