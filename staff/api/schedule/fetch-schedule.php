<?php
// Database connection
include '../../../models/conn.php';

if (isset($_POST['schedule_id'])) {
    $schedule_id = $_POST['schedule_id'];

    // Prepare the query to fetch schedule details
    $query = "SELECT * FROM tblschedule WHERE schedule_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $schedule_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $schedule = $result->fetch_assoc();

        // Return schedule data in JSON format
        echo json_encode([
            'schedule_id' => $schedule['schedule_id'],
            'bus_id' => $schedule['bus_id'],
            'from_id' => $schedule['destination_from'],
            'to_id' => $schedule['destination_to'],
            'departure_date' => $schedule['departure_date'],
            'departure_time' => $schedule['departure_time'],
            'fare' => $schedule['fare']
        ]);
    } else {
        echo json_encode(['error' => 'No schedule found']);
    }
    
    $stmt->close();
}
?>
