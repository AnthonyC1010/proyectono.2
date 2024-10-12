<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre_completo'];
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    $conexion = new mysqli('localhost', 'admin', 'admin', 'proyecto2');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "INSERT INTO usuarios (nombre_completo, usuario, clave, rol, estado) 
            VALUES ('$nombre', '$usuario', '$clave', 'cajero', 'activo')";

    if ($conexion->query($sql) === TRUE) {
        echo "Cajero agregado correctamente.";
    } else {
        echo "Error al agregar cajero: " . $conexion->error;
    }

    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cajero</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Agregar un nuevo cajero</h2>
    <form action="agregar_cajero.php" method="POST">
        <label for="nombre_completo">Nombre Completo:</label>
        <input type="text" id="nombre_completo" name="nombre_completo" required>
        
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        
        <label for="clave">Clave:</label>
        <input type="password" id="clave" name="clave" required>
        
        <button type="submit">Agregar cajero</button>
    </form>

    <a href="panel_admin.php">Volver al panel</a>
</body>
</html>