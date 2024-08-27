<?php
require_once('../../../models/conn.php');

if (isset($_GET['id'])) {
    $busTypeId = $_GET['id'];

    // Assume that database connection is already established
    $sql = "SELECT * FROM tblbustype WHERE bustype_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $busTypeId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $busType = $result->fetch_assoc();
        echo json_encode($busType);
    } else {
        echo json_encode([]);
    }

    $stmt->close();
    $conn->close();
}
?>
