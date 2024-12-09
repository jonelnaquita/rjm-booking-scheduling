<?php
include '../../../models/conn.php';

$query = "SELECT bus_id, bus_number FROM tblbus"; // Query to fetch all bus numbers
$result = mysqli_query($conn, $query);

$bus_numbers = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $bus_numbers[] = $row; // Collect each bus number
    }
    echo json_encode($bus_numbers); // Return data as JSON
} else {
    echo json_encode([]); // Return empty array if query fails
}
?>