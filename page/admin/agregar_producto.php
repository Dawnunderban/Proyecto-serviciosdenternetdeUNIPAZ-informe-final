<?php
// ACTIVAR REPORTES DE ERRORES (SÓLO EN DESARROLLO)
ini_set('display_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

session_start();
include '../../login/conexion.php';

if (isset($_POST['agregar_producto'])) {
    // Recoger y limpiar datos del formulario (sin descripción)
    $nombre = trim($_POST['nombre']);
    $precio = floatval($_POST['precio']);
    $tipo   = trim($_POST['tipo']);
    $stock  = intval($_POST['stock']);

    // Verificar que se haya seleccionado la imagen sin errores
    if (!isset($_FILES['imagen'])) {
        die("No se cargó el archivo de imagen.");
    }
    if ($_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        die("Error en la carga de la imagen. Código: " . $_FILES['imagen']['error']);
    }

    // Configurar la carpeta física para subir las imágenes.
    // Desde "C:\xampp\htdocs\gym\page\admin" queremos llegar a "C:\xampp\htdocs\gym\uploads"
    $directorioSubida = __DIR__ . '/../../uploads/';
    if (!is_dir($directorioSubida)) {
        mkdir($directorioSubida, 0755, true);
    }
    // Aseguramos que termine con una barra
    if (substr($directorioSubida, -1) !== DIRECTORY_SEPARATOR) {
        $directorioSubida .= DIRECTORY_SEPARATOR;
    }

    $nombreArchivo = basename($_FILES['imagen']['name']);
    $rutaArchivo   = $directorioSubida . $nombreArchivo;
    $extension     = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
    $extensionesPermitidas = array('jpg', 'jpeg', 'png', 'gif');

    if (!in_array($extension, $extensionesPermitidas)) {
        die("Solo se permiten archivos de imagen (jpg, jpeg, png, gif).");
    }

    // Evitar sobrescribir archivos existentes: si el archivo ya existe, usamos un nombre único
    if (file_exists($rutaArchivo)) {
         $nombreArchivo = uniqid() . "_" . $nombreArchivo;
         $rutaArchivo = $directorioSubida . $nombreArchivo;
    }

    // Mover el archivo desde la carpeta temporal a la carpeta destino
    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaArchivo)) {
        die("Error al mover el archivo.");
    }
    
    // (Opcional) Confirmar que el archivo se movió correctamente
    if (!file_exists($rutaArchivo)) {
        die("El archivo no se encontró en la ruta: " . $rutaArchivo);
    }
    
    // Construir la ruta que se guardará en la base de datos para ser accesible vía navegador.
    // Suponiendo que el sitio se accede mediante "http://localhost/gym/"
    $imagenPath = "/gym/uploads/" . $nombreArchivo;
    
    // Preparar la consulta para insertar el producto (sin la descripción)
    // Usamos el formato "sdssi":  
    // s = nombre, d = precio, s = tipo, s = imagenPath, i = stock
    $stmt = $conexion->prepare("INSERT INTO productos (nombre, precio, tipo, imagen, stock) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }
    $stmt->bind_param("sdssi", $nombre, $precio, $tipo, $imagenPath, $stock);

    if ($stmt->execute()) {
        // Redireccionar a productos.php (Admin) después de insertar correctamente
        header("Location: productos.php");
        exit();
    } else {
        echo "Error al agregar el producto: " . $stmt->error;
    }
}
?>
