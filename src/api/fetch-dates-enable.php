<?php
require '../../models/conn.php'; // Include your database connection

if (isset($_POST['destination_from'], $_POST['destination_to'], $_POST['bus_type'])) {
    $destination_from = $_POST['destination_from'];
    $destination_to = $_POST['destination_to'];
    $bus_type = $_POST['bus_type'];

    // Query to fetch available departure dates based on selected bus type
    $query = "
        SELECT DISTINCT tblschedule.departure_date
        FROM tblschedule
        LEFT JOIN tblbus ON tblschedule.bus_id = tblbus.bus_id
        LEFT JOIN tblbustype ON tblbus.bus_type = tblbustype.bustype_id
        WHERE tblschedule.destination_from = ? 
          AND tblschedule.destination_to = ? 
          AND tblbustype.bustype_id = ?
          AND tblschedule.sched_status = ''";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("sss", $destination_from, $destination_to, $bus_type);
        $stmt->execute();
        $result = $stmt->get_result();

        $dates = [];
        while ($row = $result->fetch_assoc()) {
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