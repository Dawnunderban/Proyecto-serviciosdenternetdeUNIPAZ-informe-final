<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener los datos desde la sesión
$usuario = $_SESSION['usuario'];
$cedula = $_SESSION['cedula'];
$telefono = $_SESSION['telefono'];
?>
