<?php
include '../../../models/conn.php';

// SQL query to fetch passenger_id, trip_type, passenger, and price from tblbooking
$query = "SELECT passenger_id, trip_type, passengers, price FROM tblbooking WHERE status = 'Confirmed'";

$result = $conn->query($query);

// Initialize an array to store the fetched data
$data = array();

if ($result->num_rows > 0) {
    // Fetch rows as associative array
    while ($row = $result->fetch_assoc()) {
        // For each row, push into the data array
        $data[] = array(
            'passenger_code' => $row['passenger_id'],
            'trip_type' => $row['trip_type'],
            'passenger' => $row['passengers'],
            'price' => $row['price']
        );
    }
}

// Return data as JSON format
echo json_encode(['data' => $data]);

// Close connection
$conn->close();
?>
