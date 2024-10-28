<?php
include_once '../../../models/conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare to receive data
    $reservation_fee = $_POST['reservation-fee'];
    $admin_id = $_SESSION['admin'];
    $upload_dir = '../../../assets/images/payment/';

    // Handle image upload
    $gcash_path = null;

    if (isset($_FILES['gcash-qr']) && $_FILES['gcash-qr']['error'] == UPLOAD_ERR_OK) {
        $file_name = $_FILES['gcash-qr']['name'];
        $file_tmp = $_FILES['gcash-qr']['tmp_name'];
        $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
        $allowed_types = ['jpg', 'jpeg', 'png', 'svg'];

        // Validate file type
        if (in_array(strtolower($file_type), $allowed_types)) {
            // Generate a unique file name
            $new_file_name = uniqid('gcash_', true) . '.' . $file_type;
            $upload_file = $upload_dir . $new_file_name;

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($file_tmp, $upload_file)) {
                $gcash_path = $new_file_name;
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to upload the image.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid file type.']);
            exit;
        }
    }

    // Prepare and execute the update statement
    if ($gcash_path) {
        $stmt = $conn->prepare("UPDATE tbladmin SET reservation_fee = ?, gcash = ? WHERE admin_id = ?");
        $stmt->bind_param("ssi", $reservation_fee, $gcash_path, $admin_id);
    } else {
        $stmt = $conn->prepare("UPDATE tbladmin SET reservation_fee = ? WHERE admin_id = ?");
        $stmt->bind_param("si", $reservation_fee, $admin_id);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'gcash_path' => $gcash_path]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update the reservation fee and/or GCash QR code.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
