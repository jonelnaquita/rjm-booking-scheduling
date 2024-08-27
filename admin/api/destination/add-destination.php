<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include database connection
    require_once('../../../models/conn.php');

    $destination = $_POST['destination'] ?? '';
    $province = $_POST['province'] ?? '';

    if (empty($destination) || empty($province)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Insert the data into the database
    $stmt = $conn->prepare("INSERT INTO tblroutefrom (destination_from, province) VALUES (?, ?)");
    $stmt->bind_param('ss', $destination, $province);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Destination added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add destination.']);
    }

    $stmt->close();
    $conn->close();
}

?>
