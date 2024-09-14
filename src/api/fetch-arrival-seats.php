<?php
// Check if 'arrival_seats' exists in the session
if (isset($_SESSION['arrival_seats'])) {
    // Fetch the seats data from the session
    $arrivalSeats = $_SESSION['arrival_seats'];

    // Display the seats data
    // echo '<h3>Selected Arrival Seats:</h3>';
    // echo '<ul>';
    foreach ($arrivalSeats as $seat) {
      //  echo '<li>Seat ' . htmlspecialchars($seat) . '</li>';
    }
    //echo '</ul>';
} else {
    // No seats found in session
   // echo '<p>No arrival seats have been selected.</p>';
}
?>
