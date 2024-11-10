<?php
// fetch-revenue.php
include '../../../models/conn.php'; // Include your database connection

// Get the year and month from the request, default to the current year and month
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
$month = isset($_GET['month']) ? intval($_GET['month']) : date('m');

// Initialize array with 0s for each day of the month (31 days max)
$revenues = array_fill(1, 31, 0);

// SQL to fetch total revenue per day for the given year and month
$query = "SELECT DAY(date_created) AS day, SUM(price) AS total_revenue
          FROM tblbooking
          WHERE YEAR(date_created) = ? AND MONTH(date_created) = ? AND tblbooking.status = 'Confirmed'
          GROUP BY day
          ORDER BY day";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $year, $month); // Bind the year and month parameters
$stmt->execute();
$result = $stmt->get_result();

// Populate the revenue array with actual data
while ($row = $result->fetch_assoc()) {
    $revenues[$row['day']] = (float) $row['total_revenue'];
}

// Close connection
$stmt->close();
$conn->close();

// Return revenue data as JSON
header('Content-Type: application/json');
echo json_encode($revenues);

?>