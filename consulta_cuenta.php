<?php
session_start();
if (!isset($_SESSION['cajero'])) {
    header("Location: login_cajero.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_cuenta = $_POST['no_cuenta'];

    $conexion = new mysqli('localhost', 'admin', 'admin', 'proyecto2');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "SELECT * FROM cuentas WHERE no_cuenta = '$no_cuenta'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $cuenta = $resultado->fetch_assoc();
        echo "Número de cuenta: " . $cuenta['no_cuenta'] . "<br>";
        echo "Saldo actual: " . $cuenta['saldo'] . "<br>";
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
    <title>Consultar Cuenta</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Consultar Cuenta</h2>
    <form action="consulta_cuenta.php" method="POST">
        <label for="no_cuenta">Número de Cuenta:</label>
        <input type="text" id="no_cuenta" name="no_cuenta" required>

        <button type="submit">Consultar</button>
    </form>

    <a href="panel_cajero.php">Volver al panel</a>
</body>
</html>