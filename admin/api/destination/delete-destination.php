<?php
// Include database connection
require '../../../models/conn.php';

if (isset($_POST['from_id'])) {
    $from_id = $_POST['from_id'];

    // SQL query to delete the location from tblroutefrom
    $sql = "DELETE FROM tblroutefrom WHERE from_id = ?";

    // Prepare and execute the query
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $from_id); // 'i' is for integer type
        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
        $stmt->close();
    } else {
        echo 'error';
    }

    $conn->close();
} else {
    echo 'error';
}
?>