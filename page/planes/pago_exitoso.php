<?php
session_start();

include '../../login/conexion.php';
if (!isset($_SESSION['usuario']) || !isset($_SESSION['cedula'])) {
    header('Location: ../login/index.php');
    exit();
}
$usuario = $_SESSION['usuario'];
$cedula = $_SESSION['cedula'];

$sql = "SELECT p.plan_comprado, pl.precio
        FROM pagos p
        JOIN planes pl ON pl.nombre = p.plan_comprado
        WHERE p.usuario = ?
        ORDER BY p.fecha_pago DESC
        LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('s', $usuario);
$stmt->execute();
$result = $stmt->get_result();
$datos = $result->fetch_assoc();
$stmt->close();

$total = isset($datos['precio']) ? (float)$datos['precio'] : 0;
$base = $total > 0 ? round($total / 1.19) : 0;
$iva = $total - $base;
$plan = isset($datos['plan_comprado']) ? $datos['plan_comprado'] : 'Desconocido';

$factura_numero = date('YmdHis');
$fecha_pago = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Exitoso</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('images/fondo_borroso.jpg');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
        }
        .factura-box {
            background: #ffffff;
            color: #000000;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 90%;
            line-height: 1.5;
            font-family: monospace;
        }
        .factura-box h1 {
            color: #00ff7f;
            font-size: 24px;
            text-align: center;
            margin-top: 0;
        }
        .factura-box p {
            margin: 10px 0;
            font-size: 16px;
        }
        .back-button {
            display: block;
            text-align: center;
            margin: 20px auto 0;
            padding: 12px 20px;
            background-color: #ffdd57;
            color: #342e8d;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 6px;
            width: fit-content;
        }
        .back-button:hover {
            background-color: #ffd700;
        }
    </style>
</head>
<body>
    <div class="factura-box">
        <h1>✅ Pago Exitoso</h1>
        <p>Cliente: <?php echo htmlspecialchars($usuario); ?> (C.C. <?php echo htmlspecialchars($cedula); ?>)</p>
        <p>NroFactura:<?php echo $factura_numero; ?></p>
        <p><?php echo $plan; ?>:<?php echo number_format($base, 0, '', ''); ?>+<?php echo number_format($iva, 0, '', ''); ?>(IVA)=<?php echo number_format($total, 0, '', ''); ?></p>
        <p>FechaPago:<?php echo str_replace([' ', ':', '-'], '', $fecha_pago); ?></p>
        <a href="../frames/home.php" class="back-button">Volver al inicio</a>
    </div>
</body>
</html>
