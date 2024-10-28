<?php
require_once('../../../models/conn.php'); // Include your database connection file

if (isset($_GET['bus_id'])) {
    $bus_id = $_GET['bus_id'];

    $query = "SELECT bus_number, bus_type, seats FROM tblbus WHERE bus_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $bus_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $bus = $result->fetch_assoc();
        echo json_encode($bus);
    } else {
        echo json_encode(['error' => 'Bus not found']);
    }

    $stmt->close();
}
?>
