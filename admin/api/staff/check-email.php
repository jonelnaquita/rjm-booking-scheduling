<?php
include_once '../../../models/conn.php'; // Include the database connection

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Prepare SQL to check if the email already exists
    $query = "SELECT * FROM tblstaff WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the email exists, return 'taken', otherwise 'available'
    if ($result->num_rows > 0) {
        echo 'taken';
    } else {
        echo 'available';
    }

    $stmt->close();
    $conn->close();
}
?>
