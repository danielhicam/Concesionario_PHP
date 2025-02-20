<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Buscar Coches</title>
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Raleway:wght@300;400&display=swap" rel="stylesheet">
<style>
body {margin: 0; background-image: url('ee21.jpg'); font-family: 'Libre Baskerville', serif; background-color: #111; color: #eaeaea; }
.clase1 {background-color: #000; color: #d4af37; padding: 20px 0; font-size: 36px; text-align: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.7); position: sticky; top: 0; z-index: 1000; letter-spacing: 2px;}
.clase1 span {font-size: 24px; color: #d4af37;}
.clase2 {display: flex; justify-content: space-between; margin: 20px 0; padding: 0 15%;}
.clase3 {padding: 12px 25px; text-decoration: none; color: #111; background-color: #d4af37; border-radius: 30px; font-size: 18px; font-family: 'Raleway', sans-serif; position: relative; transition: transform 0.3s ease, box-shadow 0.3s ease;}
.clase3:hover {transform: translateY(-4px); box-shadow: 0 6px 12px rgba(212, 175, 55, 0.5);}
.clase6 {display: none; position: absolute; top: 100%; left: 0; background-color: #222; border-radius: 30px; text-align: center; width: 100%; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); z-index: 1000;}
.clase3:hover .clase6 {display: block;}
.clase6 a {display: block; padding: 10px 0; text-decoration: none; color: #d4af37; font-size: 16px; font-family: 'Raleway', sans-serif; transition: background-color 0.3s ease, color 0.3s ease;}
.clase6 a:hover {background-color: #d4af37; color: #111;}
.clase4 {height: 670px; width: 100%; background-image: url('ee21.jpg'); background-size: cover; background-position: center; filter: brightness(80%);}

table {width: 80%; margin-left:10%; border-collapse: collapse; background-color: rgba(0, 0, 0, 0.8); border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.7);}
th, td {padding: 12px; text-align: center; border: 1px solid #d4af37;}
th {background-color: #333; color: #d4af37; font-size: 18px;}
tr:hover {background-color: #666;}
h1 {text-align: center; color: #d4af37; font-size: 36px; margin-bottom: 20px;}
.clasess {text-align: center; color: #d4af37; font-size: 36px; margin-bottom: 20px;}
button{width: 200px;margin-left: 20px;padding: 12px 20px;border: none;border-radius: 8px; background-color: #d4af37;color: #111;font-size: 14px;font-family: 'Raleway', sans-serif;font-weight: bold;text-transform: uppercase;cursor: pointer;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.7);transition: background-color 0.3s ease, box-shadow 0.3s ease;}
button:hover {background-color: #333;color: #d4af37;box-shadow: 0 6px 12px rgba(212, 175, 55, 0.5);}
.volver {background-color: white; text-align: center; width: 20%; margin: 0 auto; padding: 10px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s, box-shadow 0.3s;color:gray;margin-top:10px;} 
.volver:hover {transform: scale(1.05); box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);}
</style>
</head>
<body>
<div class="clase1">Agenda de Alquileres
<div class="clase2">
<div class="clase3">Coches<div class="clase6"><a href="index.php">Inicio</a><a href="añadir.php">Añadir</a><a href="listar.php">Listar</a><a href="buscar.php">Buscar</a><a href="modificar.php">Modificar</a><a href="borrar.php">Borrar</a></div></div>
<div class="clase3">Usuarios<div class="clase6"><a href="index.php">Inicio</a><a href="añadir2.php">Añadir</a><a href="listar2.php">Listar</a><a href="buscar2.php">Buscar</a><a href="modificar2.php">Modificar</a><a href="borrar2.php">Borrar</a></div></div>
<div class="clase3">Alquileres<div class="clase6"><a href="index.php">Inicio</a><a href="listar3.php">Listar</a><a href="borrar3.php">Borrar</a></div></div>
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
else {$sql = "SELECT id_coche, modelo, marca, color, precio, alquilado, foto FROM coches";
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
<button type='submit'>Eliminar seleccionados</button>
</div>";
echo "</form>";
} else {
echo "<h1>No hay coches</h1>";}}
mysqli_close($conn);
?>
</body>
</html>