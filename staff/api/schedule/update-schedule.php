<?php
// Database connection
include '../../../models/conn.php';

if (isset($_POST['schedule_id'])) {
    $schedule_id = $_POST['schedule_id'];
    $bus_id = $_POST['bus_id'];
    $departure_date = $_POST['departure_date'];
    $departure_time = $_POST['departure_time'];
    $fare = $_POST['fare'];

    // Prepare the query to update schedule
    $query = "UPDATE tblschedule SET bus_id = ?, departure_date = ?, departure_time = ?, fare = ? WHERE schedule_id = ?";
    $stmt = $conn->prepare($query);
    
    // Use 'd' for double (decimal) and 'i' for integer types as appropriate
    $stmt->bind_param("ssssi", $bus_id, $departure_date, $departure_time, $fare, $schedule_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to update schedule: ' . $stmt->error]);
    }
    
    $stmt->close();
}
?>
