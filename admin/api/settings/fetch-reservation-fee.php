<?php
require '../../../models/conn.php';  // Include your database connection script

// Fetch reservation fee from tbladmin
$query = "SELECT reservation_fee FROM tbladmin LIMIT 1"; // Adjust your query as needed
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['success' => true, 'reservation_fee' => $row['reservation_fee']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to fetch reservation fee.']);
}
?>
