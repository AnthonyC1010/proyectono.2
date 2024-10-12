<?php
session_start();
include('conexion.php'); // Asegúrate de tener una conexión a la base de datos

$cuenta_usuario = $_SESSION['cuenta']; // Asumimos que la cuenta del usuario está guardada en la sesión

$query = "SELECT * FROM transacciones 
          WHERE cuenta_origen = '$cuenta_usuario' 
          OR cuenta_destino = '$cuenta_usuario'
          ORDER BY fecha_transaccion DESC";
$result = mysqli_query($conexion, $query);
?>

<h2>Estado de Cuenta</h2>
<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Cuenta Origen</th>
            <th>Cuenta Destino</th>
            <th>Tipo</th>
            <th>Monto</th>
            <th>Descripción</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['fecha_transaccion']; ?></td>
            <td><?php echo $row['cuenta_origen']; ?></td>
            <td><?php echo $row['cuenta_destino']; ?></td>
            <td><?php echo $row['tipo_transaccion']; ?></td>
            <td><?php echo $row['monto']; ?></td>
            <td><?php echo $row['descripcion']; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>