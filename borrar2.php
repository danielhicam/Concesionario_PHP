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
<style>
body {margin: 0; font-family: 'Libre Baskerville', serif; background-color: #111; color: #eaeaea;}
.clase1 {background-color: #000; color: #d4af37; padding: 20px 0; font-size: 36px; text-align: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.7); position: sticky; top: 0; z-index: 1000; letter-spacing: 2px;}
.clase1 span {font-size: 24px; color: #d4af37;}
.clase2 {display: flex; justify-content: space-evenly; margin: 20px 0; padding: 0 15%;}
.clase3 {border: none;padding: 12px 25px; text-decoration: none; color: #111; background-color: #d4af37; border-radius: 30px; font-size: 18px; font-family: 'Raleway', sans-serif; position: relative; transition: transform 0.3s ease, box-shadow 0.3s ease;}
.clase3:hover {transform: translateY(-4px); box-shadow: 0 6px 12px rgba(212, 175, 55, 0.5);}
.clase6 {display: none; position: absolute; top: 100%; left: 0; background-color: #222; border-radius: 30px; text-align: center; width: 100%; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); z-index: 1000;}
.clase3:hover .clase6 {display: block;}
.clase6 a {display: block; padding: 10px 0; text-decoration: none; color: #d4af37; font-size: 16px; font-family: 'Raleway', sans-serif; transition: background-color 0.3s ease, color 0.3s ease;}
.clase6 a:hover {background-color: #d4af37; color: #111;}
.clase4 {height: 670px; width: 100%; background-image: url('ee21.jpg'); background-size: cover; background-position: center; filter: brightness(80%);}
.claseR {position: absolute; top: 50%; padding: 1%; right: 4%; transform: translateY(-50%); display: flex; flex-direction: column; background-color: #201f00; box-shadow: 0 1px 25px rgba(144, 137, 0, 0.5); border-radius: 10px; gap: 20px; align-items: center;}
.claseR .clase3 {padding: 12px 25px; text-decoration: none; color: #fff; background-color: #595121; border-radius: 30px; font-size: 18px; font-family: 'Raleway', sans-serif; position: relative; transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease, color 0.3s ease;}
.claseR .clase3:hover {transform: translateY(-4px); box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); color: #fff; background-color: #616161;}
.claseR .clase3 a {color: #fff; text-decoration: none;}
table {width: 80%; margin-left:10%; border-collapse: collapse; background-color: rgba(0, 0, 0, 0.8); border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.7);}
th, td {padding: 12px; text-align: center; border: 1px solid #d4af37;}
th {background-color: #333; color: #d4af37; font-size: 18px;}
tr:hover {background-color: #666;}
h1 {text-align: center; color: #d4af37; font-size: 36px; margin-bottom: 20px;}
.clasess {text-align: center; color: #d4af37; font-size: 36px; margin-bottom: 20px;}
button{width: 150px;margin-left: 20px;padding: 12px 20px;border: none;border-radius: 8px; background-color: #d4af37;color: #111;font-size: 14px;font-family: 'Raleway', sans-serif;cursor: pointer;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.7);transition: background-color 0.3s ease, box-shadow 0.3s ease;}
button:hover {background-color: #333;color: #d4af37;box-shadow: 0 6px 12px rgba(212, 175, 55, 0.5);}
.volver {background-color: white; text-align: center; width: 20%; margin: 0 auto; padding: 10px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s, box-shadow 0.3s;color:gray;margin-top:10px;} 
.volver:hover {transform: scale(1.05); box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);}
</style>
</head>
<body>
<div class="clase1">Gestión de Usuarios
<div class="clase2">


<div class="clase3">Coches<div class="clase6"> 
<?php if (isset($_SESSION['nombre']) && $_SESSION['tipo_usuario'] === "comprador") 
{ ?> <a href="index.php">Inicio</a><a href="listar.php">Listar</a> <a href="buscar.php">Buscar</a> <a href="alquilarcoche.php">Alquilar Coche</a> <?php } 
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
{ ?> <a href="index.php">Inicio</a><a href="listar.php">Listar</a> <a href="buscar.php">Buscar</a> <?php } 
elseif (isset($_SESSION['nombre']) && $_SESSION['tipo_usuario'] === "admin") 
{ ?><a href="index.php">Inicio</a><a href="añadir.php">Añadir</a><a href="listar.php">Listar</a><a href="buscar.php">Buscar</a><a href="modificar.php">Modificar</a><a href="borrar.php">Borrar</a> <?php } 
elseif (isset($_SESSION['nombre']) && $_SESSION['tipo_usuario'] === "vendedor") 
{ ?> <a href="index.php">Inicio</a><a href="listar.php">Listar</a> <a href="modificar.php">Poner Alquiler</a> <?php } 
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
