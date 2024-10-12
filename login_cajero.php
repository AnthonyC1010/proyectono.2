<?php
session_start();
if (isset($_SESSION['cajero'])) {
    header("Location: panel_cajero.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    $conexion = new mysqli('localhost', 'admin', 'admin', 'proyecto2');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave = '$clave' AND rol = 'cajero'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $_SESSION['cajero'] = $usuario;
        header("Location: panel_cajero.php");
    } else {
        echo "Credenciales incorrectas o no tiene acceso como cajero.";
    }

    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Cajero</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Iniciar Sesión - Cajero</h2>
    <form action="login_cajero.php" method="POST">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>

        <label for="clave">Clave:</label>
        <input type="password" id="clave" name="clave" required>

        <button type="submit">Iniciar Sesión</button>
    </form>

    <a href="index.php">Volver a la página principal</a>
</body>
</html>