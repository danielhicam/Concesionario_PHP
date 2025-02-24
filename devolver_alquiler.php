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

if (isset($_POST['devolver'])) {
    if (isset($_POST['alquileres'])) {
        $conn = mysqli_connect("localhost", "root", "rootroot", "concesionario");
        if (!$conn) {
            die("<h2>Error de conexión: " . mysqli_connect_error() . "</h2>");
        }

        $alquileres = $_POST['alquileres'];

        foreach ($alquileres as $alquiler) {
            $sql = "UPDATE alquileres SET devuelto = NOW() WHERE id_alquiler = '$alquiler'";
            mysqli_query($conn, $sql);
        }
        mysqli_close($conn);
    }
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

$conn = mysqli_connect("localhost", "root", "rootroot", "concesionario");
if (!$conn) {
    die("<h2>Error de conexión: " . mysqli_connect_error() . "</h2>");
}

$id_usuario = $_SESSION['id_usuario'];

if (isset($_POST['devolver_alquiler'])) {
    if (isset($_POST['devolver'])) {
        $ids_a_devolver = $_POST['devolver'];

        foreach ($ids_a_devolver as $id_alquiler) {
            // Obtener el id_coche del alquiler antes de actualizarlo
            $sql_select = "SELECT id_coche FROM alquileres WHERE id_alquiler = '$id_alquiler' AND id_usuario = '$id_usuario'";
            $result_select = mysqli_query($conn, $sql_select);
            if ($row = mysqli_fetch_assoc($result_select)) {
                $id_coche = $row['id_coche'];

                // Actualizar la fecha de devolución
                $sql_update = "UPDATE alquileres SET devuelto = NOW() WHERE id_alquiler = '$id_alquiler' AND id_usuario = '$id_usuario'";
                if (mysqli_query($conn, $sql_update)) {
                    // Marcar el coche como disponible
                    $sql_update_coche = "UPDATE coches SET alquilado = 0 WHERE id_coche = '$id_coche'";
                    mysqli_query($conn, $sql_update_coche);
                } else {
                    echo "<p>Error al devolver el alquiler con ID $id_alquiler.</p>";
                }
            }
        }
    }
}


$sql = "SELECT a.id_alquiler, c.modelo, c.marca, c.color, a.prestado, a.devuelto 
                  FROM alquileres a
                  JOIN coches c ON a.id_coche = c.id_coche
                  WHERE a.id_usuario = '$id_usuario' AND a.devuelto IS NULL"; // Solo alquileres pendientes de devolución

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h1>Historial de Alquileres</h1>";
    echo "<form method='POST'>";
    echo "<table>";
    echo "<tr>
            <th>Seleccionar</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th>Color</th>
            <th>Fecha de Alquiler</th>
            <th>Fecha de Devolución</th>";
    echo "</tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><input type='checkbox' name='devolver[]' value='" . $row['id_alquiler'] . "'></td>";
        echo "<td>" . htmlspecialchars($row['modelo']) . "</td>";
        echo "<td>" . htmlspecialchars($row['marca']) . "</td>";
        echo "<td>" . htmlspecialchars($row['color']) . "</td>";
        echo "<td>" . htmlspecialchars($row['prestado']) . "</td>";
        echo "<td>" . ($row['devuelto'] ? htmlspecialchars($row['devuelto']) : 'Pendiente') . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "<div class='devolver-btn-container'>";
    echo "<button class='devolver-btn' type='submit' name='devolver_alquiler'>Devolver Alquiler</button>";
    echo "</div>";

    echo "</form>";
} else {
    echo "<p class='devolver-btn-container'>
            No tienes alquileres pendientes de devolución.
          </p>";
}
mysqli_close($conn);
?>

</div>
</body>
</html>
