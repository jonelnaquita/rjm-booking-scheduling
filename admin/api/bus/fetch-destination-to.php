<?php
include '../../../models/conn.php';

if (isset($_POST['from_id'])) {
    $from_id = intval($_POST['from_id']); // Sanitize input

    // Prepare query with parameter binding
    $query = "SELECT rt.to_id, rt.destination_to, rf.from_id, rf.destination_from 
              FROM tblrouteto rt 
              JOIN tblroutefrom rf ON rt.from_id = rf.from_id 
              WHERE rt.destination_to = ?"; // Filter by from_id instead of destination_to

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $from_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $destinations = [];
        while ($row = $result->fetch_assoc()) {
            $destinations[] = $row;
        }

        echo json_encode($destinations);
        $stmt->close();
    } else {
        echo json_encode([]);
    }
}
?>