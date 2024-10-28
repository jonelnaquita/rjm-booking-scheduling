<?php
require '../../models/conn.php'; // Include your database connection

if(isset($_POST['destination_from']) && isset($_POST['destination_to'])){
    $destination_from = $_POST['destination_from'];
    $destination_to = $_POST['destination_to'];

    // Query to get available departure dates
    $query = "SELECT departure_date FROM tblschedule 
              WHERE destination_from = ? AND destination_to = ? AND sched_status = ''";
    
    if($stmt = $conn->prepare($query)){
        $stmt->bind_param("ss", $destination_from, $destination_to);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $dates = [];
        while($row = $result->fetch_assoc()){
            $dates[] = $row['departure_date'];
        }
        
        // Return dates as JSON
        echo json_encode(['success' => true, 'dates' => $dates]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Query error']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
}
?>
