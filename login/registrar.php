<?php
include "../login/conexion.php"; // Conectar a la base de datos

// Verificar si el formulario fue enviado correctamente
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $cedula = $_POST['cedula'];
    $telefono = $_POST['telefono'];
    $contraseña = hash('sha256', $_POST['contraseña']);

    // Validar que los campos no estén vacíos
    if (empty($usuario) || empty($cedula) || empty($telefono) || empty($contraseña)) {
        header("Location: index.php?registro=campos_vacios");
        exit();
    }

    // Verificar si el usuario o la cédula ya existen
    $consulta = "SELECT * FROM usuarios WHERE usuario = ? OR cedula = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("ss", $usuario, $cedula);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        header("Location: index.php?registro=usuario_existe"); // Error si ya está registrado
        exit();
    } else {
        // Insertar nuevo usuario
        $consulta = "INSERT INTO usuarios (usuario, cedula, telefono, contraseña) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($consulta);
        $stmt->bind_param("ssss", $usuario, $cedula, $telefono, $contraseña);
        
        if ($stmt->execute()) {
            header("Location: index.php?registro=exitoso"); // Redirigir con mensaje de éxito
            exit();
        } else {
            header("Location: index.php?registro=error_insercion");
            exit();
        }
    }
}
?>
