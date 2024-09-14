<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include database connection
    require_once('../../../models/conn.php');

    $destination = $_POST['destination'] ?? '';

    if (empty($destination)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Insert the data into the database
    $stmt = $conn->prepare("INSERT INTO tblroutefrom (destination_from) VALUES (?)");
    $stmt->bind_param('s', $destination);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Destination added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add destination.']);
    }

    $stmt->close();
    $conn->close();
}

?>
