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

$numero_cuenta = $_GET['numero_cuenta'];

// Mostrar transacciones de una cuenta específica
$sql = "SELECT * FROM transacciones WHERE numero_cuenta = '$numero_cuenta'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    echo "<h2>Transacciones de la cuenta $numero_cuenta</h2>";
    echo "<table>";
    echo "<tr><th>Tipo</th><th>Monto</th><th>Fecha</th></tr>";
    while ($transaccion = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $transaccion['tipo'] . "</td>";
        echo "<td>" . $transaccion['monto'] . "</td>";
        echo "<td>" . $transaccion['fecha'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se han realizado transacciones en esta cuenta.";
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Transacciones</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <a href="gestion_cuentas.php">Volver a la gestión de cuentas</a>
</body>
</html>