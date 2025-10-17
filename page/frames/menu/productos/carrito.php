<?php
session_start();
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Carrito de Compras</title>
  <style>
    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      padding: 20px;
      background: #f2f2f2;
    }
    h2 {
      color: #333;
    }
    .producto-carrito {
      background: #fff;
      padding: 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <h2>Productos en tu carrito</h2>
  <?php if(empty($carrito)): ?>
    <p>No hay productos en el carrito.</p>
  <?php else: ?>
    <?php foreach($carrito as $producto): ?>
      <div class="producto-carrito">
        <p><strong><?= htmlspecialchars($producto['nombre']); ?></strong></p>
        <p>Precio: $<?= number_format($producto['precio'], 2); ?></p>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</body>
</html>
