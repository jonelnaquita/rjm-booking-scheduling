<?php
// Include the database connection
include_once '../../../models/conn.php';
session_start();

$staff_id = $_SESSION['staff']; // Assuming the staff ID is stored in session
$new_email = $_POST['new_email'];
$current_password = $_POST['current_password'];

// Fetch current password hash from database
$query = "SELECT password FROM tblstaff WHERE staff_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $staff_id);
$stmt->execute();
$stmt->bind_result($hashed_password);
$stmt->fetch();
$stmt->close();

// Verify the password
if (password_verify($current_password, $hashed_password)) {
    // Update the email
    $update_query = "UPDATE tblstaff SET email = ? WHERE staff_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param('si', $new_email, $staff_id);

    if ($update_stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update email.']);
    }

    $update_stmt->close();
} else {
    // Password mismatch
    echo json_encode(['success' => false, 'message' => 'Incorrect password.']);
}
?>
