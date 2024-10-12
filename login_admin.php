<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    // Conectar a la base de datos
    $conexion = new mysqli('localhost', 'admin', 'admin', 'proyecto2');

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Verificar credenciales
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave = '$clave' AND rol = 'administrador'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows == 1) {
        $_SESSION['admin'] = $usuario;
        header("Location: panel_admin.php");
    } else {
        echo "Usuario o contraseña incorrectos.";
    }

    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión - Administrador</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Inicio de sesión de administrador</h2>
    <form action="login_admin.php" method="POST">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        
        <label for="clave">Clave:</label>
        <input type="password" id="clave" name="clave" required>
        
        <button type="submit">Iniciar sesión</button>
    </form>
</body>
</html>