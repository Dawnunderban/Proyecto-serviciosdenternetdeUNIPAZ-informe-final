<?php
session_start();
include '../../login/conexion.php';

$resultadoPlanes = $conexion->query("SELECT id, nombre, descripcion, precio FROM planes");
?>

<h2>Gestión de Planes</h2>
<table class="styled-table">
    <tr>
        <th>ID</th><th>Nombre</th><th>Descripción</th><th>Precio</th>
    </tr>
    <?php while ($fila = $resultadoPlanes->fetch_assoc()) { ?>
        <tr>
            <td><?= $fila['id'] ?></td>
            <td><?= $fila['nombre'] ?></td>
            <td><?= $fila['descripcion'] ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="plan_id" value="<?= $fila['id'] ?>">
                    <input type="number" name="nuevo_precio" value="<?= $fila['precio'] ?>" required>
                    <button type="submit" name="editar_precio_plan">Actualizar</button>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>
<head>
    <link rel="stylesheet" href="../../assets/css/admin_division.css">
</head>
