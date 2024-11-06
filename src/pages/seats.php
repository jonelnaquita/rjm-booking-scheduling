<!DOCTYPE html>
<html lang="en">
<?php
include '../components/header.php';
include '../api/store-schedule.php';
include '../api/fetch-passenger-details.php';
?>

<body>
    <?php
    include '../components/nav.php';
    ?>

    <head>
        <link rel="stylesheet" href="../../assets/css/seats.css">
    </head>

    <div class="container mt-5" style="height: 100vh;">
        <!-- Step 2 Row -->
        <div class="row step-row">
            <div class="col-12">
                <b>Step 3:</b> Choose your preferred seat
            </div>
        </div>

        <div class="container mt-5">
            <div class="row">
                <!--Show Departure Schedule Card-->
                <?php

                // Define a mapping of directions to components
                $componentMap = [
                    'One-Way' => ['../components/seats/departure-schedule.php'],
                    'Round-Trip' => [
                        '../components/seats/departure-schedule.php',
                        '../components/seats/arrival-schedule.php'
                    ]
                ];

                // Load components based on the direction
                if (array_key_exists($direction, $componentMap)) {
                    foreach ($componentMap[$direction] as $component) {
                        require $component; // Load each component dynamically
                    }
                } else {
                    // Optionally handle cases where the direction is unknown
                    echo 'Invalid direction provided.';
                }
                ?>


            </div>
        </div>


        <?php

        // Define a mapping of directions to components
        $componentMap = [
            'One-Way' => ['../modal/pick-seat-departure.php'],
            'Round-Trip' => [
                '../modal/pick-seat-departure.php',
                '../modal/pick-seat-arrival.php'
            ]
        ];

        // Load components based on the direction
        if (array_key_exists($direction, $componentMap)) {
            foreach ($componentMap[$direction] as $component) {
                require $component; // Load each component dynamically
            }
        } else {
            // Optionally handle cases where the direction is unknown
            echo 'Invalid direction provided.';
        }
        ?>


        <!-- Navigation Buttons -->
        <div class="row mt-4">
            <div class="col-6">
                <a href="schedules.php" class="btn btn-outline-primary btn-block">Back to Step 2</a>
            </div>
            <div class="col-6 text-right">
                <a href="summary.php" class="btn btn-primary btn-block">Next</a>
            </div>
        </div>
    </div>

    <?php
    include '../components/footer.php'
        ?>
</body>


<!-- Save Departure Seats -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const saveButton = document.querySelector('.save-button-container .save-departure');
        const maxSeats = <?php echo $passenger; ?>;

        saveButton.addEventListener('click', function () {
            // Get all selected seats
            const selectedSeats = [];
            document.querySelectorAll('.seat-checkbox:checked').forEach(checkbox => {
                selectedSeats.push(checkbox.value);
            });

            // Check if the number of selected seats matches the required number of passengers
            if (selectedSeats.length !== maxSeats) {
                alert(`Please select exactly ${maxSeats} seats.`);
                return;
            }

            // Send the selected seats to the server via AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../api/store-departure-seats.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        console.log('Server response:', response);

                        if (response.success) {
                            alert('Seats saved successfully!');

                            // Deselect all checkboxes once saved successfully
                            document.querySelectorAll('.seat-checkbox:checked').forEach(checkbox => {
                                checkbox.checked = false;
                            });

                            console.log('All checkboxes have been deselected.');


                        } else {
                            alert('Failed to save seats. Please try again.');
                        }
                    } catch (e) {
                        console.log('Failed to parse JSON:', e);
                        console.log('Raw response:', xhr.responseText);
                        alert('An unexpected error occurred.');
                    }
                } else {
                    console.log('Request failed with status:', xhr.status);
                }
            };

            xhr.onerror = function () {
                console.log('Request error:', xhr.statusText);
            };

            xhr.send('departure_seats=' + JSON.stringify(selectedSeats));
        });
    });
</script>

<!-- Save Arrival Seats -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const saveButton = document.querySelector('.save-button-container .save-arrival');
        const maxSeats = <?php echo $passenger; ?>;

        saveButton.addEventListener('click', function () {
            // Get all selected seats
            const selectedSeats = [];
            document.querySelectorAll('.seat-checkbox:checked').forEach(checkbox => {
                selectedSeats.push(checkbox.value);
            });

            // Check if the number of selected seats matches the required number of passengers
            if (selectedSeats.length !== maxSeats) {
                alert(`Please select exactly ${maxSeats} seats.`);
                return;
            }

            // Send the selected seats to the server via AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../api/store-arrival-seats.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        console.log('Server response:', response);

                        if (response.success) {
                            alert('Seats saved successfully!');

                            // Deselect all checkboxes once saved successfully
                            document.querySelectorAll('.seat-checkbox:checked').forEach(checkbox => {
                                checkbox.checked = false;
                            });

                            console.log('All checkboxes have been deselected.');

                        } else {
                            alert('Failed to save seats. Please try again.');
                        }
                    } catch (e) {
                        console.log('Failed to parse JSON:', e);
                        console.log('Raw response:', xhr.responseText);
                        alert('An unexpected error occurred.');
                    }
                } else {
                    console.log('Request failed with status:', xhr.status);
                }
            };

            xhr.onerror = function () {
                console.log('Request error:', xhr.statusText);
            };

            xhr.send('arrival_seats=' + JSON.stringify(selectedSeats));
        });
    });
</script>

</html>