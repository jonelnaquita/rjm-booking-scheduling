<?php
require_once('../../../models/conn.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bus_id = $_POST['bus_id'];
    $bus_number = $_POST['bus_number'];
    $bus_type_id = $_POST['bus_type_id'];
    $seats = $_POST['seats'];

    $query = "UPDATE tblbus SET bus_number = ?, bus_type = ?, seats = ? WHERE bus_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("siii", $bus_number, $bus_type_id, $seats, $bus_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'Bus updated successfully']);
    } else {
        echo json_encode(['error' => 'Failed to update bus']);
    }

    $stmt->close();
}
?>
