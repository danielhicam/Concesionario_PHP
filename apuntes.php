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


<?php
// ==========================
// INICIAR SESIÓN
// ==========================
session_start();  // Iniciar la sesión para manejar las variables de sesión

// ==========================
// CONEXIÓN SEGURA A LA BASE DE DATOS
// ==========================
$conexion = new mysqli("localhost", "root", "rootroot", "concesionario"); // Conexión a la base de datos
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error); // Si falla la conexión, mostrar el error
}

// ==========================
// REGISTRO DE USUARIO (CONTRA ENCRIPTADA)
// ==========================
if (isset($_POST['registrar'])) {
    // 1. Recoger los datos del formulario
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);    // Sanitizar nombre
    $apellidos = mysqli_real_escape_string($conexion, $_POST['apellidos']);  // Sanitizar apellidos
    $dni = mysqli_real_escape_string($conexion, $_POST['dni']);  // Sanitizar DNI
    $password = $_POST['password'];  // Contraseña en texto claro
    $tipo_usuario = mysqli_real_escape_string($conexion, $_POST['tipo_usuario']); // Tipo de usuario
    
    // 2. Hashear la contraseña antes de guardarla
    $password_hash = password_hash($password, PASSWORD_BCRYPT); // Usamos el algoritmo BCRYPT para hashear la contraseña

    // 3. Insertar el nuevo usuario en la base de datos
    $query = "INSERT INTO usuarios (nombre, apellidos, dni, password, tipo_usuario) 
              VALUES ('$nombre', '$apellidos', '$dni', '$password_hash', '$tipo_usuario')";
    
    // 4. Ejecutar la consulta y comprobar si el registro fue exitoso
    if (mysqli_query($conexion, $query)) {
        echo "Usuario registrado correctamente.";  // Mensaje de éxito
    } else {
        echo "Error al registrar: " . mysqli_error($conexion);  // Mensaje de error en caso de fallo
    }
}

// ==========================
// LOGIN DE USUARIO (VERIFICAR CONTRASEÑA HASHEADA)
// ==========================
if (isset($_POST['login'])) {
    // 1. Recoger los datos del formulario de login
    $dni = mysqli_real_escape_string($conexion, $_POST['dni']);  // Sanitizar DNI
    $password = $_POST['password'];  // Contraseña en texto claro

    // 2. Consultar la base de datos para encontrar el usuario por su DNI
    $query = "SELECT id, nombre, password, tipo_usuario FROM usuarios WHERE dni = '$dni'";
    $resultado = mysqli_query($conexion, $query);

    // 3. Si el usuario existe en la base de datos, comprobar la contraseña
    if (mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado); // Obtener los datos del usuario
        // 4. Verificar si la contraseña introducida coincide con el hash almacenado
        if (password_verify($password, $usuario['password'])) {
            // 5. Si la contraseña es correcta, iniciar la sesión
            $_SESSION['usuario'] = $usuario['nombre'];  // Guardamos el nombre del usuario en la sesión
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];  // Guardamos el tipo de usuario (comprador o vendedor)
            echo "Bienvenido, " . $_SESSION['usuario'];  // Mensaje de bienvenida
        } else {
            echo "Contraseña incorrecta.";  // Mensaje si la contraseña es incorrecta
        }
    } else {
        echo "Usuario no encontrado.";  // Mensaje si el usuario no existe
    }
}

// ==========================
// CONTADOR DE VISITAS
// ==========================
session_start(); // Iniciar sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    $_SESSION['usuario'] = "UsuarioEjemplo"; // Simulación de usuario autenticado
}

// Verificar si el contador de visitas ya existe en la sesión
if (!isset($_SESSION['contador_visitas'])) {
    $_SESSION['contador_visitas'] = 1; // Primera visita
} else {
    $_SESSION['contador_visitas']++; // Incrementar contador
}

echo "Hola, " . $_SESSION['usuario'] . ". Has visitado esta página " . $_SESSION['contador_visitas'] . " veces desde que iniciaste sesión.";

// ==========================
// CERRAR SESIÓN
// ==========================
if (isset($_GET['logout'])) {
    session_destroy();  // Destruir la sesión
    header("Location: login.php");  // Redirigir al login
    exit();
}

// ==========================
// EVITAR INYECCIÓN SQL (Consulta segura)
// ==========================
if (isset($_GET['id'])) {
    // Recoger el id de la URL y sanitizarlo para evitar inyección SQL
    $id = mysqli_real_escape_string($conexion, $_GET['id']);
    
    // Realizar la consulta directamente
    $query = "SELECT * FROM usuarios WHERE id = '$id'";
    $resultado = mysqli_query($conexion, $query);
    
    // Comprobar si hay resultados
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            // Mostrar el nombre del usuario de forma segura, previniendo XSS
            echo "Usuario: " . htmlspecialchars($fila['nombre']);
        }
    } else {
        echo "Usuario no encontrado.";
    }
}

// ==========================
// EVITAR XSS (Evitar inyecciones de código HTML o JS)
// ==========================
if (isset($_POST['mensaje'])) {
    $mensaje = htmlspecialchars($_POST['mensaje']);  // Convertir caracteres especiales en HTML
    echo "Mensaje seguro: " . $mensaje;  // Mostrar el mensaje de forma segura
}
?>

<!-- Formulario de Registro -->
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

<!-- Formulario de Login -->
<form method="POST">
    <input type="text" name="dni" placeholder="DNI" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit" name="login">Iniciar Sesión</button>
</form>

<!-- Enlace para cerrar sesión -->
<a href="?logout=1">Cerrar Sesión</a>


<?php
// ==========================
// Validación de longitud del DNI
// ==========================
if (isset($_POST['dni'])) {
    $dni = $_POST['dni'];

    // Comprobar si el DNI tiene 9 caracteres (8 dígitos + 1 letra)
    if (strlen($dni) != 9) {
        echo "El DNI debe tener 9 caracteres (8 dígitos y 1 letra).";
    } else {
        echo "DNI con la longitud correcta.";
    }
}

// ==========================
// Validación de EDAD
// ==========================
if (isset($_POST['fecha_nacimiento'])) {
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $fecha_actual = new DateTime();
    $fecha_nac = new DateTime($fecha_nacimiento);
    $edad = $fecha_actual->diff($fecha_nac)->y;
    
    if ($edad < 18) {
        echo "Debes tener al menos 18 años para registrarte.";
    } else {
        echo "Edad válida.";
    }
}


// ==========================
// Validación de campos obligatorios
// ==========================
if (empty($_POST['nombre']) || empty($_POST['apellidos']) || empty($_POST['dni']) || empty($_POST['password'])) {
    echo "Todos los campos son obligatorios.";
} else {
    echo "Formulario completo.";
}
