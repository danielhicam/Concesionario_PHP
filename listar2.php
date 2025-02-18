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
</style>
</head>
<body>
<div class="clase1">Agenda de Alquileres
<div class="clase2">
<div class="clase3">Coches<div class="clase6"><a href="index.html">Inicio</a><a href="añadir.php">Añadir</a><a href="listar.php">Listar</a><a href="buscar.php">Buscar</a><a href="modificar.php">Modificar</a><a href="borrar.php">Borrar</a></div></div>
<div class="clase3">Usuarios<div class="clase6"><a href="index.html">Inicio</a><a href="añadir2.php">Añadir</a><a href="listar2.php">Listar</a><a href="buscar2.php">Buscar</a><a href="modificar2.php">Modificar</a><a href="borrar2.php">Borrar</a></div></div>
<div class="clase3">Alquileres<div class="clase6"><a href="index.html">Inicio</a><a href="listar3.php">Listar</a><a href="borrar3.php">Borrar</a></div></div>
</div>
</div>
<div class="clase4">
<?php
$conn = mysqli_connect("localhost", "root", "rootroot", "concesionario");
if (!$conn) {
    die("<h2>Error de conexión: " . mysqli_connect_error() . "</h2>");
}

$sql = "SELECT id_usuario, nombre, apellidos, dni, saldo FROM usuarios";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h1>Listado de Usuarios</h1>";
    echo "<table>";
    echo "<tr>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>DNI</th>
        <th>Saldo</th>
    </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
        echo "<td>" . htmlspecialchars($row['apellidos']) . "</td>";
        echo "<td>" . htmlspecialchars($row['dni']) . "</td>";
        echo "<td>" . htmlspecialchars($row['saldo']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay usuarios disponibles para mostrar.</p>";
}

mysqli_close($conn);
?>
</div>
</body>
</html>
