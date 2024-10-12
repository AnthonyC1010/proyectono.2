<?php
session_start();
if (!isset($_SESSION['cliente'])) {
    header("Location: login_cliente.php");
    exit();
}

echo "<h2>Bienvenido al panel de cliente, " . $_SESSION['cliente'] . "</h2>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cliente</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="agregar_cuenta_tercero.php">Agregar cuenta de terceros</a></li>
            <li><a href="transferir_a_cuenta_tercero.php">Transferencia a terceros</a></li>
            <li><a href="consulta_saldo_cliente.php">Consultar Saldo</a></li>
            <li><a href="consulta_transacciones.php">Consultar Transacciones</a></li>
            <li><a href="estado_cuenta.php">Estado de cuenta</a></li>
            <li><a href="logout.php">Cerrar sesión</a></li>
        </ul>
    </nav>
</body>
</html>