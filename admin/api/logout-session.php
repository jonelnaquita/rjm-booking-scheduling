<?php
session_start();

// Destroy the session
if (isset($_SESSION['admin'])) {
    unset($_SESSION['admin']);
    session_destroy();
}

// Redirect to login page
header('Location: ../index.php'); // Adjust the path if necessary
exit();
?>
