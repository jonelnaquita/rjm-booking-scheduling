<?php
include '../../models/conn.php'; // Database connection

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
$departureSeats = explode(', ', $_POST['departureSeats']);
$arrivalSeats = explode(', ', $_POST['arrivalSeats']);
$reference_number = $_POST['reference-number'];

// Insert into tblpassenger
$sqlPassenger = "INSERT INTO tblpassenger (passenger_code, firstname, middlename, lastname, city, email, mobile_number, full_address) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmtPassenger = $conn->prepare($sqlPassenger);
$stmtPassenger->bind_param("ssssssss", $passenger_id, $firstName, $middleName, $lastName, $city, $email, $mobile_number, $fullAddress);

if (!$stmtPassenger->execute()) {
    echo json_encode(["success" => false, "message" => "Error saving passenger data: " . $stmtPassenger->error]);
    exit;
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
    echo json_encode(["success" => false, "message" => "Error saving booking data: " . $stmtBooking->error]);
    exit;
}

// Insert into tblseats for departure seats
foreach ($departureSeats as $seat) {
    $sqlSeats = "INSERT INTO tblseats (passenger_id, schedule_id, seat_number) 
                 VALUES (?, ?, ?)";
    $stmtSeats = $conn->prepare($sqlSeats);
    $stmtSeats->bind_param("sss", $passenger_id, $scheduleDeparture_id, $seat);
    
    if (!$stmtSeats->execute()) {
        echo json_encode(["success" => false, "message" => "Error saving departure seat data: " . $stmtSeats->error]);
        exit;
    }
}

// Insert into tblseats for arrival seats (if Round-Trip)
if ($direction == "Round-Trip") {
    foreach ($arrivalSeats as $seat) {
        $sqlSeats = "INSERT INTO tblseats (passenger_id, schedule_id, seat_number) 
                     VALUES (?, ?, ?)";
        $stmtSeats = $conn->prepare($sqlSeats);
        $stmtSeats->bind_param("sss", $passenger_id, $scheduleArrival_id, $seat);
        
        if (!$stmtSeats->execute()) {
            echo json_encode(["success" => false, "message" => "Error saving arrival seat data: " . $stmtSeats->error]);
            exit;
        }
    }
}

// Handle file upload
$target_dir = "../payment/";
$file_extension = strtolower(pathinfo($_FILES["payment-proof"]["name"], PATHINFO_EXTENSION));
$file_name = $passenger_id . '.' . $file_extension;
$target_file = $target_dir . $file_name;
$uploadOk = 1;

// Check if image file is an actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["payment-proof"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo json_encode(["success" => false, "message" => "File is not an image."]);
        exit;
    }
}

// Check file size
if ($_FILES["payment-proof"]["size"] > 500000) {
    echo json_encode(["success" => false, "message" => "Sorry, your file is too large."]);
    exit;
}

// Allow certain file formats
if ($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg" && $file_extension != "gif") {
    echo json_encode(["success" => false, "message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."]);
    exit;
}

// If everything is ok, try to upload file
if (move_uploaded_file($_FILES["payment-proof"]["tmp_name"], $target_file)) {
    // File uploaded successfully, now save to database
    $sqlPayment = "INSERT INTO tblpayment (screenshot_filename, reference_number, passenger_id) 
                   VALUES (?, ?, ?)";
    
    $stmtPayment = $conn->prepare($sqlPayment);
    $stmtPayment->bind_param("sss", $file_name, $reference_number, $passenger_id);
    
    if ($stmtPayment->execute()) {
        echo json_encode(["success" => true, "passenger_id" => $passenger_id]);
    } else {
        echo json_encode(["success" => false, "message" => "Error saving payment data: " . $stmtPayment->error]);
    }
    
    $stmtPayment->close();
} else {
    echo json_encode(["success" => false, "message" => "Sorry, there was an error uploading your file."]);
}

$conn->close();
?>
