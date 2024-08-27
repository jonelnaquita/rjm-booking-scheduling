<?php
// Include database connection
include '../../../models/conn.php';

// Prepare the SQL query to fetch all provinces
$sql = "SELECT province_id, province FROM tblprovince";
$result = $conn->query($sql);

// Initialize an array to store the provinces
$provinces = [];

if ($result->num_rows > 0) {
    // Fetch the results as an associative array
    while ($row = $result->fetch_assoc()) {
        $provinces[] = [
            'id' => $row['province_id'],
            'province' => $row['province']
        ];
    }
}

// Close the connection
$conn->close();

// Send the provinces as a JSON response
echo json_encode($provinces);
?>
