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

// Mostrar auditoría
$sql = "SELECT auditoria.*, admins.nombre FROM auditoria JOIN admins ON auditoria.id_admin = admins.id";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Administrador</th><th>Acción</th><th>Fecha</th></tr>";
    while ($auditoria = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $auditoria['nombre'] . "</td>";
        echo "<td>" . $auditoria['accion'] . "</td>";
        echo "<td>" . $auditoria['fecha'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se han registrado actividades.";
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditoría de Actividades</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Auditoría de Actividades</h2>
    <a href="panel_admin.php">Volver al panel</a>
</body>
</html>