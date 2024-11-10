<?php
// Database connection
session_start();
include '../../../models/conn.php';

if (isset($_POST['schedule_id'])) {
    $schedule_id = $_POST['schedule_id'];
    $bus_id = $_POST['bus_id'];
    $departure_date = $_POST['departure_date'];
    $departure_time = $_POST['departure_time'];
    $fare = $_POST['fare'];

    // Prepare the query to update schedule
    $query = "UPDATE tblschedule SET bus_id = ?, departure_date = ?, departure_time = ?, fare = ? WHERE schedule_id = ?";
    $stmt = $conn->prepare($query);

    // Use 'd' for double (decimal) and 'i' for integer types as appropriate
    $stmt->bind_param("ssssi", $bus_id, $departure_date, $departure_time, $fare, $schedule_id);

    if ($stmt->execute()) {

        $staff_id = $_SESSION['admin'];
        $role = "Admin";
        $action = "Updated a Schedule";
        $date_created = date('Y-m-d H:i:s');
        $category = "Schedule";

        // Log the action in tbllogs
        $log_query = "INSERT INTO tbllogs (staff_id, action_id, category, role, action, date_created) VALUES (?, ?, ?, ?, ?, ?)";
        $log_stmt = $conn->prepare($log_query);

        if ($log_stmt) {
            $log_stmt->bind_param('iissss', $staff_id, $schedule_id, $category, $role, $action, $date_created);
            $log_stmt->execute();
            $log_stmt->close();
        } else {
            echo json_encode(['error' => 'Failed to prepare log insertion.']);
            exit();
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to update schedule: ' . $stmt->error]);
    }

    $stmt->close();
}
?>