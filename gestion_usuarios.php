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

// Crear un nuevo usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear_usuario'])) {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $rol = $_POST['rol'];

    $sql = "INSERT INTO usuarios (usuario, clave, rol) VALUES ('$usuario', '$clave', '$rol')";
    if ($conexion->query($sql)) {
        echo "Usuario creado exitosamente.";
    } else {
        echo "Error al crear el usuario: " . $conexion->error;
    }
}

// Mostrar todos los usuarios
$sql = "SELECT * FROM usuarios";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Usuario</th><th>Rol</th><th>Acción</th></tr>";
    while ($usuario = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $usuario['usuario'] . "</td>";
        echo "<td>" . $usuario['rol'] . "</td>";
        echo "<td><a href='editar_usuario.php?usuario=" . $usuario['usuario'] . "'>Editar</a> | ";
        echo "<a href='eliminar_usuario.php?usuario=" . $usuario['usuario'] . "'>Eliminar</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No hay usuarios registrados.";

    // Después de agregar o eliminar un usuario, agregamos el código similar al siguiente

// Para registro de nuevos usuarios
$accion = "El administrador ha registrado un nuevo usuario: $nombre";
$sql_auditoria = "INSERT INTO auditoria (id_admin, accion) VALUES ('{$_SESSION['admin']}', '$accion')";
$conexion->query($sql_auditoria);

// Para eliminar usuarios
$accion = "El administrador ha eliminado al usuario: $id_usuario";
$sql_auditoria = "INSERT INTO auditoria (id_admin, accion) VALUES ('{$_SESSION['admin']}', '$accion')";
$conexion->query($sql_auditoria);


}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h2>Gestión de Usuarios</h2>
    <form action="gestion_usuarios.php" method="POST">
        <label for="no_cuenta">No. Cuenta Bancaria:</label>
        <input type="text" id="no_cuenta" name="no_cuenta" required>

        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required>

        <label for="dpi">DPI:</label>
        <input type="text" id="dpi" name="dpi" required>

        <label for="clave">Contraseña:</label>
        <input type="password" id="clave" name="clave" required>

        <label for="confirmacion_clave">Confirmación de Contraseña:</label>
        <input type="password" id="confirmacion_clave" name="confirmacion_clave" required>

        <label for="rol">Rol:</label>
        <select id="rol" name="rol">
            <option value="cajero">Cajero</option>
            <option value="cliente">Cliente</option>
            <option value="admin">Administrador</option>
        </select>
        <button type="submit" name="crear_usuario">Crear Usuario</button>
    </form>

    <a href="panel_admin.php">Volver al panel</a>
</body>
</html>