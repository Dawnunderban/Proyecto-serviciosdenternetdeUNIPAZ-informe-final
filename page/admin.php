<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Panel de Administración</h1>
            <a href="../login/index.php" class="logout-btn">Cerrar sesión</a>
        </div>

        <div class="menu">
            <button onclick="cambiarFrame('admin/productos.php')">Productos</button>
            <button onclick="cambiarFrame('admin/planes.php')">Planes</button>
            <button onclick="cambiarFrame('admin/usuarios.php')">Usuarios</button>
            <button onclick="cambiarFrame('admin/pagos.php')">Pagos</button>
            <button onclick="cambiarFrame('admin/estadisticas.php')">Actividad Mensual</button>
            <button onclick="cambiarFrame('admin/eliminados.php')">🗑️</button>
        </div>

        <iframe name="content" class="content-frame"></iframe>
    </div>

    <script>
        function cambiarFrame(url) {
            document.querySelector("iframe").src = url;
        }
    </script>
</body>
</html>
