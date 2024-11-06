<?php
// Set timezone to Manila, Asia
date_default_timezone_set('Asia/Manila');

// Include database connection
require '../../../models/conn.php';

// Get the current date in Manila timezone
$currentDate = date("Y-m-d"); // Use only the date, no time needed

// SQL query to update bookings with a departure date before the current date
$query = "
    UPDATE tblbooking AS b
    LEFT JOIN tblschedule AS s ON b.scheduleDeparture_id = s.schedule_id
    SET b.status = 'Cancelled'
    WHERE s.departure_date < ? AND b.status != 'Cancelled'
";

// Prepare the statement
if ($stmt = $conn->prepare($query)) {
    // Bind parameters
    $stmt->bind_param("s", $currentDate); // 's' indicates the type is string

    // Execute the statement
    if ($stmt->execute()) {
        echo "Booking statuses updated.";
    } else {
        echo "Error updating booking statuses: " . $stmt->error; // Show error to user
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing the statement: " . $conn->error; // Show error to user
}

// Close the connection
$conn->close();
?>