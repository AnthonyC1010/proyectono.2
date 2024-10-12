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

$sql = "SELECT * FROM transacciones WHERE no_cuenta_origen = 
        (SELECT no_cuenta FROM cuentas WHERE usuario = '$usuario') OR no_cuenta_destino = 
        (SELECT no_cuenta FROM cuentas WHERE usuario = '$usuario') ORDER BY fecha_transaccion DESC";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    while ($transaccion = $resultado->fetch_assoc()) {
        echo "Tipo de Transacción: " . $transaccion['tipo_transaccion'] . "<br>";
        echo "Monto: " . $transaccion['monto'] . "<br>";
        echo "Fecha: " . $transaccion['fecha_transaccion'] . "<br>";
        echo "------------------------------------------<br>";
    }
} else {
    echo "No se encontraron transacciones.";
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Transacciones</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <a href="panel_cliente.php">Volver al panel</a>
</body>
</html>