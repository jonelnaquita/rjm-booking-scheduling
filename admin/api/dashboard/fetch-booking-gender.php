<?php
include '../../../models/conn.php'; // Ensure the path is correct

// SQL query to fetch gender-wise confirmed booking counts
$query = "
    SELECT 
        tp.gender, 
        COUNT(tb.book_id) AS count
    FROM 
        tblbooking tb
    LEFT JOIN 
        tblpassenger tp 
        ON tb.passenger_id = tp.passenger_code
    WHERE 
        tb.status = 'Confirmed'
    GROUP BY 
        tp.gender
";

$result = $conn->query($query);

$genderCounts = [
    'Male' => 0,
    'Female' => 0,
    'Preferred Not to Say' => 0,
];

// Populate gender counts
while ($row = $result->fetch_assoc()) {
    $gender = ucfirst(strtolower($row['gender'])); // Normalize gender labels
    if (isset($genderCounts[$gender])) {
        $genderCounts[$gender] = (int) $row['count'];
    } else {
        $genderCounts['Preferred Not to Say'] += (int) $row['count'];
    }
}

// Close connection and return data
$conn->close();
header('Content-Type: application/json');
echo json_encode($genderCounts);

?>