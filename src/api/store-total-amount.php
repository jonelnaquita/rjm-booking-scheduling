<?php
session_start();

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['totalAmount'])) {
    $_SESSION['totalAmount'] = $data['totalAmount'];
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>