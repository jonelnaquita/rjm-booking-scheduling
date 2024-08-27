<?php
header('Content-Type: application/json');

// Include database connection
include '../../models/conn.php';

// Decode the incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);

// Check if data is valid
if (isset($data['pickup_id']) && isset($data['drop_off'])) {
    $pickup_id = intval($data['pickup_id']);
    $drop_off = $data['drop_off'];

    // Prepare SQL statement to insert into tblrouteto
    $stmt = $conn->prepare("INSERT INTO tblrouteto (from_id, destination_to) VALUES (?, ?)");

    foreach ($drop_off as $destination_id) {
        // Skip if the destination_id is the same as pickup_id
        if ($destination_id == $pickup_id) {
            continue;
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("ii", $pickup_id, $destination_id);
        $stmt->execute();
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Send success response
    echo json_encode(['success' => true]);
} else {
    // Send error response
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
}
?>
