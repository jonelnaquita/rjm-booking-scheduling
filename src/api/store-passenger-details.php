<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $_SESSION['passenger_details'] = [
        'firstName' => htmlspecialchars($_POST['firstName']),
        'middleName' => htmlspecialchars($_POST['middleName']),
        'lastName' => htmlspecialchars($_POST['lastName']),
        'city' => htmlspecialchars($_POST['city']),
        'email' => htmlspecialchars($_POST['email']),
        'mobile' => htmlspecialchars($_POST['mobile']),
        'fullAddress' => htmlspecialchars($_POST['fullAddress']),
    ];

    // Redirect to the next step
    header("Location: ../pages/seats.php");
    exit();
}
?>
