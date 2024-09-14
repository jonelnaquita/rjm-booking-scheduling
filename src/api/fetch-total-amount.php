<?php
session_start();
// Check if the totalAmount session variable exists
if (isset($_SESSION['totalAmount'])) {
    $totalAmount = $_SESSION['totalAmount'];
    $formattedAmount = number_format($totalAmount, 2);
    // echo "Total Amount: ₱" . $formattedAmount;
} else {
    // echo "Total Amount not found in session.";
}

session_abort();
?>