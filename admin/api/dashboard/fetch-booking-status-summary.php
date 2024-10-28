<?php
include '../../../models/conn.php'; // Ensure this path is correct

// SQL query to count bookings by status
$query = "
    SELECT 
        status, 
        COUNT(*) AS count 
    FROM 
        tblbooking
    GROUP BY 
        status
";

$result = $conn->query($query);

$bookingCounts = [
    'confirmed' => 0,
    'pending' => 0,
    'cancelled' => 0,
];

// Populate the booking counts based on the result
while ($row = $result->fetch_assoc()) {
    $status = strtolower($row['status']); // Make sure to handle case sensitivity
    if (isset($bookingCounts[$status])) {
        $bookingCounts[$status] = (int)$row['count'];
    }
}

// Close connection and return data
$conn->close();
echo json_encode($bookingCounts);
?>
