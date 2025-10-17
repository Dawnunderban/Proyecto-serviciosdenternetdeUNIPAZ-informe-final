<?php
session_start();
$data = json_decode(file_get_contents('php://input'), true);

if (is_array($data)) {
    $_SESSION['carrito'] = $data;
    echo json_encode(['status' => 'ok']);
} else {
    echo json_encode(['status' => 'error']);
}
?>
