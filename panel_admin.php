<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Panel de Administración</h2>
    <ul>
        <li><a href="ver_cajeros.php">Ver cajeros</a></li>
        <li><a href="agregar_cajero.php">Agregar cajero</a></li>
        <li><a href="gestion_usuarios.php">Gestión de Usuarios</a></li>
        <li><a href="gestion_cuentas.php">Gestión de Cuentas Bancarias</a></li>
        <li><a href="gestion_transacciones.php">Gestión de Transacciones</a></li>
        <li><a href="ver_transacciones.php">Ver transacciones</a></li>
        <li><a href="logout.php">Cerrar sesión</a></li>
        </ul>
</body>
</html>