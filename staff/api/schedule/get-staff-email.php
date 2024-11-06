<?php
// Include your database connection file
include '../../../models/conn.php';

if (isset($_POST['bus_id'])) {
    $bus_id = $_POST['bus_id'];

    // Prepare SQL query to retrieve the staff email based on the bus ID
    $query = "SELECT tblstaff.email, tblstaff.firstname, tblbus.bus_number, tblstaff.role FROM tblstaff
              INNER JOIN tblbus ON tblstaff.bus_number = tblbus.bus_id
              WHERE tblstaff.bus_number = ? AND (tblstaff.role = 'Driver' OR tblstaff.role = 'Conductor')";

    // Prepare statement
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $bus_id); // Bind bus_id as an integer
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any result was returned
        if ($result->num_rows > 0) {
            // Fetch the email and full name of the staff
            $row = $result->fetch_assoc();
            $email = $row['email'];
            $firstname = $row['firstname'];
            $bus_number = $row['bus_number'];

            // Return the email and fullname as a JSON response
            echo json_encode(['email' => $email, 'firstname' => $firstname, 'bus_number' => $bus_number]);
        } else {
            // If no staff is found for the bus ID, return an error
            echo json_encode(['error' => 'No staff found for this bus.']);
        }

        // Close statement
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Database query error.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request. Bus ID missing.']);
}

// Close the database connection
$conn->close();
?>