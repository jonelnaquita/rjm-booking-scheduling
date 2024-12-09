<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $_SESSION['passenger_details'] = [
        'firstName' => htmlspecialchars($_POST['firstName']),
        'middleName' => htmlspecialchars($_POST['middleName']),
        'lastName' => htmlspecialchars($_POST['lastName']),
        'gender' => htmlspecialchars($_POST['gender']),
        'province' => htmlspecialchars($_POST['province']),
        'city' => htmlspecialchars($_POST['city-selected']),
        'email' => htmlspecialchars($_POST['email']),
        'mobile' => htmlspecialchars($_POST['mobile']),
        'fullAddress' => htmlspecialchars($_POST['fullAddress']),
    ];

    // Redirect to the next step
    header("Location: ../pages/seats.php");
    exit();
}
?>