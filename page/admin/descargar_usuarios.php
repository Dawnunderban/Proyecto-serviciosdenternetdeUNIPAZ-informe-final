<?php
include '../../login/conexion.php';
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=usuarios.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo '<html>';
echo '<head><meta charset="UTF-8"></head>';
echo '<body>';
echo '<table border="1" cellspacing="0" cellpadding="5" style="font-family: Arial, sans-serif;">';
echo '<tr style="background-color: #D3D3D3; font-weight: bold;">';
echo '<th>Usuario</th>';
echo '<th>Cédula</th>';
echo '<th>Teléfono</th>';
echo '<th>Rol</th>';
echo '</tr>';

$query = "SELECT usuario, cedula, telefono, rol FROM usuarios";
$resultado = $conexion->query($query);
if (!$resultado) {
    echo '<tr><td colspan="4">Error en la consulta: ' . $conexion->error . '</td></tr>';
} else {
    while ($fila = $resultado->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($fila['usuario'], ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td>' . htmlspecialchars($fila['cedula'], ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td>' . htmlspecialchars($fila['telefono'], ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td>' . htmlspecialchars($fila['rol'], ENT_QUOTES, 'UTF-8') . '</td>';
        echo '</tr>';
    }
}

echo '</table>';
echo '</body>';
echo '</html>';
exit;
?>
