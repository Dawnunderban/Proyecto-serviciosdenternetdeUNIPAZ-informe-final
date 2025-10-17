<?php
session_start();
include '../../login/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
    // Procesa la actualización del usuario
    $usuario_id = intval($_POST['usuario_id']);
    $usuario    = $conexion->real_escape_string($_POST['usuario']);
    $cedula     = $conexion->real_escape_string($_POST['cedula']);
    $telefono   = $conexion->real_escape_string($_POST['telefono']);
    $rol        = $conexion->real_escape_string($_POST['rol']);

    $query = "UPDATE usuarios SET 
                usuario = '$usuario',
                cedula  = '$cedula',
                telefono = '$telefono',
                rol     = '$rol'
              WHERE id = $usuario_id";

    if ($conexion->query($query)) {
        header("Location: usuarios.php");
        exit;
    } else {
        echo "Error al actualizar el usuario: " . $conexion->error;
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usuario_id'])) {
    // Se muestra el formulario con los datos actuales del usuario
    $usuario_id = intval($_POST['usuario_id']);
    $query = "SELECT * FROM usuarios WHERE id = $usuario_id LIMIT 1";
    $resultado = $conexion->query($query);
    if ($resultado && $resultado->num_rows > 0) {
        $usuarioData = $resultado->fetch_assoc();
    } else {
        echo "Usuario no encontrado.";
        exit;
    }
} else {
    echo "Acceso inválido.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Usuario</title>
  <style>
      body {
          font-family: Arial, sans-serif;
          background: #121212;
          color: #ddd;
          margin: 0;
      }
      h2 {
          text-align: center;
          padding: 10px;
          color: white;
      }
      form {
          width: 90%;
          margin: 20px auto;
          padding: 20px;
          background: #222;
          border: 2px solid #444;
          border-radius: 8px;
      }
      form label {
          display: block;
          margin: 10px 0 5px;
      }
      form input[type="text"],
      form input[type="number"],
      form select {
          width: calc(100% - 20px);
          margin: 0 10px 15px 10px;
          padding: 10px;
          border: none;
          border-radius: 4px;
          font-size: 1rem;
          box-sizing: border-box;
      }
      form button {
          display: block;
          width: 100%;
          padding: 12px;
          background: #ffc107;
          border: none;
          border-radius: 4px;
          color: #000;
          font-size: 1.1rem;
          cursor: pointer;
          margin-bottom: 10px;
      }
      form button:hover {
          background: #e0a800;
      }
      .volver-btn {
          display: block;
          width: 100%;
          padding: 12px;
          background: #007bff;
          border: none;
          border-radius: 4px;
          color: white;
          font-size: 1.1rem;
          text-align: center;
          text-decoration: none;
          cursor: pointer;
      }
      .volver-btn:hover {
          background: #0056b3;
      }
  </style>
</head>
<body>
  <h2>Editar Usuario</h2>
  <form action="editar_usuario.php" method="POST">
     <!-- Campo oculto para identificar el usuario -->
     <input type="hidden" name="usuario_id" value="<?= $usuarioData['id'] ?>">
     
     <label>Usuario:</label>
     <input type="text" name="usuario" value="<?= htmlspecialchars($usuarioData['usuario'], ENT_QUOTES, 'UTF-8') ?>" required>
     
     <label>Cédula:</label>
     <input type="text" name="cedula" value="<?= htmlspecialchars($usuarioData['cedula'], ENT_QUOTES, 'UTF-8') ?>" required>
     
     <label>Teléfono:</label>
     <input type="text" name="telefono" value="<?= htmlspecialchars($usuarioData['telefono'], ENT_QUOTES, 'UTF-8') ?>" required>
     
     <label>Rol:</label>
     <select name="rol" required>
         <option value="admin" <?= ($usuarioData['rol'] === 'admin') ? 'selected' : '' ?>>Admin</option>
         <option value="usuario" <?= ($usuarioData['rol'] === 'usuario') ? 'selected' : '' ?>>Usuario</option>
         <!-- Puedes agregar otras opciones de rol según necesites -->
     </select>
     
     <button type="submit" name="enviar">Actualizar Usuario</button>
  </form>
  <a href="usuarios.php" class="volver-btn">Volver</a>
</body>
</html>
