<?php
// Include the database connection
include '../../../models/conn.php'; // Adjust this to your actual DB connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['booking_id'])) {
        $booking_id = $_POST['booking_id'];

        // SQL query to join tblbooking and tblschedule and fetch booking details
        $sql = "
            SELECT 
                b.trip_type,
                s1.destination_from AS departure_from, 
                s1.destination_to AS departure_to, 
                s2.destination_from AS arrival_from, 
                s2.destination_to AS arrival_to,
                rf1.destination_from AS destination_departure,
                rf2.destination_from AS destination_arrival,
                bus1.bus_type AS departure_bus,
                bus2.bus_type AS arrival_bus
            FROM tblbooking b
            LEFT JOIN tblschedule s1 ON b.scheduleDeparture_id = s1.schedule_id
            LEFT JOIN tblschedule s2 ON b.scheduleArrival_id = s2.schedule_id
            LEFT JOIN tblroutefrom rf1 ON s1.destination_from = rf1.from_id
            LEFT JOIN tblroutefrom rf2 ON s1.destination_to = rf2.from_id
            LEFT JOIN tblbus bus1 ON s1.bus_id = bus1.bus_id
            LEFT JOIN tblbus bus2 ON s2.bus_id = bus2.bus_id
            WHERE b.book_id = ?
        ";

        // Prepare and execute the query
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $booking_id);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $booking = $result->fetch_assoc();
                    // Success response
                    echo json_encode(['success' => true, 'booking' => $booking]);
                } else {
                    // No booking found
                    echo json_encode(['success' => false, 'message' => 'Booking not found.']);
                }
            } else {
                // Error executing query
                echo json_encode(['success' => false, 'message' => 'Failed to execute query.']);
            }

            // Close statement
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to prepare query.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Booking ID is missing.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

// Close the database connection
$conn->close();
?>
