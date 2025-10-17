<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $card_number = substr($_POST['card_number'], -4); // Guarda solo los últimos 4 dígitos
    $cvv = $_POST['cvv'];
    $exp_date = $_POST['exp_date'];
    $plan = $_POST['plan'];
    $usuario = $_SESSION['usuario'];

    // Conectar a la base de datos
    $conexion = new mysqli("localhost", "root", "", "login_registro_gym");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Guardar el pago en la base de datos
    $sql = "INSERT INTO pagos (usuario, tarjeta, cvv, fecha_expiracion, plan_comprado) 
            VALUES ('$usuario', '$card_number', '$cvv', '$exp_date', '$plan')";

    if ($conexion->query($sql) === TRUE) {
        $_SESSION['plan'] = $plan; // Guardamos el plan en la sesión
        echo "✅ Pago guardado correctamente en la base de datos.";
        header("Location: pago_exitoso.php"); // Redirigir a la página de éxito
        exit();
    } else {
        echo "❌ Error al guardar el pago: " . $conexion->error; // Mostrar error si falla
    }

    $conexion->close();
}
?>
