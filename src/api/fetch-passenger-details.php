<?php

if (isset($_SESSION['passenger_details'])) {
    $passengerDetails = $_SESSION['passenger_details'];

    /*
        echo "First Name: " . htmlspecialchars($passengerDetails['firstName']) . "<br>";
        echo "Middle Name: " . htmlspecialchars($passengerDetails['middleName']) . "<br>";
        echo "Last Name: " . htmlspecialchars($passengerDetails['lastName']) . "<br>";
        echo "Gender: " . htmlspecialchars($passengerDetails['gender']) . "<br>";
        echo "Province: " . htmlspecialchars($passengerDetails['province']) . "<br>";
        echo "City: " . htmlspecialchars($passengerDetails['city']) . "<br>";
        echo "Email: " . htmlspecialchars($passengerDetails['email']) . "<br>";
        echo "Mobile Number: " . htmlspecialchars($passengerDetails['mobile']) . "<br>";
        echo "Full Address: " . htmlspecialchars($passengerDetails['fullAddress']) . "<br>";

    */

} else {
    // echo "No passenger details found.";
}
?>