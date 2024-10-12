<?php
session_start();
$conexion = new mysqli('localhost', 'admin', 'admin', 'proyecto2');
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}



// Procesar la transferencia
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['transferir'])) {
    $id_cuenta_tercero = $_POST['cuenta_tercero'];
    $monto_transferencia = $_POST['monto_transferencia'];

    // Obtener detalles de la cuenta de tercero
    $sql_detalle = "SELECT * FROM cuentas_terceros WHERE id = '$id_cuenta_tercero'";
    $resultado_detalle = $conexion->query($sql_detalle);
    $cuenta_tercero = $resultado_detalle->fetch_assoc();

    // Validaciones
    if ($monto_transferencia > $cuenta_tercero['monto_maximo']) {
        echo "El monto de transferencia supera el máximo permitido.";
    } else {
        // Aquí deberías agregar la lógica para contar las transacciones del día
        // y verificar si se excede el máximo permitido
        $sql_transferencia = "INSERT INTO transferencias (usuario_id, cuenta_tercero_id, monto, fecha) 
                              VALUES ('$usuario_id', '$id_cuenta_tercero', '$monto_transferencia', NOW())";

        if ($conexion->query($sql_transferencia)) {
            echo "Transferencia realizada con éxito.";
        } else {
            echo "Error al realizar la transferencia: " . $conexion->error;
        }
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transferir a Cuenta de Tercero</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Transferir a Cuenta de Tercero</h2>
    <form action="transferir_a_cuenta_tercero.php" method="POST">
        <label for="cuenta_tercero">Selecciona Cuenta de Tercero:</label>
        <select id="cuenta_tercero" name="cuenta_tercero" required>
            <?php
            if ($resultado_cuentas->num_rows > 0) {
                while ($cuenta = $resultado_cuentas->fetch_assoc()) {
                    echo "<option value='" . $cuenta['id'] . "'>" . $cuenta['alias'] . " (" . $cuenta['no_cuenta'] . ")</option>";
                }
            } else {
                echo "<option value=''>No hay cuentas de terceros registradas.</option>";
            }
            ?>
        </select>

        <label for="monto_transferencia">Monto a Transferir:</label>
        <input type="number" id="monto_transferencia" name="monto_transferencia" required>

        <button type="submit" name="transferir">Transferir</button>
    </form>

    <a href="panel_cliente.php">Volver al panel</a>
</body>
</html>