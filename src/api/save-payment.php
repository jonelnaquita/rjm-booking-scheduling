<?php
include '../../models/conn.php'; // Database connection

// Start transaction
mysqli_begin_transaction($conn);

try {
    // Generate passenger ID
    $year = date("Y");
    $randomPart1 = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    $randomPart2 = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    $passenger_id = "RJM-" . $year . "-" . $randomPart1 . "-" . $randomPart2;

    // Get form data
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $city = $_POST['city'];
    $email = $_POST['email'];
    $mobile_number = $_POST['mobile'];
    $fullAddress = $_POST['fullAddress'];
    $scheduleDeparture_id = $_POST['scheduleDeparture_id'];
    $scheduleArrival_id = $_POST['scheduleArrival_id'];
    $direction = $_POST['direction'];
    $totalAmount = $_POST['totalAmount'];
    $passenger = $_POST['passenger']; // Number of passengers
    $reference_number = $_POST['reference-number'];
    $departureSeats = explode(', ', $_POST['departureSeats']);
    // Only get arrivalSeats if direction is Round-Trip
    $arrivalSeats = [];
    if ($direction == "Round-Trip") {
        $arrivalSeats = explode(', ', $_POST['arrivalSeats']);
    }

    // Handle file upload (payment proof)
    $target_dir = "../payment/";
    $file_extension = strtolower(pathinfo($_FILES["payment-proof"]["name"], PATHINFO_EXTENSION));
    $file_name = $passenger_id . '.' . $file_extension;
    $target_file = $target_dir . $file_name;

    // Check if image file is valid
    if (!getimagesize($_FILES["payment-proof"]["tmp_name"])) {
        throw new Exception("File is not an image.");
    }

    // Check file size (max 10MB)
    if ($_FILES["payment-proof"]["size"] > 10 * 1024 * 1024) {
        throw new Exception("File is too large. Maximum file size is 10MB.");
    }

    // Allow only specific file formats
    if (!in_array($file_extension, ['jpg', 'png', 'jpeg', 'gif'])) {
        throw new Exception("Only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // Upload the file
    if (!move_uploaded_file($_FILES["payment-proof"]["tmp_name"], $target_file)) {
        throw new Exception("There was an error uploading your file.");
    }

    // Insert payment record into tblpayment
    $sqlPayment = "INSERT INTO tblpayment (screenshot_filename, reference_number, passenger_id) 
                   VALUES (?, ?, ?)";
    $stmtPayment = $conn->prepare($sqlPayment);
    $stmtPayment->bind_param("sss", $file_name, $reference_number, $passenger_id);
    
    if (!$stmtPayment->execute()) {
        throw new Exception("Error saving payment data: " . $stmtPayment->error);
    }

    // Payment succeeded, proceed to other operations

    // Insert into tblpassenger
    $sqlPassenger = "INSERT INTO tblpassenger (passenger_code, firstname, middlename, lastname, city, email, mobile_number, full_address) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtPassenger = $conn->prepare($sqlPassenger);
    $stmtPassenger->bind_param("ssssssss", $passenger_id, $firstName, $middleName, $lastName, $city, $email, $mobile_number, $fullAddress);
    
    if (!$stmtPassenger->execute()) {
        throw new Exception("Error saving passenger data: " . $stmtPassenger->error);
    }

    // Insert into tblbooking
    if ($direction == "Round-Trip") {
        $sqlBooking = "INSERT INTO tblbooking (passenger_id, scheduleDeparture_id, scheduleArrival_id, trip_type, price, passengers, status) 
                       VALUES (?, ?, ?, ?, ?, ?, 'Pending')";
        $stmtBooking = $conn->prepare($sqlBooking);
        $stmtBooking->bind_param("ssssss", $passenger_id, $scheduleDeparture_id, $scheduleArrival_id, $direction, $totalAmount, $passenger);
    } else {
        $sqlBooking = "INSERT INTO tblbooking (passenger_id, scheduleDeparture_id, trip_type, price, passengers, status) 
                       VALUES (?, ?, ?, ?, ?, 'Pending')";
        $stmtBooking = $conn->prepare($sqlBooking);
        $stmtBooking->bind_param("sssss", $passenger_id, $scheduleDeparture_id, $direction, $totalAmount, $passenger);
    }

    if (!$stmtBooking->execute()) {
        throw new Exception("Error saving booking data: " . $stmtBooking->error);
    }

    // Insert into tblseats for departure seats
    foreach ($departureSeats as $seat) {
        $sqlSeats = "INSERT INTO tblseats (passenger_id, schedule_id, seat_number) 
                     VALUES (?, ?, ?)";
        $stmtSeats = $conn->prepare($sqlSeats);
        $stmtSeats->bind_param("sss", $passenger_id, $scheduleDeparture_id, $seat);
        
        if (!$stmtSeats->execute()) {
            throw new Exception("Error saving departure seat data: " . $stmtSeats->error);
        }
    }

    // Insert into tblseats for arrival seats (if Round-Trip)
    if ($direction == "Round-Trip") {
        foreach ($arrivalSeats as $seat) {
            $sqlSeats = "INSERT INTO tblseats (passenger_id, schedule_id, seat_number) 
                         VALUES (?, ?, ?)";
            $stmtSeats->bind_param("sss", $passenger_id, $scheduleArrival_id, $seat);
            
            if (!$stmtSeats->execute()) {
                throw new Exception("Error saving arrival seat data: " . $stmtSeats->error);
            }
        }
    }

    // Commit the transaction
    mysqli_commit($conn);

    // Success response
    echo json_encode(["success" => true, "passenger_id" => $passenger_id]);

} catch (Exception $e) {
    // Rollback the transaction on failure
    mysqli_rollback($conn);
    
    // Return error response
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}

$conn->close();
?>
