<?php
// Include database connection
include '../../models/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get POST data
    $reference_number = $_POST['reference_number'];
    $contact_number = $_POST['contact_number'];

    // Check if both fields are filled
    if (empty($reference_number) || empty($contact_number)) {
        echo json_encode(["success" => false, "message" => "Both reference number and contact number are required."]);
        exit;
    }

    // Insert into tblreschedule
    $sql = "INSERT INTO tblreschedule (passenger_id, contact_number) VALUES (?, ?)";

    // Prepare and bind
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(["success" => false, "message" => "Error in preparing SQL: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("ss", $reference_number, $contact_number);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Reschedule request saved successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error saving reschedule request: " . $stmt->error]);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
