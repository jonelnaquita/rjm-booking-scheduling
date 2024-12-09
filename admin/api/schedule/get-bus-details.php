<?php
include '../../../models/conn.php';

if (isset($_GET['bus_id'])) {
    $bus_id = intval($_GET['bus_id']); // Sanitize input

    // Prepare query to get bus details
    $query = "SELECT terminal_id, destination_id FROM tblbus WHERE bus_id = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $bus_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            echo json_encode($row); // Return bus details
        } else {
            echo json_encode([]); // No data found
        }

        $stmt->close();
    } else {
        echo json_encode([]); // Return empty array if query fails
    }
} else {
    echo json_encode([]); // If bus_id is not provided
}
?>