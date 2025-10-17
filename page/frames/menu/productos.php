<?php
session_start();
// Desde "page\frames\menu" sube tres niveles para llegar a "gym"
include '../../../login/conexion.php';

// Consulta para obtener los productos (sin descripción)
$resultadoProductos = $conexion->query("SELECT id, nombre, precio, tipo, imagen, stock FROM productos");

// Consulta para obtener los tipos únicos (para el filtro)
$resultadoTipos = $conexion->query("SELECT DISTINCT tipo FROM productos");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Productos</title>
  <style>
    body {
      background: rgb(124, 124, 124);
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 20px;
      color: #333;
    }
    .filtros-container {
      margin-bottom: 20px;
      padding: 15px;
      background: #ffffff;
      border: 1px solid #ddd;
      border-radius: 8px;
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      align-items: center;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      position: relative;
    }
    .filtros-container > div {
      display: flex;
      flex-direction: column;
    }
    .filtros-container label {
      font-size: 16px;
      font-weight: bold;
      margin-bottom: 5px;
    }
    .filtros-container select,
    .filtros-container input {
      padding: 8px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    /* Contenedor del ícono del carrito dentro del filtro */
    .carrito-filtro {
      margin-left: auto;
      display: flex;
      align-items: center;
      cursor: pointer;
      position: relative;
    }
    .carrito-filtro img {
      width: 40px;
      height: 40px;
    }
    .cart-count {
      position: absolute;
      top: -5px;
      right: -5px;
      background: red;
      color: white;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      font-size: 12px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .productos-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: flex-start;
    }
    .producto {
      background: #ffffff;
      padding: 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      width: 192px;
      text-align: center;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s;
    }
    .producto:hover {
      transform: translateY(-5px);
    }
    .producto img {
      width: 150px; /* Tamaño uniforme */
      height: 150px;
      object-fit: cover;
      border-radius: 4px;
      margin-bottom: 10px;
      box-shadow: 0 2px 4px #000000;
    }
    .producto h2 {
      font-size: 18px;
      margin: 10px 0 5px;
      color: #007BFF;
    }
    .producto .precio {
      font-size: 17px;
      font-weight: bold;
      color: #28a745;
      margin-bottom: 5px;
    }
    .producto .tipo,
    .producto .stock {
      font-size: 15px;
      color: #555;
      margin-bottom: 5px;
    }
    /* Estilos para botones */
    .acciones {
      margin-top: 10px;
      display: flex;
      justify-content: space-around;
    }
    .btn {
      padding: 8px 12px;
      font-size: 14px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .agregar-carrito {
      background-color: #007BFF;
      color: #fff;
    }
    .comprar {
      background-color: #28a745;
      color: #fff;
    }
    /* Modal para mostrar el carrito */
    .modal {
      display: none;
      position: fixed;
      z-index: 100;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.4);
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      width: 80%;
      max-width: 500px;
      position: relative;
    }
    .close-modal {
      position: absolute;
      top: 10px;
      right: 10px;
      cursor: pointer;
      font-size: 18px;
      background: none;
      border: none;
    }
    .cart-item {
      border-bottom: 1px solid #ccc;
      padding: 10px 0;
    }
    .cart-item:last-child {
      border: none;
    }
  </style>
  <script>
    // Carrito almacenado en el cliente (para demo; en producción podrías manejarlo vía sesión o Ajax)
    let carrito = [];

    // Actualiza el contador que muestra la cantidad de productos en el carrito
    function actualizarContador() {
      const contador = document.getElementById('cartCount');
      contador.innerText = carrito.length;
    }

    // Agrega un producto al carrito
    function agregarCarrito(id, nombre, precio) {
      carrito.push({ id, nombre, precio });
      actualizarContador();
      alert('Producto "' + nombre + '" agregado al carrito');
    }

    // Muestra el modal con el listado de productos en el carrito
    function mostrarCarrito() {
      const modal = document.getElementById('cartModal');
      const lista = document.getElementById('cartItems');
      // Limpia el contenido previo
      lista.innerHTML = '';
      if (carrito.length === 0) {
        lista.innerHTML = '<p>No hay productos en el carrito.</p>';
      } else {
        carrito.forEach((item) => {
          const div = document.createElement('div');
          div.className = 'cart-item';
          div.innerHTML = `<strong>${item.nombre}</strong> - $${parseFloat(item.precio).toFixed(2)}`;
          lista.appendChild(div);
        });
      }
      modal.style.display = 'flex';
    }

    function cerrarModal() {
      document.getElementById('cartModal').style.display = 'none';
    }

    // Función para enviar el carrito al servidor y redirigir a carrito.php
    function comprar() {
      // Envío de carrito al servidor mediante fetch (Ajax)
      fetch('productos/guardar_carrito.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(carrito)
      })
      .then(response => response.json())
      .then(data => {
        if(data.status === 'ok') {
          window.location.href = "productos/carrito.php";
        } else {
          alert("Error al procesar la compra. Intente nuevamente.");
        }
      })
      .catch(error => {
        console.error("Error:", error);
        alert("Error de comunicación con el servidor.");
      });
    }

    // Filtro de productos
    function filtrarProductos() {
      const tipoSeleccionado = document.getElementById('tipoFiltro').value.toLowerCase();
      const precioMin = parseFloat(document.getElementById('precioMin').value) || 0;
      const precioMax = parseFloat(document.getElementById('precioMax').value) || Number.MAX_VALUE;
      const productos = document.getElementsByClassName('producto');
      
      for (let i = 0; i < productos.length; i++) {
        const producto = productos[i];
        const tipo = producto.getElementsByClassName('tipo')[0].innerText.toLowerCase();
        const precioTexto = producto.getElementsByClassName('precio')[0].innerText;
        const precioLimpio = precioTexto.replace('$', '').replace(/,/g, '');
        const precio = parseFloat(precioLimpio);
      
        if ((tipoSeleccionado === "" || tipo.indexOf(tipoSeleccionado) !== -1) &&
            (precio >= precioMin && precio <= precioMax)) {
          producto.style.display = "block";
        } else {
          producto.style.display = "none";
        }
      }
    }

    window.addEventListener('DOMContentLoaded', function() {
      document.getElementById('tipoFiltro').addEventListener('change', filtrarProductos);
      document.getElementById('precioMin').addEventListener('input', filtrarProductos);
      document.getElementById('precioMax').addEventListener('input', filtrarProductos);
      
      // Cierra el modal si se hace click fuera de su contenido
      window.onclick = function(event) {
        const modal = document.getElementById('cartModal');
        if (event.target === modal) {
          cerrarModal();
        }
      }
    });
  </script>
</head>
<body>
  <!-- Filtros superiores con el ícono del carrito dentro -->
  <div class="filtros-container">
    <div>
      <label for="tipoFiltro">Tipo:</label>
      <select id="tipoFiltro">
        <option value="">Todos</option>
        <?php while ($filaTipo = $resultadoTipos->fetch_assoc()) { ?>
          <option value="<?= htmlspecialchars($filaTipo['tipo']); ?>">
            <?= htmlspecialchars($filaTipo['tipo']); ?>
          </option>
        <?php } ?>
      </select>
    </div>
    <div>
      <label for="precioMin">Precio Mín:</label>
      <input type="number" id="precioMin" step="0.01" placeholder="0">
    </div>
    <div>
      <label for="precioMax">Precio Máx:</label>
      <input type="number" id="precioMax" step="0.01" placeholder="Sin límite">
    </div>
    <!-- Ícono del carrito dentro del cuadro de filtros -->
    <div class="carrito-filtro" onclick="mostrarCarrito()">
      <img id="cartIcon" src="../../../assets/images/icons/carrito.jpg" alt="Carrito de Compras">
      <span id="cartCount" class="cart-count">0</span>
    </div>
  </div>
  
  <!-- Contenedor principal de productos -->
  <div class="productos-container">
    <?php while ($fila = $resultadoProductos->fetch_assoc()) { ?>
      <div class="producto">
        <img src="<?= htmlspecialchars($fila['imagen']); ?>" alt="<?= htmlspecialchars($fila['nombre']); ?>">
        <h2><?= htmlspecialchars($fila['nombre']); ?></h2>
        <p class="precio">$<?= number_format($fila['precio'], 2); ?></p>
        <p class="tipo"><?= htmlspecialchars($fila['tipo']); ?></p>
        <p class="stock">Stock: <?= $fila['stock']; ?></p>
        <!-- Botones de acción -->
        <div class="acciones">
          <button class="btn agregar-carrito" onclick="agregarCarrito(<?= $fila['id'] ?>, '<?= htmlspecialchars($fila['nombre'], ENT_QUOTES) ?>', <?= $fila['precio'] ?>)">Agregar al Carrito</button>
          <button class="btn comprar" onclick="comprar()">Comprar</button>
        </div>
      </div>
    <?php } ?>
  </div>
  
  <!-- Modal para mostrar el carrito -->
  <div id="cartModal" class="modal">
    <div class="modal-content">
      <button class="close-modal" onclick="cerrarModal()">X</button>
      <h2>Productos en el carrito</h2>
      <div id="cartItems"></div>
    </div>
  </div>
</body>
</html>
