<?php
// Include database connection
include '../../../models/conn.php';

if (isset($_POST['schedule_id'])) {
    $schedule_id = $_POST['schedule_id'];

    // Prepare the SQL query to delete the row from tblschedule
    $query = "DELETE FROM tblschedule WHERE schedule_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $schedule_id);

    if ($stmt->execute()) {
        echo 'success'; // Return success message
    } else {
        echo 'error'; // Return error message
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
