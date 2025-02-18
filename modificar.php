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
.formulario {background-color: rgba(34, 34, 34); padding: 30px; border-radius: 10px; width: 60%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #eaeaea; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);}
.formulario input, .formulario button {display: block; margin: 12px auto; padding: 12px; font-size: 16px; border-radius: 5px; border: none; width: 85%;}
.formulario input {background-color: #444; color: #eaeaea;}
.formulario button {background-color: #d4af37; color: #111; cursor: pointer; transition: background-color 0.3s ease;}
.formulario button:hover {background-color: #e0bf5c;}
table {width: 80%; margin-left:10%; border-collapse: collapse; background-color: rgba(0, 0, 0, 0.8); border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.7);}
th, td {padding: 12px; text-align: center; border: 1px solid #d4af37;}
th {background-color: #333; color: #d4af37; font-size: 18px;}
tr:hover {background-color: #666;}
h1 {text-align: center; color: #d4af37; font-size: 36px;}

.arriba{margin-bottom:280px;}


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
<div class="formulario">
<form method="post" action="">
<input type="text" name="marca" placeholder="Marca">
<input type="text" name="modelo" placeholder="Modelo">
<button type="submit" name="buscar">Buscar Coche</button>
</form>

<?php
$conn = mysqli_connect("localhost", "root", "rootroot", "concesionario");
if (!$conn) {
    die("<h2>Error de conexión: " . mysqli_connect_error() . "</h2>");
}

if (isset($_POST['buscar'])) {
    $marca = trim($_POST['marca']);
    $modelo = trim($_POST['modelo']);

    if (empty($marca) && empty($modelo)) {
        echo "<h1>No se ha introducido ningún criterio de búsqueda.</h1>";
    } else {
        $sql = "SELECT id_coche, modelo, marca, color, precio, alquilado, foto FROM coches WHERE 1=1";

        if (!empty($marca)) {
            $sql .= " AND marca = '" . mysqli_real_escape_string($conn, $marca) . "'";
        }
        if (!empty($modelo)) {
            $sql .= " AND modelo = '" . mysqli_real_escape_string($conn, $modelo) . "'";
        }

        $result = mysqli_query($conn, $sql) or die("El coche no está en nuestra Base de Datos");

        if (mysqli_num_rows($result) > 0) {
            echo "<h1>Listado de Coches</h1>";
            echo "<form method='POST' action=''>";
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
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><input type='checkbox' name='delete_ids[]' value='" . htmlspecialchars($row['id_coche']) . "'></td>";
                echo "<td>" . htmlspecialchars($row['modelo']) . "</td>";
                echo "<td>" . htmlspecialchars($row['marca']) . "</td>";
                echo "<td>" . htmlspecialchars($row['color']) . "</td>";
                echo "<td>" . htmlspecialchars($row['precio']) . "</td>";
                echo "<td>" . ($row['alquilado'] ? 'Sí' : 'No') . "</td>";
                echo "<td><img src='img/" . htmlspecialchars($row['foto']) . "' alt='Sin Foto' style='width: 100px; border-radius: 15px; border: 2px solid black;'></td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<br>";
            echo "<div style='text-align: center; margin-top: 20px;'>";
            echo "<button type='submit' name='modificar'>Modificar seleccionados</button>";
            echo "</div>";
            echo "</form>";
        } else {
            echo "<h1>No hay coches</h1>";
        }
    }
}


      if (isset($_POST['modificar'])) {
      if (!isset($_POST['delete_ids']) || empty($_POST['delete_ids'])) {
            echo "<h1 style='color: gray; text-align: center;'>No has seleccionado ningún coche para modificar.</h1>";
      } else {
            
            echo "<h1 style='text-align: center; margin-top:30px;'>Modificar Coche</h1>";
            echo "<div style='margin: 20px auto; width: 60%;'>";
            foreach ($_POST['delete_ids'] as $id) {
                  // CHEQUEAR LA CONSULTA
                  $sql = "SELECT id_coche, modelo, marca, color, precio, alquilado FROM coches WHERE id_coche = '" . mysqli_real_escape_string($conn, $id) . "'";
                  $result = mysqli_query($conn, $sql);

                  if ($row = mysqli_fetch_assoc($result)) {

                  echo "<div class='arriba'>";

                  echo "<form method='POST' class='ultimo' action='modificar.php'>";
                  echo "<input type='hidden' name='id_coche' value='" . htmlspecialchars($row['id_coche']) . "'>";
                  echo "<label>Modelo: </label><input type='text' name='modelo' value='" . htmlspecialchars($row['modelo']) . "'><br>";
                  echo "<label>Marca: </label><input type='text' name='marca' value='" . htmlspecialchars($row['marca']) . "'><br>";
                  echo "<label>Color: </label><input type='text' name='color' value='" . htmlspecialchars($row['color']) . "'><br>";
                  echo "<label>Precio: </label><input type='number' name='precio' value='" . htmlspecialchars($row['precio']) . "'><br>";
                  echo "<label>Alquilado: </label>";
                  echo "<select name='alquilado'>";
                  echo "<option value='0'" . (!$row['alquilado'] ? " selected" : "") . ">No</option>";
                  echo "<option value='1'" . ($row['alquilado'] ? " selected" : "") . ">Sí</option>";
                  echo "</select><br><br>";
                  echo "<button type='submit' style='margin-bottom:-20px;' name='guardar'>Guardar Cambios</button>";
                  echo "</form>";
                  echo "</div>";
                  }
            }
            echo "</div>";
      }
}


      if (isset($_POST['guardar'])) {
            // Capturar datos del formulario
            $id_coche = mysqli_real_escape_string($conn, $_POST['id_coche']);
            $modelo = mysqli_real_escape_string($conn, $_POST['modelo']);
            $marca = mysqli_real_escape_string($conn, $_POST['marca']);
            $color = mysqli_real_escape_string($conn, $_POST['color']);
            $precio = mysqli_real_escape_string($conn, $_POST['precio']);
            $alquilado = mysqli_real_escape_string($conn, $_POST['alquilado']);
        
            // Construir la consulta UPDATE
            $sql = "UPDATE coches 
                    SET modelo = '$modelo', 
                        marca = '$marca', 
                        color = '$color', 
                        precio = '$precio', 
                        alquilado = '$alquilado' 
                    WHERE id_coche = '$id_coche'";
        
            // Ejecutar la consulta
            if (mysqli_query($conn, $sql)) {
                echo "<h1 style='color: gray; text-align: center;'>Coche modificado con éxito</h1>";
            } else {
                echo "<h1 style='color: gray; text-align: center;'>Error al modificar el coche: " . mysqli_error($conn) . "</h1>";
            }
        }
        



mysqli_close($conn);
?>



</body>
</html>