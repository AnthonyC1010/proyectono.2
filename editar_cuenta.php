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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titular = $_POST['titular'];
    $saldo = $_POST['saldo'];

    $sql = "UPDATE cuentas SET titular = '$titular', saldo = '$saldo' WHERE numero_cuenta = '$numero_cuenta'";
    if ($conexion->query($sql)) {
        echo "Cuenta actualizada exitosamente.";
    } else {
        echo "Error al actualizar la cuenta: " . $conexion->error;
    }
}

// Obtener información de la cuenta
$sql = "SELECT * FROM cuentas WHERE numero_cuenta = '$numero_cuenta'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $cuenta_info = $resultado->fetch_assoc();
} else {
    echo "Cuenta no encontrada.";
    exit();
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cuenta</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Editar Cuenta</h2>
    <form action="editar_cuenta.php?numero_cuenta=<?php echo $numero_cuenta; ?>" method="POST">
        <label for="titular">Titular:</label>
        <input type="text" id="titular" name="titular" value="<?php echo $cuenta_info['titular']; ?>" required>

        <label for="saldo">Saldo:</label>
        <input type="number" id="saldo" name="saldo" value="<?php echo $cuenta_info['saldo']; ?>" required>

        <button type="submit">Actualizar Cuenta</button>
    </form>

    <a href="gestion_cuentas.php">Volver a la gestión de cuentas</a>
</body>
</html>