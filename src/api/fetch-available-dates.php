<?php
include_once '../../models/conn.php';

// Query to fetch available dates
$sql = "SELECT DISTINCT departure_date FROM tblschedule WHERE departure_date >= CURDATE() ORDER BY departure_date";
$result = $conn->query($sql);

$availableDates = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $availableDates[] = date('m/d/Y', strtotime($row['departure_date'])); // Format: m/d/Y for Bootstrap Datepicker
    }
}

echo json_encode($availableDates);
$conn->close();
?>
