<?php
// Include your database connection file
require '../../../models/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the staff_id and new_password from the POST request
    $staff_id = $_POST['staff_id'];
    $new_password = $_POST['new_password'];

    // Hash the new password for security
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database
    $sql = "UPDATE tblstaff SET password = ? WHERE staff_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si", $hashed_password, $staff_id);
        if ($stmt->execute()) {
            echo "success"; // Success response
        } else {
            echo "error"; // Error response if execution fails
        }
        $stmt->close();
    } else {
        echo "error"; // Error response if the statement preparation fails
    }

    // Close the database connection
    $conn->close();
}
?>