<?php
// Include the database connection
include_once '../../../models/conn.php';
session_start();

$staff_id = $_SESSION['staff']; // Assuming the admin ID is stored in session

// Query to fetch the current email
$query = "SELECT email FROM tblstaff WHERE staff_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $staff_id);
$stmt->execute();
$stmt->bind_result($email);
$stmt->fetch();
$stmt->close();

// Return the email as JSON
echo json_encode(['email' => $email]);
?>
