<?php
session_start();
include '../../../models/conn.php'; // Your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newPassword = $_POST['password'];
    $token = $_POST['token'];

    // Validate token
    if (empty($token) || empty($newPassword)) {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        exit;
    }

    // Check if the token exists in `tblstaff`
    $query = "SELECT staff_id FROM tblstaff WHERE token = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $staff = $result->fetch_assoc();
        $staff_id = $staff['staff_id'];

        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password and clear the token
        $updateQuery = "UPDATE tblstaff SET password = ?, token = NULL WHERE staff_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("si", $hashedPassword, $staff_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update password']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid or expired token']);
    }
}
?>
