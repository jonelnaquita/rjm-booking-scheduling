<?php
session_start();
include '../../../models/conn.php';

if (isset($_POST['schedule_id'])) {
    $schedule_id = $_POST['schedule_id'];

    // Prepare the SQL query to delete the row from tblschedule
    $query = "DELETE FROM tblschedule WHERE schedule_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $schedule_id);

    if ($stmt->execute()) {
        $staff_id = $_SESSION['staff'];
        $role = "Terminal Staff";
        $action = "Deleted a Schedule";
        $date_created = date('Y-m-d H:i:s');
        $category = "Schedule";

        $log_query = "INSERT INTO tbllogs (staff_id, action_id, category, role, action, date_created) VALUES (?, ?, ?, ?, ?, ?)";
        $log_stmt = $conn->prepare($log_query);
        $log_stmt->bind_param("iissss", $staff_id, $schedule_id, $category, $role, $action, $date_created);

        if ($log_stmt->execute()) {
            echo 'success'; // Return success message
        } else {
            echo 'error logging action: ' . $log_stmt->error; // Log any error in logging action
        }

        // Close the log statement
        $log_stmt->close();
    } else {
        echo 'error deleting schedule: ' . $stmt->error; // Log any error in deleting schedule
    }

    // Close the delete statement and connection
    $stmt->close();
    $conn->close();
}
?>