<?php
session_start();
include '../../login/conexion.php';

// Procesar eliminación de usuario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["eliminar_usuario"])) {
    $usuario_id = intval($_POST["usuario_id"]);
    
    // Obtener información del usuario (campo "usuario")
    $resultadoUsuario = $conexion->query("SELECT usuario FROM usuarios WHERE id = $usuario_id");
    if ($resultadoUsuario && $usuario = $resultadoUsuario->fetch_assoc()) {
        $nombre = $conexion->real_escape_string($usuario["usuario"]);
        $rol = 'usuario';
        // Insertar en la tabla eliminados
        $conexion->query("INSERT INTO eliminados (nombre, rol) VALUES ('$nombre', '$rol')");
        // Eliminar el usuario
        $conexion->query("DELETE FROM usuarios WHERE id = $usuario_id");
    }
    header("Location: eliminados.php");
    exit;
}

$resultadoUsuarios = $conexion->query("SELECT id, usuario, cedula, telefono, rol FROM usuarios");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios (Admin)</title>
    <link rel="stylesheet" href="../../assets/css/admin_division.css">
    <style>
      /* Estilos para los botones */
      .delete-btn {
          background: #b30000;
          color: white;
          padding: 8px;
          border: none;
          cursor: pointer;
          border-radius: 5px;
          margin-top: 5px;
      }
      .delete-btn:hover {
          background: #800000;
      }
      .edit-btn {
          background: #ffc107;
          color: black;
          padding: 8px;
          border: none;
          cursor: pointer;
          border-radius: 5px;
          margin-top: 5px;
          margin-right: 5px;
      }
      .edit-btn:hover {
          background: #e0a800;
      }
      .download-btn {
          display: block;
          width: 200px;
          margin: 20px auto;
          padding: 10px;
          background: #007bff;
          color: white;
          text-align: center;
          border-radius: 5px;
          font-size: 1rem;
          text-decoration: none;
      }
      .download-btn:hover {
          background: #0056b3;
      }
      /* En caso de que algunos estilos no estén definidos en admin_division.css */
      .styled-table {
          width: 90%;
          margin: 20px auto;
          border-collapse: collapse;
          background: #222;
          box-shadow: 0 0 10px rgba(255,255,255,0.1);
      }
      .styled-table th,
      .styled-table td {
          border: 2px solid #444;
          padding: 10px;
          text-align: center;
          color: white;
      }
      .styled-table th {
          background: #181818;
          font-weight: bold;
      }
      .styled-table tr:nth-child(even) {
          background: #262626;
      }
    </style>
</head>
<body>
<h2>Gestión de Usuarios</h2>

<!-- Botón para descargar los datos en Excel -->
<p style="text-align:center;">
  <a href="descargar_usuarios.php" class="download-btn">Descargar Excel</a>
</p>

<table class="styled-table">
  <tr>
    <th>ID</th>
    <th>Usuario</th>
    <th>Cédula</th>
    <th>Teléfono</th>
    <th>Rol</th>
    <th>Acción</th>
  </tr>
  <?php while ($fila = $resultadoUsuarios->fetch_assoc()) { ?>
    <tr>
      <td><?= $fila['id'] ?></td>
      <td><?= htmlspecialchars($fila['usuario'], ENT_QUOTES, 'UTF-8') ?></td>
      <td><?= htmlspecialchars($fila['cedula'], ENT_QUOTES, 'UTF-8') ?></td>
      <td><?= htmlspecialchars($fila['telefono'], ENT_QUOTES, 'UTF-8') ?></td>
      <td><?= htmlspecialchars($fila['rol'], ENT_QUOTES, 'UTF-8') ?></td>
      <td>
        <!-- Botón para editar el usuario -->
        <form method="POST" action="editar_usuario.php" style="display:inline-block;">
          <input type="hidden" name="usuario_id" value="<?= $fila['id'] ?>">
          <button type="submit" name="editar_usuario" class="edit-btn">Editar</button>
        </form>
        <!-- Botón para eliminar el usuario -->
        <form method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');" style="display:inline-block;">
          <input type="hidden" name="usuario_id" value="<?= $fila['id'] ?>">
          <button type="submit" name="eliminar_usuario" class="delete-btn">Eliminar</button>
        </form>
      </td>
    </tr>
  <?php } ?>
</table>
</body>
</html>
