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
    $id_usuario = $_SESSION['id_usuario'];
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
<link rel="stylesheet" href="borrar.css">
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
if (!$conn) 
{die("<h2>Error de conexión: " . mysqli_connect_error() . "</h2>");}
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{if (isset($_POST['delete_ids']) && is_array($_POST['delete_ids'])) 
{$ids_to_delete = implode(",", array_map('intval', $_POST['delete_ids']));
$sql = "DELETE FROM coches WHERE id_coche IN ($ids_to_delete)";
if (mysqli_query($conn, $sql)) {
echo "<h1>Coches eliminados correctamente</h1>";
echo "<div class='volver'><a href='borrar.php' class='clasess'>Volver</a></div>";
} 
else
{echo "<h1>Error al eliminar coches: " . mysqli_error($conn) . "</h1>";}} 
else 
{echo "<h1>No se seleccionaron coches para eliminar</h1>";
echo "<div class='volver'><a href='borrar.php' class='clasess'>Volver</a></div>";}} 
else {$sql = "SELECT id_coche, modelo, marca, color, precio, alquilado, foto FROM coches where id_usuario = $id_usuario";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) 
{echo "<h1>Listado de Coches</h1>";
echo "<form method='POST'>";
echo "<table>";
echo "<tr>
<th>Seleccionar</th>
<th>Modelo</th>
<th>Marca</th>
<th>Color</th>
<th>Precio</th>
<th>Alquilado</th>
<th>Foto</th>
</tr>";
while ($row = mysqli_fetch_assoc($result)) 
{echo "<tr>";
echo "<td><input type='checkbox' name='delete_ids[]' value='" . htmlspecialchars($row['id_coche']) . "'></td>";
echo "<td>" . htmlspecialchars($row['modelo']) . "</td>";
echo "<td>" . htmlspecialchars($row['marca']) . "</td>";
echo "<td>" . htmlspecialchars($row['color']) . "</td>";
echo "<td>" . htmlspecialchars($row['precio']) . "</td>";
echo "<td>" . ($row['alquilado'] ? 'Sí' : 'No') . "</td>";
echo "<td><img src='img/" . htmlspecialchars($row['foto'])  . "' alt='Sin Foto' style='width: 100px; border-radius: 15px; border: 2px solid black;'></td>";
echo "</tr>";
}
echo "</table>";
echo "<br>";
echo "<div style='text-align: center; margin-top: 20px;'>
<button type='submit'><b>ELIMINAR SELECCIONADOS</b></button>
</div>";
echo "</form>";
} else {
echo "<h1>No hay coches</h1>";}}
mysqli_close($conn);
?>
</body>
</html>