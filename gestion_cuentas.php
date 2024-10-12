<?php

$conexion = new mysqli('localhost', 'admin', 'admin', 'proyecto2');
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Crear una nueva cuenta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear_cuenta'])) {
    $numero_cuenta = $_POST['numero_cuenta'];
    $titular = $_POST['titular'];
    $saldo = $_POST['saldo'];

    $sql = "INSERT INTO cuentas (numero_cuenta, titular, saldo) VALUES ('$numero_cuenta', '$titular', '$saldo')";
    if ($conexion->query($sql)) {
        echo "Cuenta creada exitosamente.";
    } else {
        echo "Error al crear la cuenta: " . $conexion->error;
    }
}


$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Cuentas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Gestión de Cuentas</h2>
    <form action="gestion_cuentas.php" method="POST">
        <label for="numero_cuenta">Número de Cuenta:</label>
        <input type="text" id="numero_cuenta" name="numero_cuenta" required>

        <label for="titular">Titular:</label>
        <input type="text" id="titular" name="titular" required>

        <label for="saldo">Saldo Inicial:</label>
        <input type="number" id="saldo" name="saldo" required>

        <button type="submit" name="crear_cuenta">Crear Cuenta</button>
    </form>

    <a href="panel_admin.php">Volver al panel</a>
</body>
</html>

