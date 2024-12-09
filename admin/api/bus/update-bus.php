<?php
require_once('../../../models/conn.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bus_id = $_POST['bus_id'];
    $bus_number = $_POST['bus_number'];
    $bus_type_id = $_POST['bus_type_id'];
    $terminal_id = $_POST['terminal_id'];
    $destination_id = $_POST['destination_id'];
    $seats = $_POST['seats'];

    $query = "UPDATE tblbus 
              SET bus_number = ?, bus_type = ?, terminal_id = ?, destination_id = ?, seats = ? 
              WHERE bus_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("siiiii", $bus_number, $bus_type_id, $terminal_id, $destination_id, $seats, $bus_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'Bus updated successfully']);
    } else {
        echo json_encode(['error' => 'Failed to update bus']);
    }

    $stmt->close();
}
?>