<?php
include_once '../../../models/conn.php'; // Include your database connection

if (isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];

    // Modified SQL query to join tblpayment and tblbooking
    $sql = "
        SELECT 
            tblpayment.screenshot_filename, 
            tblpayment.reference_number, 
            tblbooking.price,
            tblbooking.book_id
        FROM 
            tblpayment 
        JOIN 
            tblbooking ON tblpayment.passenger_id = tblbooking.passenger_id 
        WHERE 
            tblbooking.book_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'data' => $row
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No payment details found'
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request'
    ]);
}

$conn->close();
?>
