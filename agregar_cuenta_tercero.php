<?php
session_start();
$conexion = new mysqli('localhost', 'admin', 'admin', 'proyecto2');
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Crear una nueva cuenta de tercero
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_cuenta'])) {
    $usuario_id = $_SESSION['user_id']; // Asumiendo que el ID de usuario se guarda en la sesión
    $no_cuenta = $_POST['no_cuenta'];
    $monto_maximo = $_POST['monto_maximo'];
    $max_transacciones_dia = $_POST['max_transacciones_dia'];
    $alias = $_POST['alias'];

    // Validar que la cuenta bancaria exista (puedes agregar tu lógica de validación aquí)
    $sql_validacion = "SELECT * FROM cuentas WHERE no_cuenta = '$no_cuenta'";
    $resultado_validacion = $conexion->query($sql_validacion);
    
    if ($resultado_validacion->num_rows > 0) {
        // Insertar cuenta de tercero
        $sql = "INSERT INTO cuentas_terceros (usuario_id, no_cuenta, monto_maximo, max_transacciones_dia, alias) 
                VALUES ('$usuario_id', '$no_cuenta', '$monto_maximo', '$max_transacciones_dia', '$alias')";
        if ($conexion->query($sql)) {
            echo "Cuenta de tercero agregada exitosamente.";
        } else {
            echo "Error al agregar la cuenta: " . $conexion->error;
        }
    } else {
        echo "La cuenta bancaria no existe.";
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cuenta de Tercero</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Agregar Cuenta de Tercero</h2>
    <form action="agregar_cuenta_tercero.php" method="POST">
        <label for="no_cuenta">No. Cuenta:</label>
        <input type="text" id="no_cuenta" name="no_cuenta" required>

        <label for="monto_maximo">Monto Máximo:</label>
        <input type="number" id="monto_maximo" name="monto_maximo" required>

        <label for="max_transacciones_dia">Cantidad Máxima de Transacciones Diarias:</label>
        <input type="number" id="max_transacciones_dia" name="max_transacciones_dia" required>

        <label for="alias">Alias:</label>
        <input type="text" id="alias" name="alias" required>

        <button type="submit" name="agregar_cuenta">Agregar Cuenta</button>
    </form>

    <a href="panel_cliente.php">Volver al panel</a>
</body>
</html>