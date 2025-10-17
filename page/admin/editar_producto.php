<?php
session_start();
include '../../login/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['enviar'])) {
    // Procesar el formulario de actualización del producto
    $producto_id = intval($_POST['producto_id']);
    $nombre      = $conexion->real_escape_string($_POST['nombre']);
    $precio      = floatval($_POST['precio']);
    $tipo        = $conexion->real_escape_string($_POST['tipo']);
    $stock       = intval($_POST['stock']);

    // Manejar la imagen:
    // Si se sube un nuevo archivo sin error, se procesa; de lo contrario se usa la imagen actual.
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $filename     = basename($_FILES['imagen']['name']);
        $newFileName  = time() . "_" . $filename;
        $targetDir    = "uploads/"; // Asegúrate de que esta carpeta exista y tenga permisos de escritura
        $targetFile   = $targetDir . $newFileName;
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $targetFile)) {
            $imagen = $targetFile;
        } else {
            // Si falla el movimiento, usamos la imagen actual
            $imagen = $conexion->real_escape_string($_POST['imagen_actual']);
        }
    } else {
        $imagen = $conexion->real_escape_string($_POST['imagen_actual']);
    }

    // Actualizar el registro en la base de datos
    $query = "UPDATE productos SET 
                nombre = '$nombre', 
                precio = $precio, 
                tipo = '$tipo', 
                imagen = '$imagen', 
                stock = $stock 
              WHERE id = $producto_id";

    if ($conexion->query($query)) {
        // Redirige a la página principal de productos una vez actualizado
        header("Location: productos.php");
        exit;
    } else {
        echo "Error actualizando el producto: " . $conexion->error;
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['producto_id'])) {
    // Se llega aquí inicialmente para cargar el formulario de edición
    $producto_id = intval($_POST['producto_id']);
    $query = "SELECT * FROM productos WHERE id = $producto_id LIMIT 1";
    $resultado = $conexion->query($query);
    if ($resultado && $resultado->num_rows > 0) {
        $producto = $resultado->fetch_assoc();
    } else {
        echo "Producto no encontrado.";
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
    <title>Editar Producto</title>
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
            margin: 10px;
        }
        form input[type="text"],
        form input[type="number"],
        form input[type="file"] {
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
            margin-bottom: 10px;
            background: #ffc107;
            border: none;
            border-radius: 4px;
            color: #000;
            font-size: 1.1rem;
            cursor: pointer;
        }
        form button:hover {
            background: #e0a800;
        }
        .imagen-actual {
            margin: 10px;
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
    <h2>Editar Producto</h2>
    <form action="editar_producto.php" method="POST" enctype="multipart/form-data">
        <!-- Campo oculto para identificar el producto -->
        <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
        <!-- Campo oculto para conservar la imagen actual -->
        <input type="hidden" name="imagen_actual" value="<?= $producto['imagen'] ?>">
        
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?>" required>
        
        <label>Precio:</label>
        <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" required>
        
        <label>Tipo:</label>
        <input type="text" name="tipo" value="<?= htmlspecialchars($producto['tipo'], ENT_QUOTES, 'UTF-8') ?>" required>
        
        <label>Stock:</label>
        <input type="number" name="stock" value="<?= $producto['stock'] ?>" required>
        
        <label>Imagen:</label>
        <?php if (!empty($producto['imagen'])): ?>
            <div class="imagen-actual">
                <img src="<?= $producto['imagen'] ?>" alt="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?>" width="100">
            </div>
        <?php endif; ?>
        <input type="file" name="imagen">
        
        <button type="submit" name="enviar">Actualizar Producto</button>
    </form>
    <!-- Botón para volver a la página de productos -->
    <a href="productos.php" class="volver-btn">Volver</a>
</body>
</html>
