<?php
session_start();
include "../login/conexion.php"; // Asegúrate de que la ruta es correcta

// Recibir datos del formulario
$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

// Verificar que los campos no estén vacíos
if (empty($usuario) || empty($contraseña)) {
    header("Location: index.php?error=campos_vacios");
    exit();
}

// Preparar consulta segura, incluyendo el campo "rol"
$sql = "SELECT usuario, cedula, telefono, rol FROM usuarios WHERE usuario = ? AND contraseña = SHA2(?, 256)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $usuario, $contraseña);
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar si el usuario existe
if ($fila = $resultado->fetch_assoc()) {
    // Regenerar sesión para seguridad
    session_regenerate_id(true);

    // Guardar datos en la sesión
    $_SESSION['usuario'] = $fila['usuario'];
    $_SESSION['cedula'] = $fila['cedula'];
    $_SESSION['telefono'] = $fila['telefono'];
    $_SESSION['rol'] = $fila['rol'];

    // Consultar el plan del usuario
    $sql_plan = "SELECT plan_comprado FROM pagos WHERE usuario = ?";
    $stmt_plan = $conexion->prepare($sql_plan);
    $stmt_plan->bind_param("s", $usuario);
    $stmt_plan->execute();
    $resultado_plan = $stmt_plan->get_result();

    if ($resultado_plan->num_rows > 0) {
        $fila_plan = $resultado_plan->fetch_assoc();
        $_SESSION['plan'] = $fila_plan['plan_comprado'];
    } else {
        $_SESSION['plan'] = "Sin plan";
    }
    $stmt_plan->close();

    // Redirigir al usuario según su rol
    if ($fila['rol'] === 'admin') {
        header("Location: http://localhost/gym/page/admin.php");
        exit();
    } else {
        header("Location: http://localhost/gym/page/index.html");
        exit();
    }
} else {
    header("Location: index.php?error=datos_invalidos");
    exit();
}

// Cerrar conexiones
$stmt->close();
$conexion->close();
?>