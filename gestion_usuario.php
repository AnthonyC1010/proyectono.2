<?php

$conexion = new mysqli('localhost', 'admin', 'admin', 'proyecto2');
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Crear un nuevo usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear_usuario'])) {
    $usuario = $_POST['correo']; // Usar correo como nombre de usuario
    $clave = $_POST['clave'];
    $confirmacion_clave = $_POST['confirmacion_clave'];
    $rol = $_POST['rol'];
    $dpi = $_POST['dpi'];
    $no_cuenta = $_POST['no_cuenta'];

    // Validar que la contraseña y la confirmación coincidan
    if ($clave === $confirmacion_clave) {
        // Hashear la contraseña antes de guardarla
        $clave_hashed = password_hash($clave, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (usuario, clave, rol, dpi, no_cuenta) VALUES ('$usuario', '$clave_hashed', '$rol', '$dpi', '$no_cuenta')";
        if ($conexion->query($sql)) {
            echo "Usuario creado exitosamente.";
        } else {
            echo "Error al crear el usuario: " . $conexion->error;
        }
    } else {
        echo "Las contraseñas no coinciden.";
    }
}

// Mostrar todos los usuarios
$sql = "SELECT * FROM usuarios";
$resultado = $conexion->query($sql);


$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Gestión de Usuarios</h2>
    <form action="gestion_usuarios.php" method="POST">
        <label for="no_cuenta">No. Cuenta Bancaria:</label>
        <input type="text" id="no_cuenta" name="no_cuenta" required>

        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required>

        <label for="dpi">DPI:</label>
        <input type="text" id="dpi" name="dpi" required>

        <label for="clave">Contraseña:</label>
        <input type="password" id="clave" name="clave" required>

        <label for="confirmacion_clave">Confirmación de Contraseña:</label>
        <input type="password" id="confirmacion_clave" name="confirmacion_clave" required>

        <label for="rol">Rol:</label>
        <select id="rol" name="rol">
            <option value="cajero">Cajero</option>
            <option value="cliente">Cliente</option>
            <option value="admin">Administrador</option>
        </select>

        <button type="submit" name="crear_usuario">Crear Usuario</button>
    </form>

    <a href="panel_admin.php">Volver al panel</a>
</body>
</html>