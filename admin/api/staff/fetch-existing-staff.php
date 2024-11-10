<?php
// Include your database connection file
require '../../../models/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staff_id = $_POST['staff_id'];

    // Prepare SQL query to fetch staff details
    $query = "SELECT firstname, lastname, role, mobile_number, terminal, bus_number FROM tblstaff WHERE staff_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $staff_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the staff details and return as JSON
        $staff_details = $result->fetch_assoc();
        echo json_encode($staff_details);
    } else {
        echo json_encode(['error' => 'Staff not found.']);
    }

    $stmt->close();
    $conn->close();
}
?>