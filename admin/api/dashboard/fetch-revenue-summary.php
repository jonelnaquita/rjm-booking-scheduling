<?php
// fetch-revenue.php
include '../../../models/conn.php'; // Include your database connection

// Get the year from the request, default to the current year
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

$revenues = [];

// SQL to fetch total revenue per month for the given year
$query = "SELECT MONTH(date_created) AS month, SUM(price) AS total_revenue
          FROM tblbooking
          WHERE YEAR(date_created) = ? AND tblbooking.status = 'Confirmed'
          GROUP BY month
          ORDER BY month";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $year); // Bind the year parameter
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
