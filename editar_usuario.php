<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

$conexion = new mysqli('localhost', 'admin', 'admin', 'proyecto2');
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$usuario = $_GET['usuario'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clave = $_POST['clave'];
    $rol = $_POST['rol'];

    $sql = "UPDATE usuarios SET clave = '$clave', rol = '$rol' WHERE usuario = '$usuario'";
    if ($conexion->query($sql)) {
        echo "Usuario actualizado exitosamente.";
    } else {
        echo "Error al actualizar el usuario: " . $conexion->error;
    }
}

// Obtener información del usuario
$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $usuario_info = $resultado->fetch_assoc();
} else {
    echo "Usuario no encontrado.";
    exit();
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Editar Usuario</h2>
    <form action="editar_usuario.php?usuario=<?php echo $usuario; ?>" method="POST">
        <label for="clave">Nueva Clave:</label>
        <input type="password" id="clave" name="clave" value="<?php echo $usuario_info['clave']; ?>" required>

        <label for="rol">Rol:</label>
        <select id="rol" name="rol">
            <option value="cajero" <?php echo $usuario_info['rol'] == 'cajero' ? 'selected' : ''; ?>>Cajero</option>
            <option value="cliente" <?php echo $usuario_info['rol'] == 'cliente' ? 'selected' : ''; ?>>Cliente</option>
            <option value="admin" <?php echo $usuario_info['rol'] == 'admin' ? 'selected' : ''; ?>>Administrador</option>
        </select>

        <button type="submit">Actualizar Usuario</button>
    </form>

    <a href="gestion_usuarios.php">Volver a la gestión de usuarios</a>
</body>
</html>