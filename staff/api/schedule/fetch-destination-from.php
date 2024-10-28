<?php
// Include your database connection file
include '../../../models/conn.php';

// Check if terminal_id is provided
if (isset($_GET['terminal_id'])) {
    $terminal_id = intval($_GET['terminal_id']);  // Sanitize input

    // Fetch destinations from tblroutefrom where terminal_id matches
    $query = "SELECT from_id, destination_from FROM tblroutefrom WHERE from_id = ?";
    
    // Prepare and execute the statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $terminal_id);  // Bind the terminal_id as an integer
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    $destinations = [];
    while ($row = $result->fetch_assoc()) {
        $destinations[] = $row;
    }
    
    // Return the destinations as JSON
    echo json_encode($destinations);
} else {
    echo json_encode([]);  // Return empty array if terminal_id is not provided
}
?>
