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
<link rel="stylesheet" href="modificar.css">
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
        $sql = "SELECT id_coche, modelo, marca, color, precio, alquilado, foto FROM coches WHERE id_usuario = '$id_usuario'";


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
                  if (isset($_SESSION['nombre']) && $_SESSION['tipo_usuario'] === "admin") {  
                  echo "<label>Alquilado: </label>";
                  echo "<select name='alquilado'>";
                  echo "<option value='0'" . (!$row['alquilado'] ? " selected" : "") . ">No</option>";
                  echo "<option value='1'" . ($row['alquilado'] ? " selected" : "") . ">Sí</option>";
                  echo "</select><br><br>";
                  }
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