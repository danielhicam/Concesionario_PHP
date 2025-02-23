<?php
// ==========================
// 1. INICIAR SESIÓN
// ==========================
session_start();

// ==========================
// 2. CONEXIÓN SEGURA A BASE DE DATOS
// ==========================
$conexion = mysqli_connect("localhost", "root", "rootroot", "concesionario");
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// ==========================
// 3. REGISTRO SEGURO (CONTRASEÑA ENCRIPTADA)
// ==========================
if (isset($_POST['registrar'])) {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellidos = mysqli_real_escape_string($conexion, $_POST['apellidos']);
    $dni = mysqli_real_escape_string($conexion, $_POST['dni']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $tipo_usuario = mysqli_real_escape_string($conexion, $_POST['tipo_usuario']);
    
    $query = "INSERT INTO usuarios (nombre, apellidos, dni, password, tipo_usuario) 
              VALUES ('$nombre', '$apellidos', '$dni', '$password', '$tipo_usuario')";
    if (mysqli_query($conexion, $query)) {
        echo "Usuario registrado correctamente.";
    } else {
        echo "Error al registrar: " . mysqli_error($conexion);
    }
}

// ==========================
// 4. LOGIN SEGURO CON SESIÓN
// ==========================
if (isset($_POST['login'])) {
    $dni = mysqli_real_escape_string($conexion, $_POST['dni']);
    $password = $_POST['password'];
    
    $query = "SELECT id, nombre, password, tipo_usuario FROM usuarios WHERE dni = '$dni'";
    $resultado = mysqli_query($conexion, $query);
    
    if (mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['usuario'] = $usuario['nombre'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
            echo "Bienvenido, " . $_SESSION['usuario'];
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
}

// ==========================
// 5. PROTEGER UNA PÁGINA CON SESIÓN
// ==========================
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// ==========================
// 6. CONTADOR DE VISITAS
// ==========================
if (!isset($_SESSION['visitas'])) {
    $_SESSION['visitas'] = 1;
} else {
    $_SESSION['visitas']++;
}
echo "Número de visitas: " . $_SESSION['visitas'];

// ==========================
// 7. CERRAR SESIÓN
// ==========================
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// ==========================
// 8. EVITAR INYECCIÓN SQL
// ==========================
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $query = "SELECT * FROM usuarios WHERE id = $id";
    $resultado = mysqli_query($conexion, $query);
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "Usuario: " . htmlspecialchars($fila['nombre']); // Evita XSS
    }
}

// ==========================
// 9. EVITAR XSS
// ==========================
if (isset($_POST['mensaje'])) {
    $mensaje = htmlspecialchars($_POST['mensaje']);
    echo "Mensaje seguro: " . $mensaje;
}
?>

<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="text" name="apellidos" placeholder="Apellidos" required>
    <input type="text" name="dni" placeholder="DNI" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <select name="tipo_usuario" required>
        <option value="comprador">Comprador</option>
        <option value="vendedor">Vendedor</option>
    </select>
    <button type="submit" name="registrar">Registrar</button>
</form>

<form method="POST">
    <input type="text" name="dni" placeholder="DNI" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit" name="login">Iniciar Sesión</button>
</form>

<a href="?logout=1">Cerrar Sesión</a>
