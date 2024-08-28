<?php
// Include your database connection file
include '../../../models/conn.php';

// Fetch destinations from tblroutefrom
$query = "SELECT from_id, destination_from FROM tblroutefrom";
$result = mysqli_query($conn, $query);

$destinations = [];
while ($row = mysqli_fetch_assoc($result)) {
    $destinations[] = $row;
}

echo json_encode($destinations);
?>