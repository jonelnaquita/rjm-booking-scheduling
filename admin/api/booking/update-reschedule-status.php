<?php
// Include the database connection
include '../../../models/conn.php'; // Adjust this to your actual DB connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reschedule_id'])) {
        $reschedule_id = $_POST['reschedule_id'];

        // SQL query to update the status to "Done"
        $sql = "UPDATE tblreschedule SET status = 'Done' WHERE reschedule_id = ?";
        
        // Prepare and execute the query
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $reschedule_id);

            if ($stmt->execute()) {
                // Success response
                echo json_encode(['success' => true]);
            } else {
                // Error response
                echo json_encode(['success' => false, 'message' => 'Failed to update status.']);
            }

            // Close statement
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to prepare query.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Reschedule ID is missing.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

// Close the database connection
$conn->close();
?>
