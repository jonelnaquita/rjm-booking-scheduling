<?php
session_start();
include_once '../../../models/conn.php';

// Check if the admin session is active
if (!isset($_SESSION['admin'])) {
    header('Location: ../../admin/index.php'); // Redirect if not logged in
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_id = $_SESSION['admin']; // Get the admin_id from the session
    $company_name = $_POST['company_name'];
    $logo = isset($_FILES['logo']) ? $_FILES['logo'] : null;
    $current_logo_path = $_POST['current_logo_path']; // Current logo path from hidden field

    // Define the new logo path
    $logo_path = 'logo-mini'; // The fixed name for the logo

    // Define the path to save the new logo
    $upload_path = '../../assets/images/' . $logo_path;

    // Validate and process the logo file if a new file is uploaded
    if ($logo && $logo['error'] == 0) {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'svg'];
        $file_extension = pathinfo($logo['name'], PATHINFO_EXTENSION);

        if (!in_array($file_extension, $allowed_extensions)) {
            echo 'Invalid file format. Please upload a JPG, JPEG, PNG, or SVG file.';
            exit();
        }

        // Move the uploaded file to the desired directory with the fixed name
        if (!move_uploaded_file($logo['tmp_name'], $upload_path)) {
            echo 'Failed to upload the logo.';
            exit();
        }

        // Optionally delete the old logo file if it exists
        if ($current_logo_path && file_exists('../../assets/images/' . $current_logo_path) && $current_logo_path !== $logo_path) {
            unlink('../../assets/images/' . $current_logo_path);
        }
    }

    // Prepare the SQL query to update company name and logo
    $sql = "UPDATE tbladmin SET company_name = ?, logo = ? WHERE admin_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $company_name, $logo_path, $admin_id);

    if ($stmt->execute()) {
        echo 'Website settings updated successfully.';
    } else {
        echo 'Error updating website settings.';
    }

    $stmt->close();
}
?>
