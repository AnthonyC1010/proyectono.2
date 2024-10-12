<?php
session_start();
if (!isset($_SESSION['cajero'])) {
    header("Location: login_cajero.php");
    exit();
}

echo "<h2>Bienvenido al panel de cajero, " . $_SESSION['cajero'] . "</h2>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cajero</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="gestion_cuentas.php">Gestión de Cuentas Bancarias</a></li>
            <li><a href="deposito.php">Realizar Depósito</a></li>
            <li><a href="retiro.php">Realizar Retiro</a></li>
            <li><a href="consulta_cuenta.php">Consultar Cuenta</a></li>
            <li><a href="logout.php">Cerrar sesión</a></li>
        </ul>
    </nav>
</body>
</html>