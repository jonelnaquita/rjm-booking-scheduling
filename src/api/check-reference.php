<?php
// Include database connection
include '../../models/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reference_number'])) {
    $referenceNumber = $conn->real_escape_string($_POST['reference_number']);

    // Query to check if the reference number exists
    $sql = "SELECT COUNT(*) AS count FROM tblbooking WHERE passenger_id = '$referenceNumber' AND status = 'Confirmed'";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $exists = $row['count'] > 0;

        // Return JSON response
        echo json_encode(['exists' => $exists]);
    } else {
        echo json_encode(['exists' => false, 'error' => 'Query execution failed.']);
    }
} else {
    echo json_encode(['exists' => false, 'error' => 'Invalid request.']);
}

// Close the connection
$conn->close();
?>