<?php
include '../../../models/conn.php'; // Include your database connection

// Check if all required parameters are set
if (isset($_POST['destination_from']) && isset($_POST['destination_to']) && isset($_POST['bus_type'])) {
    $destination_from = $_POST['destination_from'];
    $destination_to = $_POST['destination_to'];
    $bus_type = $_POST['bus_type'];

    // Query to get available departure dates
    $query = "SELECT DISTINCT s.departure_date 
              FROM tblschedule s
              LEFT JOIN tblbus b ON s.bus_id = b.bus_id
              WHERE s.destination_from = ? 
              AND s.destination_to = ? 
              AND b.bus_type = ?
              AND s.sched_status = ''";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("sss", $destination_from, $destination_to, $bus_type);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $dates = [];
        while ($row = $result->fetch_assoc()) {
            $dates[] = $row['departure_date'];  // Collect available dates
        }
        
        // Return dates as JSON
        echo json_encode(['success' => true, 'dates' => $dates]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Query error']);
    }
} else {
    // If any of the required parameters are missing, return an error
    $missing_params = [];
    if (!isset($_POST['destination_from'])) $missing_params[] = 'destination_from';
    if (!isset($_POST['destination_to'])) $missing_params[] = 'destination_to';
    if (!isset($_POST['bus_type'])) $missing_params[] = 'bus_type';
    
    echo json_encode([
        'success' => false, 
        'message' => 'Missing required parameters: ' . implode(', ', $missing_params)
    ]);
}
?>
