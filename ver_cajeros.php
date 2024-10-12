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

$sql = "SELECT * FROM usuarios WHERE rol = 'cajero'";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Cajeros</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Lista de Cajeros</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre Completo</th>
            <th>Usuario</th>
            <th>Estado</th>
        </tr>
        <?php while ($fila = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $fila['id']; ?></td>
            <td><?php echo $fila['nombre_completo']; ?></td>
            <td><?php echo $fila['usuario']; ?></td>
            <td><?php echo $fila['estado']; ?></td>
        </tr>
        <?php } ?>
    </table>

    <a href="panel_admin.php">Volver al panel</a>
</body>
</html>

<?php
$conexion->close();
?>