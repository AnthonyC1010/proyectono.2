<?php
session_start();
if (!isset($_SESSION['cliente'])) {
    header("Location: login_cliente.php");
    exit();
}

$usuario = $_SESSION['cliente'];

$conexion = new mysqli('localhost', 'admin', 'admin', 'proyecto2');
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT saldo FROM cuentas WHERE usuario = '$usuario'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $cuenta = $resultado->fetch_assoc();
    echo "Saldo actual: " . $cuenta['saldo'] . "<br>";
} else {
    echo "Cuenta no encontrada.";
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Saldo</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <a href="panel_cliente.php">Volver al panel</a>
</body>
</html>