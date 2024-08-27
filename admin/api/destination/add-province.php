<?php
// Include database connection
include '../../../models/conn.php';

// Get the province name from the AJAX request
$province = isset($_POST['province']) ? $_POST['province'] : '';

// Prepare the SQL query to insert the province
$sql = "INSERT INTO tblprovince (province) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $province);

// Execute the query and check for success
$response = [];
if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = 'Province added successfully.';
} else {
    $response['success'] = false;
    $response['message'] = 'Failed to add province.';
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Send the response as JSON
echo json_encode($response);
?>
