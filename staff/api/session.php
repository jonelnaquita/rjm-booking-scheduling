<?php
session_start();

include '../../models/conn.php';

// Check if the admin session is active
if (!isset($_SESSION['staff']) || !isset( $_SESSION['role'])) {
    // If not set, redirect to the login page
    header('Location: ../index.php');
    exit();
}

// Get the admin_id from session
$admin_id = $_SESSION['staff'];

// Prepare SQL query to fetch the role from tblstaff based on admin_id
$sql = "SELECT * FROM tblstaff WHERE staff_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);  // Bind the staff_id parameter
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the role
    $row = $result->fetch_assoc();
    $role = $row['role'];
    $terminal = $row['terminal'];
    $fullname = $row['firstname'].' '.$row['lastname'];

    // Optionally, store the role in a session variable
    $_SESSION['role'] = $role;
    $_SESSION['terminal'] = $terminal;
} else {
    // Handle case where no admin is found (optional)
    echo "No staff found for this admin.";
    exit();
}

?>
