<?php
session_start();
include '../../../models/conn.php'; // Include your database connection

// Assuming staff ID is stored in the session
$staff_id = $_SESSION['staff'] ?? null;

if (!$staff_id) {
    echo json_encode(['error' => 'Staff ID is missing']);
    exit;
}

// Prepare the SQL query to get the bus_number based on the staff_id
$query = "
    SELECT b.bus_number
    FROM tblstaff s
    JOIN tblbus b ON s.bus_number = b.bus_id
    WHERE s.staff_id = ?";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $stmt->bind_result($bus_number);

    if ($stmt->fetch()) {
        $_SESSION['bus_number'] = $bus_number;
    } else {
        echo json_encode(['error' => 'No bus found for the given staff ID.']);
        exit;
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Error in preparing the query: ' . $conn->error]);
    exit;
}

// Check if the departure_date is passed via AJAX
$departure_date = $_GET['departure_date'] ?? null;

if (!$departure_date) {
    echo json_encode(['error' => 'Departure date is required.']);
    exit;
}

if (isset($_SESSION['bus_number'])) {
    $bus_number = $_SESSION['bus_number'];

    // Query to fetch bus schedule based on bus number and departure_date
    $sql = "
        SELECT 
            tblschedule.departure_date, 
            DATE_FORMAT(tblschedule.departure_time, '%h:%i %p') AS departure_time, 
            from_route.destination_from AS from_destination, 
            to_route.destination_from AS to_destination, 
            tblbus.bus_number
        FROM tblschedule
        JOIN tblroutefrom AS from_route ON tblschedule.destination_from = from_route.from_id
        JOIN tblroutefrom AS to_route ON tblschedule.destination_to = to_route.from_id
        JOIN tblbus ON tblschedule.bus_id = tblbus.bus_id
        WHERE tblbus.bus_number = ? AND tblschedule.departure_date = ?";

    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $bus_number, $departure_date); // Use "ss" for bus_number and departure_date
    $stmt->execute();
    $result = $stmt->get_result();

    $schedule = array();
    
    // Fetch the result and store it in an array
    while ($row = $result->fetch_assoc()) {
        $schedule[] = $row;
    }
    
    // Return the schedule as JSON
    echo json_encode($schedule);
} else {
    echo json_encode(['error' => 'Bus number not found in session.']);
}

?>
