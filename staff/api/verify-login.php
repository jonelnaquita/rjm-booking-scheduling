<?php
session_start();
include '../../models/conn.php'; // Adjust path as necessary

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to select user with the provided email
    $query = "SELECT * FROM tblstaff WHERE email = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, create session
            $_SESSION['staff'] = $user['staff_id']; // Store staff ID in session
            $_SESSION['role'] = $user['role']; // Store role in session
            
            // Return success response to client with role information
            echo json_encode(['success' => true, 'role' => $user['role']]);
        } else {
            // Return error for invalid password
            echo json_encode(['success' => false, 'message' => 'Invalid password']);
        }
    } else {
        // Return error for no user found
        echo json_encode(['success' => false, 'message' => 'No user found with this email']);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
