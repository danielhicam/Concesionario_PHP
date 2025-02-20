<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agenda de Alquileres</title>
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Raleway:wght@300;400&display=swap" rel="stylesheet">
<style>
body {margin: 0; background-image: url('ee21.jpg'); font-family: 'Libre Baskerville', serif; background-color: #111; color: #eaeaea; }
.clase1 {background-color: #000; color: #d4af37; padding: 20px 0; font-size: 36px; text-align: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.7); position: sticky; top: 0; z-index: 1000; letter-spacing: 2px;}
.clase1 span {font-size: 24px; color: #d4af37;}
.clase2 {display: flex; justify-content: space-between; margin: 20px 0; padding: 0 15%;} /* Ajustado para menor separación */
.clase3 {padding: 12px 25px; text-decoration: none; color: #111; background-color: #d4af37; border-radius: 30px; font-size: 18px; font-family: 'Raleway', sans-serif; position: relative; transition: transform 0.3s ease, box-shadow 0.3s ease;}
.clase3:hover {transform: translateY(-4px); box-shadow: 0 6px 12px rgba(212, 175, 55, 0.5);}
.clase6 {display: none; position: absolute; top: 100%; left: 0; background-color: #222; border-radius: 30px; text-align: center; width: 100%; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); z-index: 1000;} /* Tamaño igual al botón */
.clase3:hover .clase6 {display: block;}
.clase6 a {display: block; padding: 10px 0; text-decoration: none; color: #d4af37; font-size: 16px; font-family: 'Raleway', sans-serif; transition: background-color 0.3s ease, color 0.3s ease;}
.clase6 a:hover {background-color: #d4af37; color: #111;}
.clase4 {height: 670px; width: 100%; background-image: url('ee21.jpg'); background-size: cover; background-position: center; filter: brightness(80%);}

.formulario {
      background-color: rgba(34, 34, 34, 0.9);
      padding: 30px;
      border-radius: 10px;
      width: 60%;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: #eaeaea;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    }
.formulario input, .formulario button {
      display: block;
      margin: 12px auto;
      padding: 12px;
      font-size: 16px;
      border-radius: 5px;
      border: none;
      width: 85%;
    }
.formulario input {
      background-color: #444;
      color: #eaeaea;
    }
.formulario button {
      background-color: #d4af37;
      color: #111;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
.formulario button:hover {
      background-color: #e0bf5c;
    }

.imagen {background-color: white; text-align: center; width: 20%; margin: 0 auto; padding: 10px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s, box-shadow 0.3s;color:gray;margin-top:10px;} 

.imagen:hover {transform: scale(1.05); box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);}

.formulario select {
  background-color: #444;
  color: #eaeaea;
  font-size: 16px;
  border-radius: 5px;
  border: none;
  width: 93%;
  margin: 12px auto;
  padding: 12px;
}
.alinear{margin-left:72px;}
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

<div class="formulario">
<form method="post" action="" enctype="multipart/form-data">
<input type="text" name="modelo" placeholder="Modelo" required>
<input type="text" name="marca" placeholder="Marca" required>
<input type="text" name="color" placeholder="Color" required>
<input type="number" name="precio" placeholder="Precio (€)" required>

<div class="alinear">
<label for="alquilado">¿Alquilado?</label><br>
<select name="alquilado" id="alquilado" required>
<option value="0">No</option>
<option value="1">Sí</option>
</select>
</div>

<input type="file" name="foto" placeholder="Subir Foto" required>
<button type="submit" name="enviar">Añadir Coche</button>
</form>
</div>

<?php
$conn = mysqli_connect("localhost", "root", "rootroot", "concesionario");
if (!$conn) 
{die("<h2>Error de conexión: " . mysqli_connect_error() . "</h2>");}

if (isset($_POST['enviar'])) 
{$id_coche = $_POST['id_coche'];
$modelo = $_POST['modelo'];
$marca = $_POST['marca'];
$color = $_POST['color'];
$precio = $_POST['precio'];
$alquilado = $_POST['alquilado'];


$foto = $_FILES['foto']['name'];
$target_dir = "img/";
$target_file = $target_dir . basename($foto);

$check = getimagesize($_FILES['foto']['tmp_name']);
if ($check === false) 
{die("El archivo seleccionado no es una imagen.");}

$sql = "INSERT INTO coches (id_coche, modelo, marca, color, precio, alquilado, foto) 
        VALUES ('$id_coche', '$modelo', '$marca', '$color', '$precio', '$alquilado', '$foto')";

if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) 
{echo "<div class='imagen'>La imagen " . htmlspecialchars(basename($foto)) . " se ha subido correctamente.</div>";}
else 
{echo "Hubo un error al subir el archivo.";}

if (mysqli_query($conn, $sql)) 
{echo "<div class='imagen'>Coche añadido correctamente</div>";}
else 
{echo "Error: " . $sql . "<br>" . mysqli_error($conn);}

mysqli_close($conn);
}
?>
</body>
</html>