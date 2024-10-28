<?php
session_start();

// Destroy the session
if (isset($_SESSION['staff'])) {
    unset($_SESSION['staff']);
    session_destroy();
}

// Redirect to login page
header('Location: ../index.php'); // Adjust the path if necessary
exit();
?>
