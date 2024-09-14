<?php
// Check if 'departure_seats' exists in the session
if (isset($_SESSION['departure_seats'])) {
    // Fetch the seats data from the session
    $departureSeats = $_SESSION['departure_seats'];

    // Display the seats data
   // echo '<h3>Selected Departure Seats:</h3>';
   // echo '<ul>';
    foreach ($departureSeats as $seat) {
        //echo '<li>Seat ' . htmlspecialchars($seat) . '</li>';
    }
   // echo '</ul>';
} else {
    // No seats found in session
   // echo '<p>No departure seats have been selected.</p>';
}
?>
