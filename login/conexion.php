<?php
$conexion = new mysqli("localhost", "root", "", "login_registro_gym");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
