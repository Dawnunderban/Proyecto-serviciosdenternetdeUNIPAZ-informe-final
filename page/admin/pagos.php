<?php
session_start();
include '../../login/conexion.php';

$resultadoPagos = $conexion->query("SELECT id, usuario, tarjeta, cvv, fecha_expiracion, plan_comprado, fecha_pago FROM pagos");
?>

<h2>Gestión de Pagos</h2>
<table class="styled-table">
    <tr>
        <th>ID</th><th>Usuario</th><th>Tarjeta</th><th>CVV</th><th>Fecha Expiración</th><th>Plan Comprado</th><th>Fecha Pago</th>
    </tr>
    <?php while ($fila = $resultadoPagos->fetch_assoc()) { ?>
        <tr>
            <td><?= $fila['id'] ?></td>
            <td><?= $fila['usuario'] ?></td>
            <td><?= substr($fila['tarjeta'], -4) ?></td> 
            <td>***</td>
            <td><?= $fila['fecha_expiracion'] ?></td>
            <td><?= $fila['plan_comprado'] ?></td>
            <td><?= $fila['fecha_pago'] ?></td>
        </tr>
    <?php } ?>
</table>
<head>
    <link rel="stylesheet" href="../../assets/css/admin_division.css">
</head>
