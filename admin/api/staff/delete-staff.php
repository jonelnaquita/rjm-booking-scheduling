<?php
// Include your database connection file
require '../../../models/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staff_id = $_POST['staff_id'];

    // Prepare the SQL delete statement
    $delete_query = "DELETE FROM tblstaff WHERE staff_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param('i', $staff_id);

    // Execute the statement and check if the deletion was successful
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
}
?>
