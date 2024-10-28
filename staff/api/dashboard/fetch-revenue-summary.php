<?php
// fetch-revenue.php
include '../../../models/conn.php'; // Include your database connection

// Get the year and terminal ID from the request
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
$terminalId = isset($_GET['terminal']) ? intval($_GET['terminal']) : 0; // Default to 0 or adjust as necessary

$revenues = [];

// SQL to fetch total revenue per month for the given year and terminal ID
$query = "SELECT MONTH(tblbooking.date_created) AS month, SUM(price) AS total_revenue
          FROM tblbooking
          JOIN tblschedule ON tblbooking.scheduleDeparture_id = tblschedule.schedule_id OR tblbooking.scheduleArrival_id = tblschedule.schedule_id
          JOIN tblroutefrom ON tblschedule.destination_from = tblroutefrom.from_id
          WHERE tblroutefrom.from_id = ? AND YEAR(tblbooking.date_created) = ? AND tblbooking.status = 'Confirmed'
          GROUP BY month
          ORDER BY month"; // Make sure to include GROUP BY

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $terminalId, $year); // Bind terminal ID and year parameters
$stmt->execute();
$result = $stmt->get_result();

// Initialize array with 0s for each month
for ($i = 1; $i <= 12; $i++) {
    $revenues[$i] = 0; // Default revenue is 0
}

// Populate the revenue array with actual data
while ($row = $result->fetch_assoc()) {
    $revenues[$row['month']] = (float)$row['total_revenue'];
}

// Close connection
$stmt->close();
$conn->close();

// Return revenue data as JSON
header('Content-Type: application/json');
echo json_encode($revenues);
?>
