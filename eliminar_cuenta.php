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

$numero_cuenta = $_GET['numero_cuenta'];

$sql = "DELETE FROM cuentas WHERE numero_cuenta = '$numero_cuenta'";
if ($conexion->query($sql)) {
    echo "Cuenta eliminada exitosamente.";
} else {
    echo "Error al eliminar la cuenta: " . $conexion->error;
}

$conexion->close();
header("Location: gestion_cuentas.php");
?>