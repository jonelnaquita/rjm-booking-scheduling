<?php
session_start();
include_once '../../../models/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staff_id = $_SESSION['staff']; // Get the admin_id from the session
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the current hashed password from the database
    $sql = "SELECT password FROM tblstaff WHERE staff_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $staff_id);
    $stmt->execute();
    $stmt->bind_result($db_password);
    $stmt->fetch();
    $stmt->close();

    // Verify the current password
    if (!password_verify($current_password, $db_password)) {
        echo "The current password is incorrect.";
        exit();
    }

    // Check if the new password and confirm password match
    if ($new_password !== $confirm_password) {
        echo "Passwords do not match.";
        exit();
    }

    // Update the password in the database (hash the new password)
    $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);
    $update_sql = "UPDATE tblstaff SET password = ? WHERE staff_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('si', $hashed_new_password, $staff_id);

    if ($update_stmt->execute()) {
        echo "Password updated successfully.";
    } else {
        echo "Error updating password.";
    }

    $update_stmt->close();
}
?>
