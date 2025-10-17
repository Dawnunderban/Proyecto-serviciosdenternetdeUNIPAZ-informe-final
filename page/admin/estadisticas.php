<?php
session_start();
include '../../login/conexion.php';

// Verificar que sea admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die('Acceso denegado');
}

// Consulta: ingresos totales por mes (últimos 6 meses)
$sql = "
    SELECT
        DATE_FORMAT(p.fecha_pago, '%Y-%m') AS mes,
        SUM(pl.precio)                AS total
    FROM pagos p
    JOIN planes pl ON pl.nombre = p.plan_comprado
    GROUP BY mes
    ORDER BY mes DESC
    LIMIT 6
";
$result = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas / Actividad Mensual</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #111;
            color: #eee;
        }
        h2 {
            margin-bottom: 15px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: #222;
        }
        th, td {
            border: 1px solid #444;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #333;
        }
        td {
            background: #1a1a1a;
        }
    </style>
</head>
<body>
    <h2>Actividad Mensual</h2>
    <table>
        <thead>
            <tr>
                <th>Mes</th>
                <th>Ingresos (COP)</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['mes']) ?></td>
                    <td><?= number_format($row['total'], 0, ',', '.') ?></td>
                </tr>
                <?php endwhile ?>
            <?php else: ?>
                <tr><td colspan="2">No hay datos disponibles.</td></tr>
            <?php endif ?>
        </tbody>
    </table>
</body>
</html>
