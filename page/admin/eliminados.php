<?php
session_start();
include '../../login/conexion.php';

// Consulta para obtener todos los registros de la tabla eliminados
$query = "SELECT id, nombre, rol, fecha_eliminacion FROM eliminados";
$resultadoEliminados = $conexion->query($query);

// Si ocurre algún error en la consulta, lo mostramos y detenemos la ejecución
if (!$resultadoEliminados) {
    die("Error en la consulta: " . $conexion->error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registros Eliminados</title>
  <style>
    /* Estilos generales */
    body {
      font-family: Arial, sans-serif;
      background: #121212; /* Fondo negro real */
      color: #ddd; /* Texto claro */
      margin: 0;
    }
    /* Títulos sin cuadro de fondo */
    h2 {
      color: white;
      text-align: center;
      font-size: 22px;
      padding: 10px;
    }
    /* Estilos para tablas */
    .styled-table {
      width: 90%;
      border-collapse: collapse;
      margin: 20px auto;
      box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.1);
      background: #222;
    }
    .styled-table th, .styled-table td {
      border: 2px solid #444; /* Bordes más oscuros */
      padding: 10px;
      text-align: center;
      color: white;
    }
    .styled-table th {
      background: #181818;
      font-weight: bold;
    }
    .styled-table tr:nth-child(even) {
      background: #262626; /* Gris oscuro */
    }
    /* Botón de eliminación (opcional, en caso de que decidas permitir borrar el registro de eliminados) */
    .delete-btn {
      background: #b30000;
      color: white;
      padding: 8px;
      border: none;
      cursor: pointer;
      border-radius: 5px;
    }
    .delete-btn:hover {
      background: #800000;
    }
  </style>
</head>
<body>
  <h2>Registros Eliminados</h2>
  <table class="styled-table">
      <thead>
          <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Rol</th>
              <th>Fecha Eliminación</th>
          </tr>
      </thead>
      <tbody>
          <?php while ($fila = $resultadoEliminados->fetch_assoc()) { ?>
          <tr>
              <td><?= $fila['id'] ?></td>
              <td><?= htmlspecialchars($fila['nombre']) ?></td>
              <td><?= htmlspecialchars($fila['rol']) ?></td>
              <td><?= $fila['fecha_eliminacion'] ?></td>
          </tr>
          <?php } ?>
      </tbody>
  </table>
</body>
</html>
