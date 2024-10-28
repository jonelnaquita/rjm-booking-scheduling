<?php
/**

$servername = "bnvejcajv69tkidtqqjr-mysql.services.clever-cloud.com"; // Change this if your MySQL server is on a different host
$username = "u0fufg2xxdwboag4"; // Replace with your MySQL username
$password = "5hpp1yTykl8Cf1hPIz1M"; // Replace with your MySQL password
$database = "bnvejcajv69tkidtqqjr"; // The name of your database
*/

$servername = "localhost"; // Change this if your MySQL server is on a different host
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "rjmdb"; // The name of your database


// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
