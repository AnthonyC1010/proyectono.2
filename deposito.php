<?php
session_start();
if (!isset($_SESSION['cajero'])) {
    header("Location: login_cajero.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_cuenta = $_POST['no_cuenta'];
    $monto = $_POST['monto'];

    $conexion = new mysqli('localhost', 'admin', 'admin', 'proyecto2');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "UPDATE cuentas SET saldo = saldo + $monto WHERE no_cuenta = '$no_cuenta'";

    if ($conexion->query($sql) === TRUE) {
        echo "Depósito realizado con éxito.";
        // Registrar la transacción
        $sql_transaccion = "INSERT INTO transacciones (no_cuenta_origen, no_cuenta_destino, tipo_transaccion, monto, fecha_transaccion) 
                            VALUES (NULL, '$no_cuenta', 'depósito', $monto, NOW())";
        $conexion->query($sql_transaccion);
    } else {
        echo "Error al realizar el depósito: " . $conexion->error;
    }

    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Depósito</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Realizar Depósito</h2>
    <form action="deposito.php" method="POST">
        <label for="no_cuenta">Número de Cuenta:</label>
        <input type="text" id="no_cuenta" name="no_cuenta" required>

        <label for="monto">Monto:</label>
        <input type="number" id="monto" name="monto" required>

        <button type="submit">Realizar Depósito</button>
    </form>

    <a href="panel_cajero.php">Volver al panel</a>
</body>
</html>