<?php
include '../models/conn.php';

// Retrieve POST data
$email = "jonel.naquita12@gmail.com";
$plainPassword = "admin12345";

// Validate inputs (basic validation for example purposes)
if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    die("Invalid email format");
}
if (empty($plainPassword)) {
    die("Password is required");
}

// Encrypt the password
$hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO tbladmin (email, password) VALUES (?, ?)");
$stmt->bind_param("ss", $email, $hashedPassword);

// Execute the query
if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>