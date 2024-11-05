<?php

$servername = "localhost"; // Change this if your MySQL server is on a different host
$username = "u396323918_rjmdb"; // Replace with your MySQL username
$password = "3|jSIF*gC"; // Replace with your MySQL password
$database = "u396323918_rjmdb"; // The name of your database


// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>