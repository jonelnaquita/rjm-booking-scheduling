<?php
session_start();
include '../../../models/conn.php'; // Adjust the path to your database connection file

if (!isset($_SESSION['staff'])) {
    echo json_encode(['error' => 'User not logged in.']);
    exit;
}

$staff_id = $_SESSION['staff'];

// Fetch the bus number based on the staff ID
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

// Now fetch the available departure dates for the bus
$query = "
    SELECT departure_date 
    FROM tblschedule s
    JOIN tblbus b ON s.bus_id = b.bus_id
    WHERE b.bus_number = ? AND departure_date >= CURDATE()";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("s", $bus_number);
    $stmt->execute();
    $stmt->bind_result($departure_date);

    $available_dates = [];
    while ($stmt->fetch()) {
        $available_dates[] = $departure_date; // Store available dates in an array
    }

    $stmt->close();
    echo json_encode($available_dates); // Return available dates as a JSON response
} else {
    echo json_encode(['error' => 'Error in preparing the query: ' . $conn->error]);
    exit;
}

$conn->close(); // Close the database connection
?>