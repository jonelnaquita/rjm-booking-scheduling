<?php
include_once '../../../models/conn.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve data from POST request
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $role = $_POST['role'];
    $terminal = $_POST['terminal'];
    $bus_number = isset($_POST['bus_number']) && !empty($_POST['bus_number']) ? $_POST['bus_number'] : '0';
    $email = $_POST['email'];
    $mobile_number = $_POST['mobile-number'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $status = "Active";
    $rest_days = isset($_POST['rest_day']) ? (is_array($_POST['rest_day']) ? implode(',', $_POST['rest_day']) : $_POST['rest_day']) : '';


    // Validate email doesn't already exist
    $checkEmailQuery = "SELECT * FROM tblstaff WHERE email = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo 'Email already exists!';
        exit();
    }

    // Insert the data into the database
    $query = "INSERT INTO tblstaff (firstname, lastname, email, mobile_number, password, bus_number, status, role, terminal, rest_day) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssss", $firstname, $lastname, $email, $mobile_number, $password, $bus_number, $status, $role, $terminal, $rest_days);

    if ($stmt->execute()) {
        echo 'Staff saved successfully!';
    } else {
        echo 'Error saving staff!';
    }

    $stmt->close();
    $conn->close();
}
?>