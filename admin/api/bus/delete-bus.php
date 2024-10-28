<?php
require_once('../../../models/conn.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['bus_id'])) {
        $bus_id = $_POST['bus_id'];

        // Prepare the DELETE query
        $query = "DELETE FROM tblbus WHERE bus_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $bus_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => 'Bus deleted successfully']);
        } else {
            echo json_encode(['error' => 'Failed to delete bus']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Bus ID not provided']);
    }
}
?>
