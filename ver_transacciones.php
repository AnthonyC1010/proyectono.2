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

$sql = "SELECT * FROM transacciones";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Transacciones</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Resumen de Transacciones</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Cuenta Origen</th>
            <th>Cuenta Destino</th>
            <th>Tipo de Transacción</th>
            <th>Monto</th>
            <th>Fecha</th>
        </tr>
        <?php while ($fila = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $fila['id']; ?></td>
            <td><?php echo $fila['no_cuenta_origen']; ?></td>
            <td><?php echo $fila['no_cuenta_destino']; ?></td>
            <td><?php echo $fila['tipo_transaccion']; ?></td>
            <td><?php echo $fila['monto']; ?></td>
            <td><?php echo $fila['fecha_transaccion']; ?></td>
        </tr>
        <?php } ?>
    </table>

    <a href="panel_admin.php">Volver al panel</a>
</body>
</html>

<?php
$conexion->close();
?>