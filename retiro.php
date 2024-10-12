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

    // Comprobar si hay saldo suficiente
    $sql_saldo = "SELECT saldo FROM cuentas WHERE no_cuenta = '$no_cuenta'";
    $resultado = $conexion->query($sql_saldo);
    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        if ($fila['saldo'] >= $monto) {
            // Realizar el retiro
            $sql = "UPDATE cuentas SET saldo = saldo - $monto WHERE no_cuenta = '$no_cuenta'";
            if ($conexion->query($sql) === TRUE) {
                echo "Retiro realizado con éxito.";
                // Registrar la transacción
                $sql_transaccion = "INSERT INTO transacciones (no_cuenta_origen, no_cuenta_destino, tipo_transaccion, monto, fecha_transaccion) 
                                    VALUES ('$no_cuenta', NULL, 'retiro', $monto, NOW())";
                $conexion->query($sql_transaccion);
            } else {
                echo "Error al realizar el retiro: " . $conexion->error;
            }
        } else {
            echo "Saldo insuficiente.";
        }
    } else {
        echo "Cuenta no encontrada.";
    }

    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Retiro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Realizar Retiro</h2>
    <form action="retiro.php" method="POST">
        <label for="no_cuenta">Número de Cuenta:</label>
        <input type="text" id="no_cuenta" name="no_cuenta" required>

        <label for="monto">Monto:</label>
        <input type="number" id="monto" name="monto" required>

        <button type="submit">Realizar Retiro</button>
    </form>

    <a href="panel_cajero.php">Volver al panel</a>
</body>
</html>