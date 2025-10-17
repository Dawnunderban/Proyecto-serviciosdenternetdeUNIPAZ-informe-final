<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../../login/conexion.php';

// Configuramos las cabeceras para que el navegador trate el contenido como un archivo Excel
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=productos.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Iniciamos la salida con HTML y estilos mínimos para mostrar una tabla ordenada
echo '<html>';
echo '<head><meta charset="UTF-8"></head>';
echo '<body>';
echo '<table border="1" cellspacing="0" cellpadding="5" style="font-family: Arial, sans-serif;">';
echo '<tr style="background-color: #D3D3D3; font-weight: bold;">';
echo '<th>Nombre</th>';
echo '<th>Precio</th>';
echo '<th>Tipo</th>';
echo '<th>Stock</th>';
echo '</tr>';

// Realizamos la consulta para obtener los productos
$query = "SELECT nombre, precio, tipo, stock FROM productos";
$resultado = $conexion->query($query);

if (!$resultado) {
    echo '<tr><td colspan="4">Error en la consulta: ' . $conexion->error . '</td></tr>';
} else {
    while ($fila = $resultado->fetch_assoc()) {
        // Formateamos el precio, por ejemplo: $ 120,000.00
        $precioFormateado = "$ " . number_format($fila['precio'], 2, '.', ',');
        echo '<tr>';
        echo '<td>' . htmlspecialchars($fila['nombre'], ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td>' . $precioFormateado . '</td>';
        echo '<td>' . htmlspecialchars($fila['tipo'], ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td>' . intval($fila['stock']) . '</td>';
        echo '</tr>';
    }
}

echo '</table>';
echo '</body>';
echo '</html>';
exit;
?>
