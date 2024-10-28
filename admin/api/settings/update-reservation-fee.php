<?php
require '../../../models/conn.php';  // Include your database connection script
session_start(); // Start the session to access session variables

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reservation_fee = $_POST['reservation_fee']; // Get the updated fee value

    // Validate the reservation fee (you may want to add more validation)
    if (!isset($reservation_fee) || !is_numeric($reservation_fee)) {
        echo json_encode(['success' => false, 'message' => 'Invalid reservation fee.']);
        exit;
    }

    $admin_id = $_SESSION['admin'];

    // Update the reservation fee in tbladmin
    $update_query = "UPDATE tbladmin SET reservation_fee = ? WHERE admin_id = ?";
    $stmt = $conn->prepare($update_query);
    
    // Make sure to bind the admin_id correctly
    $stmt->bind_param('di', $reservation_fee, $admin_id); // 'd' for double, 'i' for integer

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Reservation fee updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update reservation fee.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
