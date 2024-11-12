<?php
include_once '../../../models/conn.php'; // Include your database connection

header('Content-Type: application/json');

// Prepare SQL query with JOIN for drivers to include bus_number
$query = "
    SELECT s.*, 
           r.destination_from, 
           b.bus_number,
           bt.bus_type,
           s.rest_day
    FROM tblstaff s
    LEFT JOIN tblroutefrom r ON s.terminal = r.from_id
    LEFT JOIN tblbus b ON s.bus_number = b.bus_id
    LEFT JOIN tblbustype bt ON b.bus_type = bt.bustype_id
";

// Execute the query
$result = $conn->query($query);

$staff = array();

while ($row = $result->fetch_assoc()) {
    // Add the fetched data to the staff array
    $staff[] = $row;
}

// Output the data in JSON format
echo json_encode($staff);

$conn->close();
?>
