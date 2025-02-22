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
<title>Buscar Usuarios</title>
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Raleway:wght@300;400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="borrar2.css">
</head>
<body>
<div class="clase1">Gestión de Usuarios
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
if (!$conn) 
{die("<h2>Error de conexión: " . mysqli_connect_error() . "</h2>");}
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{if (isset($_POST['delete_ids']) && is_array($_POST['delete_ids'])) 
{$ids_to_delete = implode(",", array_map('intval', $_POST['delete_ids']));
$sql = "DELETE FROM usuarios WHERE id_usuario IN ($ids_to_delete)";
if (mysqli_query($conn, $sql)) {
echo "<h1>Usuarios eliminados correctamente</h1>";
echo "<div class='volver'><a href='borrar.php' class='clasess'>Volver</a></div>";
} 
else
{echo "<h1>Error al eliminar usuarios: " . mysqli_error($conn) . "</h1>";}} 
else 
{echo "<h1>No se seleccionaron usuarios para eliminar</h1>";
echo "<div class='volver'><a href='borrar.php' class='clasess'>Volver</a></div>";}} 
else {$sql = "SELECT id_usuario, nombre, apellidos, dni, saldo FROM usuarios";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) 
{echo "<h1>Listado de Usuarios</h1>";
echo "<form method='POST'>";
echo "<table>";
echo "<tr>
<th>Seleccionar</th>
<th>Nombre</th>
<th>Apellidos</th>
<th>DNI</th>
<th>Saldo</th>
</tr>";
while ($row = mysqli_fetch_assoc($result)) 
{echo "<tr>";
echo "<td><input type='checkbox' name='delete_ids[]' value='" . htmlspecialchars($row['id_usuario']) . "'></td>";
echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
echo "<td>" . htmlspecialchars($row['apellidos']) . "</td>";
echo "<td>" . htmlspecialchars($row['dni']) . "</td>";
echo "<td>" . htmlspecialchars($row['saldo']) . " €</td>";
echo "</tr>";
}
echo "</table>";
echo "<br>";
echo "<div style='text-align: center; margin-top: 20px;'>
<button type='submit'><b>ELIMINAR SELECCIONADOS</b></button>
</div>";
echo "</form>";
} else {
echo "<h1>No hay usuarios</h1>";}}
mysqli_close($conn);
?>
</body>
</html>
