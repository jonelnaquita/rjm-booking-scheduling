<?php
// Database connection
include '../../models/conn.php';

header('Content-Type: application/json');

// Fetch bus types from tblbustype
$query = "SELECT bustype_id, bus_type FROM tblbustype";
$result = $conn->query($query);

$bus_types = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bus_types[] = $row;
    }
}

echo json_encode($bus_types);
?>