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

// Registrar una nueva transacción
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registrar_transaccion'])) {
    $numero_cuenta = $_POST['numero_cuenta'];
    $tipo = $_POST['tipo'];
    $monto = $_POST['monto'];

    // Obtener saldo actual
    $sql_saldo = "SELECT saldo FROM cuentas WHERE numero_cuenta = '$numero_cuenta'";
    $resultado_saldo = $conexion->query($sql_saldo);
    $cuenta = $resultado_saldo->fetch_assoc();
    $saldo_actual = $cuenta['saldo'];

    if ($tipo == 'deposito') {
        $nuevo_saldo = $saldo_actual + $monto;
    } else if ($tipo == 'retiro') {
        if ($saldo_actual >= $monto) {
            $nuevo_saldo = $saldo_actual - $monto;
        } else {
            echo "Saldo insuficiente para realizar el retiro.";
            exit();
        }
    }

    // Actualizar saldo en la cuenta
    $sql_update_saldo = "UPDATE cuentas SET saldo = '$nuevo_saldo' WHERE numero_cuenta = '$numero_cuenta'";
    $conexion->query($sql_update_saldo);

    // Registrar la transacción
    $sql_transaccion = "INSERT INTO transacciones (numero_cuenta, tipo, monto, fecha) VALUES ('$numero_cuenta', '$tipo', '$monto', NOW())";
    if ($conexion->query($sql_transaccion)) {
        echo "Transacción registrada exitosamente.";
    } else {
        echo "Error al registrar la transacción: " . $conexion->error;
    }
}

// Mostrar todas las transacciones
$sql = "SELECT * FROM transacciones";
$resultado = $conexion->query($sql);

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Transacciones</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Gestión de Transacciones</h2>
    <form action="gestion_transacciones.php" method="POST">
        <label for="numero_cuenta">Número de Cuenta:</label>
        <input type="text" id="numero_cuenta" name="numero_cuenta" required>

        <label for="tipo">Tipo de Transacción:</label>
        <select id="tipo" name="tipo" required>
            <option value="deposito">Depósito</option>
            <option value="retiro">Retiro</option>
        </select>

        <label for="monto">Monto:</label>
        <input type="number" id="monto" name="monto" required>

        <button type="submit" name="registrar_transaccion">Registrar Transacción</button>
    </form>

    <a href="panel_admin.php">Volver al panel</a>
</body>
</html>