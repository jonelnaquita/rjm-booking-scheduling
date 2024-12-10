<?php
include '../../../models/conn.php'; // Ensure the path is correct

// SQL query to fetch city-wise confirmed booking counts
$query = "
    SELECT 
        tp.city, 
        COUNT(tb.book_id) AS count
    FROM 
        tblbooking tb
    LEFT JOIN 
        tblpassenger tp 
        ON tb.passenger_id = tp.passenger_code
    WHERE 
        tb.status = 'Confirmed'
    GROUP BY 
        tp.city
";

$result = $conn->query($query);

$cityCounts = [];

// Populate city counts
while ($row = $result->fetch_assoc()) {
    $city = $row['city'] ?: 'Unknown'; // Handle NULL or empty city names
    $cityCounts[$city] = (int) $row['count'];
}

// Close connection and return data
$conn->close();
header('Content-Type: application/json');
echo json_encode($cityCounts);
?>