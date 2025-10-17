<?php
session_start();
include '../../login/conexion.php';

// Recuperamos el filtro (si se envía) vía GET
$filtro_tipo = "";
if (isset($_GET['tipo'])) {
    $filtro_tipo = $conexion->real_escape_string(trim($_GET['tipo']));
    if ($filtro_tipo !== "") {
        $queryProductos = "SELECT id, nombre, precio, tipo, imagen, stock FROM productos WHERE tipo = '$filtro_tipo'";
    } else {
        $queryProductos = "SELECT id, nombre, precio, tipo, imagen, stock FROM productos";
    }
} else {
    $queryProductos = "SELECT id, nombre, precio, tipo, imagen, stock FROM productos";
}

$resultadoProductos = $conexion->query($queryProductos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #121212;
            color: #ddd;
            margin: 0;
        }
        h2 {
            color: white;
            text-align: center;
            font-size: 22px;
            padding: 10px;
        }
        /* Formulario para agregar producto */
        form.agregar-form {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            background: #222;
            border: 2px solid #444;
            border-radius: 8px;
        }
        form.agregar-form input[type="text"],
        form.agregar-form input[type="number"] {
            width: calc(100% - 20px);
            margin: 0 10px 15px 10px;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        .custom-file-upload {
            display: inline-block;
            padding: 8px 15px;
            cursor: pointer;
            background: #181818;
            color: #fff;
            border: 2px solid #444;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        form.agregar-form input[type="file"] {
            display: none;
        }
        #nombreArchivo {
            display: inline-block;
            margin-left: 10px;
            font-style: italic;
        }
        form.agregar-form button {
            display: block;
            width: 100%;
            padding: 12px;
            background: #28a745;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 1.1rem;
            cursor: pointer;
        }
        form.agregar-form button:hover {
            background: #218838;
        }
        /* Filtro desplegable por tipo, ubicado debajo del formulario agregar producto */
        .filtro-select {
            width: 90%;
            margin: 20px auto;
            padding: 10px;
            background: #333;
            border: 2px solid #444;
            border-radius: 8px;
            text-align: center;
        }
        .filtro-select label {
            color: #fff;
            margin-right: 10px;
            font-size: 1.1rem;
        }
        .filtro-select select {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #555;
            font-size: 1rem;
            margin-right: 10px;
        }
        .filtro-select button {
            padding: 8px 15px;
            background: #007bff;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            font-size: 1rem;
        }
        .filtro-select button:hover {
            background: #0056b3;
        }
        /* Tabla de productos */
        .styled-table {
            width: 90%;
            border-collapse: collapse;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
            background: #222;
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
        /* Formularios de acción para editar y eliminar */
        .styled-table td form.delete-form,
        .styled-table td form.edit-form {
            display: inline;
            margin: 0;
            padding: 0;
            border: none;
            background: none;
        }
        .delete-btn {
            background: #b30000;
            color: white;
            padding: 4px 2px;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            display: inline-block;
        }
        .delete-btn:hover {
            background: #800000;
        }
        .edit-btn {
            background: #ffc107;
            color: #000;
            padding: 4px 2px;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            display: inline-block;
            margin-right: 5px;
        }
        .edit-btn:hover {
            background: #e0a800;
        }
        .download-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            text-align: center;
            width: 200px;
            border-radius: 5px;
            font-size: 1.1rem;
        }
        .download-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Gestión de Productos</h2>

    <!-- Formulario para agregar producto -->
    <form class="agregar-form" method="POST" action="agregar_producto.php" enctype="multipart/form-data">
        <input type="text" name="nombre" placeholder="Nombre del producto" required>
        <input type="number" step="0.01" name="precio" placeholder="Precio" required>
        <input type="text" name="tipo" placeholder="Tipo" required>
        <input type="number" name="stock" placeholder="Stock" required>
        <label class="custom-file-upload">
            <input type="file" name="imagen" accept="image/*" required>
            Subir Imagen
        </label>
        <span id="nombreArchivo"></span>
        <button type="submit" name="agregar_producto">Agregar Producto</button>
    </form>

    <!-- Filtro desplegable por 'Tipo' -->
    <form class="filtro-select" action="productos.php" method="GET">
        <label for="tipo">Tipo:</label>
        <select name="tipo" id="tipo">
            <option value="" <?= ($filtro_tipo === "") ? "selected" : "" ?>>Todos</option>
            <option value="Creatina" <?= ($filtro_tipo === "Creatina") ? "selected" : "" ?>>Creatina</option>
            <option value="Proteina" <?= ($filtro_tipo === "Proteina") ? "selected" : "" ?>>Proteína</option>
            <option value="Preentreno" <?= ($filtro_tipo === "Preentreno") ? "selected" : "" ?>>Preentreno</option>
            <option value="Esteroides" <?= ($filtro_tipo === "Esteroides") ? "selected" : "" ?>>Esteroides</option>
        </select>
        <button type="submit">Filtrar</button>
    </form>

    <!-- Tabla que muestra los productos -->
    <table class="styled-table">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Tipo</th>
            <th>Imagen</th>
            <th>Stock</th>
            <th>Acción</th>
        </tr>
        <?php while ($fila = $resultadoProductos->fetch_assoc()) { ?>
        <tr>
            <td><?= $fila['id'] ?></td>
            <td><?= $fila['nombre'] ?></td>
            <td>$ <?= number_format($fila['precio'], 2) ?></td>
            <td><?= $fila['tipo'] ?></td>
            <td>
                <img src="<?= $fila['imagen'] ?>" alt="<?= $fila['nombre'] ?>" width="50">
            </td>
            <td><?= $fila['stock'] ?></td>
            <td>
                <!-- Botón para editar el producto -->
                <form method="POST" action="editar_producto.php" class="edit-form" style="display:inline-block;">
                    <input type="hidden" name="producto_id" value="<?= $fila['id'] ?>">
                    <button type="submit" name="editar_producto" class="edit-btn">Editar</button>
                </form>
                <!-- Botón para eliminar el producto -->
                <form method="POST" class="delete-form" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');" style="display:inline-block;">
                    <input type="hidden" name="producto_id" value="<?= $fila['id'] ?>">
                    <button type="submit" name="eliminar_producto" class="delete-btn">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <!-- Botón para descargar el archivo Excel de los productos -->
    <p style="text-align:center;">
        <a href="descargar_excel.php" class="download-btn">Descargar Excel</a>
    </p>

    <script>
        // Mostrar el nombre del archivo seleccionado
        const inputFile = document.querySelector('input[type="file"]');
        const nombreArchivoSpan = document.getElementById('nombreArchivo');
        inputFile.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                nombreArchivoSpan.textContent = this.files[0].name;
            } else {
                nombreArchivoSpan.textContent = "";
            }
        });
    </script>
</body>
</html>
