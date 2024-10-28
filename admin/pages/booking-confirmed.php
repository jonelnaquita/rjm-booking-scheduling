<!DOCTYPE html>
<html lang="en">
<?php
    include '../api/session.php';
    include '../../models/conn.php';
    include '../components/header.php';
?>

<head>

    <link rel="stylesheet" href="../assets/css/destination-tab.css">
    <link rel="stylesheet" href="../assets/css/seats.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
</head>
<body>

    <div class="container-scroller">
        <!--Include Navigation Bar-->
        <?php include '../components/navbar.php'; ?>
        <!--End-->

        <div class="container-fluid page-body-wrapper">
            <!-- Include Sidebar-->
            <?php
                include '../components/sidebar.php';
            ?>


            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- Tab Indicator or Title -->
                    <h3 class="tab-title">Confirmed Bookings</h3>
                    <div class="table-responsive ">
                            <table id="table-example" class="table table-data2 nowrap dt-responsive w-100" style="margin-top: 20px; margin-bottom: 20px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Book ID</th>
                                        <th>Full Name</th>
                                        <th>Destination</th>
                                        <th>Schedule</th>
                                        <th>Bus</th>
                                        <th>Travel Cost</th>
                                        <th>Passengers</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        include '../api/booking/fetch-booking-confirmed.php';
                                    ?>
                                </tbody>
                            </table>
                        </div>
                </div>


            <!--Include Footer -->
            <?php
                include '../components/footer.php';
                include '../modal/booking-modal.php';
                include '../modal/pick-seat.php';
            ?>

            </div>
        </div>
      <!-- page-body-wrapper ends -->
    </div>
</body>

<script>
    $(document).ready(function(){
        var table = $('#table-example').DataTable({
            "aLengthMenu": [[10, 25, -1], [10, 25, 50, "All"]],
            "iDisplayLength": 10
        });
    })
</script>


<script>
$(document).ready(function() {
    var bookingId;

    // When the Re-schedule button is clicked, get the booking ID and load the booking details
    $('#reschedule-booking').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        bookingId = button.data('book-id');

        // Fetch the booking details via AJAX
        $.ajax({
            url: '../api/booking/fetch-booking-details.php',
            type: 'POST',
            data: { booking_id: bookingId },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    var booking = result.booking;

                    // Populate the Departure fields
                    $('#booking-id').val(bookingId);
                    $('#departure-destination-from').val(booking.departure_from);
                    $('#departure-destination-to').val(booking.departure_to);
                    $('#departure-bus').val(booking.departure_bus);
                    $('#departure-destination-text').text(booking.destination_departure);
                    $('#arrival-destination-text').text(booking.destination_arrival);

                    // Check if trip type is "Round-Trip"
                    if (booking.trip_type === "Round-Trip") {
                        // Show the arrival card and populate the fields
                        $('.arrival-card').show();
                        $('#arrival-destination-from').val(booking.arrival_from);
                        $('#arrival-destination-to').val(booking.arrival_to);
                        $('#arrival-bus').val(booking.arrival_bus);
                        $('#departure-destination-text2').text(booking.destination_arrival);
                        $('#arrival-destination-text2').text(booking.destination_departure);
                    } else {
                        // Hide the arrival card for one-way trips
                        $('.arrival-card').hide();
                    }

                    // Fetch available dates for departure
                    fetchAvailableDates(booking.departure_from, booking.departure_to, booking.departure_bus, '#departure-datepicker');

                    // Fetch available dates for arrival if it's a round trip
                    if (booking.trip_type === "Round-Trip") {
                        fetchAvailableDates(booking.arrival_from, booking.arrival_to, booking.arrival_bus, '#arrival-datepicker');
                    }
                } else {
                    console.log('Error: ' + result.message);
                }
            },
            error: function(xhr, status, error) {
                console.log('Error Status:', status);
                console.log('Error Thrown:', error);
                console.log('XHR Response:', xhr.responseText);
                alert('An error occurred while fetching booking details.');
            }
        });
    });

    // Function to fetch available dates
    function fetchAvailableDates(destinationFrom, destinationTo, busType, datePickerId) {
        $.ajax({
            url: '../api/booking/fetch-available-dates.php',
            type: 'POST',
            data: {
                destination_from: destinationFrom,
                destination_to: destinationTo,
                bus_type: busType
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const availableDates = response.dates;
                    
                    // Destroy existing datepicker
                    $(datePickerId).datepicker('destroy');
                    
                    // Reinitialize datepicker with new options
                    $(datePickerId).datepicker({
                        format: 'yyyy-mm-dd',
                        autoclose: true,
                        todayHighlight: true,
                        beforeShowDay: function(date) {
                            // Adjust the date to local timezone
                            const localDate = new Date(date.getTime() - date.getTimezoneOffset() * 60000);
                            const formattedDate = localDate.toISOString().split('T')[0];
                            if (availableDates.indexOf(formattedDate) !== -1) {
                                return {
                                    enabled: true,
                                    classes: 'available-date',
                                    tooltip: 'Available'
                                };
                            } else {
                                return {
                                    enabled: false,
                                    classes: 'unavailable-date',
                                    tooltip: 'Unavailable'
                                };
                            }
                        }
                    });

                } else {
                    console.error('Error: ', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ', error);
                console.error('Response Text: ', xhr.responseText);
                console.error('Status: ', status);
                alert('An error occurred while fetching available dates. Please try again.');
            }
        });
    }
});
</script>

<!--Populate Schedule-->
<script>
    $(document).ready(function() {
    $('#departure-datepicker').on('change', function() {
        var date = $(this).val();
        var destinationFrom = $('#departure-destination-from').val();
        var destinationTo = $('#departure-destination-to').val();
        var busType = $('#departure-bus').val();

        $.ajax({
            url: '../api/booking/fetch-schedule.php',
            type: 'POST',
            data: {
                date: date,
                destination_from: destinationFrom,
                destination_to: destinationTo,
                bus_type: busType
            },
            success: function(response) {
                $('#schedule-table-body').html(response);
            }
        });
    });

    $('#arrival-datepicker').on('change', function() {
        var date = $(this).val();
        var destinationFrom = $('#arrival-destination-from').val();
        var destinationTo = $('#arrival-destination-to').val();
        var busType = $('#arrival-bus').val();

        $.ajax({
            url: '../api/booking/fetch-schedule.php',
            type: 'POST',
            data: {
                date: date,
                destination_from: destinationFrom,
                destination_to: destinationTo,
                bus_type: busType
            },
            success: function(response) {
                $('#arrival-table-body').html(response);
            }
        });
    });
});

</script>

<script>
$(document).ready(function () {
    // Event delegation for dynamic elements
    $(document).on('click', '.btn-book', function () {
        var $button = $(this);  // Store reference to the clicked button
        var scheduleId = $button.data('id');  // Get the schedule_id from data-id
        
        // Disable the clicked button
        $button.prop('disabled', true).text('Selected');
        
        // Enable all other buttons in the same table
        $button.closest('tbody').find('.btn-book').not($button).prop('disabled', false).text('Select');
        
        // Check if this is for departure or arrival based on the table it was clicked in
        if ($button.closest('tbody').attr('id') === 'schedule-table-body') {
            $('#departure-schedule-id').val(scheduleId);  // Set schedule ID in the departure input field
        } else if ($button.closest('tbody').attr('id') === 'arrival-table-body') {
            $('#arrival-schedule-id').val(scheduleId);  // Set schedule ID in the arrival input field
        }
    });
});
</script>

<!--Update Booking / Reschedule -->
<script>
$(document).ready(function () {
    // When the confirm button is clicked
    $('.submit-reschedule').on('click', function () {
        var $button = $(this);
        var bookingId = $('#booking-id').val();
        var departureScheduleId = $('#departure-schedule-id').val();
        var arrivalScheduleId = $('#arrival-schedule-id').val();
        var departureSeats = $('#departure-seat-number').val();
        var arrivalSeats = $('#arrival-seat-number').val(); // Fixed variable name
        var isArrivalCardShown = $('.arrival-card').is(':visible');

        // Validate departure schedule ID
        if (!departureScheduleId) {
            alert('Please select a departure schedule.');
            return;
        }

        if (!departureSeats) {
            alert('Please select seats for departure.');
            return;
        }

        // Validate arrival schedule ID if arrival card is shown
        if (isArrivalCardShown && !arrivalScheduleId) {
            alert('Please select both departure and arrival schedules.');
            return;
        }

        if (isArrivalCardShown && !arrivalSeats) {
            alert('Please select both departure and arrival seats.');
            return;
        }

        // Disable the button and show loading text
        $button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');

        $.ajax({
            url: '../api/booking/update-schedule.php',
            type: 'POST',
            data: {
                booking_id: bookingId,
                departure_schedule_id: departureScheduleId,
                arrival_schedule_id: arrivalScheduleId,
                departure_seats: departureSeats,
                arrival_seats: arrivalSeats // Correct variable name
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    toastr.success('Booking updated successfully!', 'Success');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    alert('Error: ' + response.message);
                    console.error('Server error:', response.message);
                }
            },
            error: function (xhr, status, error) {
                alert('An error occurred while updating the booking.');
                console.error('AJAX error:', status, error);
                console.error('Response:', xhr.responseText);
            },
            complete: function () {
                // Always re-enable the button and reset the text
                $button.prop('disabled', false).text('Confirm');
            }
        });
    });
});
</script>



<!-- Pick Departure Seat -->
<script>
    $(document).on('click', '.pick-seat-btn', function (event) {
        // Prevent default action
        event.preventDefault();
        
        var schedule_id = $('#departure-schedule-id').val();  // Get schedule ID
        var booking_id = $('#booking-id').val();  // Get booking ID from hidden input

        // Reset seat grid and any previous data
        $('.seat-grid').html('');  // Clear seat grid
        $('.loading').remove();    // Remove any existing loading animation

        // Fetch number of passengers and total seats based on schedule ID and booking ID
        $.ajax({
            url: '../api/booking/fetch-available-seats.php',  // PHP script to handle seat fetching
            type: 'POST',
            data: { 
                schedule_id: schedule_id,
                booking_id: booking_id
            },
            dataType: 'json',
            beforeSend: function() {
                // Show a loading animation
                $('.seat-grid').html('<div class="loading">Loading seats...</div>');
            },
            success: function (data) {
                // Clear the seat grid
                $('.seat-grid').empty();

                // Retrieve the number of passengers and total seats from the response
                var passengerCount = data.passenger_count;
                var totalSeats = data.total_seats;

                $('#passenger-count').val(data.passenger_count);

                // Iterate through each seat and determine its status
                for (var i = 1; i <= totalSeats; i++) {
                    // Handle normal rows with 4 seats (2 pairs per row)
                    if (i <= 40) {
                        if (i % 4 === 1) {
                            // Start a new row for every 4 seats
                            $('.seat-grid').append('<div class="seat-row row">');
                        }

                        // Check if the seat is booked or available
                        var statusClass = '';  // Default for available
                        var disabled = '';     // Default for available
                        if (data.seats[i] === 'Pending') {
                            statusClass = 'pending-seat';
                            disabled = 'disabled';
                        } else if (data.seats[i] === 'Confirmed') {
                            statusClass = 'confirmed-seat';
                            disabled = 'disabled';
                        }

                        // Append seat with appropriate status and styling
                        $('.seat-grid').append(`
                            <div class="seat-pair">
                                <label class="seat ${statusClass}">
                                    <input type="checkbox" name="seat[]" value="${i}" class="seat-checkbox" ${disabled}>
                                    <span class="seat-number">${i}</span>
                                </label>
                            </div>
                        `);

                        // Close the row after every 4 seats (2 pairs)
                        if (i % 4 === 0) {
                            $('.seat-grid').append('</div>');
                        }
                    }
                    
                    // Handle the last row with 5 seats
                    if (i > 40) {
                        if (i === 41) {
                            // Start a new row for the last 5 seats
                            $('.seat-grid').append('<div class="seat-row row last-row">');
                        }

                        var statusClass = '';  // Default for available
                        var disabled = '';     // Default for available
                        if (data.seats[i] === 'Pending') {
                            statusClass = 'pending-seat';
                            disabled = 'disabled';
                        } else if (data.seats[i] === 'Confirmed') {
                            statusClass = 'confirmed-seat';
                            disabled = 'disabled';
                        }

                        // Append the seat for the last row
                        $('.seat-grid').append(`
                            <div class="seat-pair">
                                <label class="seat ${statusClass}">
                                    <input type="checkbox" name="seat[]" value="${i}" class="seat-checkbox" ${disabled}>
                                    <span class="seat-number">${i}</span>
                                </label>
                            </div>
                        `);

                        // Close the row after seat 45 (last seat)
                        if (i === 45) {
                            $('.seat-grid').append('</div>');
                        }
                    }
                }

                // Hide loading animation
                $('.loading').remove();

                // Apply seat selection limit based on passenger count
                applySeatLimit(passengerCount);
                
                // Show the pick-seat modal without hiding the reschedule-booking modal
                $('#departure-pick-seat').modal('show');
            },
            error: function (xhr, status, error) {
                console.error('Error fetching seats:', error);
            }
        });
    });

    // Function to limit the number of seat selections based on passenger count
    function applySeatLimit(maxSeats) {
        // Unbind any existing event to avoid multiple bindings
        $(document).off('change', '.seat-checkbox').on('change', '.seat-checkbox', function() {
            var selectedSeats = $('.seat-checkbox:checked').length;

            if (selectedSeats > maxSeats) {
                this.checked = false; // Uncheck the seat if the limit is exceeded
                alert('You can only select up to ' + maxSeats + ' seats.');
            }
        });
    }

    // Add event listener for saving selected seats
    $(document).on('click', '.departure-save-seats', function() {
        var selectedSeats = []; // Array to hold selected seat numbers

        // Loop through each checked seat checkbox and push the seat number to the array
        $('.seat-checkbox:checked').each(function() {
            selectedSeats.push($(this).val());
        });

        // Check if the number of selected seats matches the passenger count
        var passengerCount = parseInt($('#passenger-count').val()); // Assuming you have a hidden input for passenger count
        if (selectedSeats.length !== passengerCount) {
            alert('You must select exactly ' + passengerCount + ' seats.');
            return; // Stop if the number of selected seats does not match the passenger count
        }

        if (selectedSeats.length === 0) {
            alert('Please select at least one seat.');
            return; // Stop if no seats are selected
        }

        // Place the selected seat numbers into the `departure-seat-number` input field
        $('#departure-seat-number').val(selectedSeats.join(', ')); // Join seat numbers with a comma and space
    });

    // Function to toggle the disabled state of the buttons
    function toggleButtonState() {
        const departureInput = document.getElementById('departure-schedule-id');
        const arrivalInput = document.getElementById('arrival-schedule-id');
        
        const departureButton = document.querySelector('.pick-seat-btn');
        const arrivalButton = document.querySelector('.arrival-pick-seat-btn');

        // Check if the departure input is empty
        departureButton.disabled = departureInput.value.trim() === '';

        // Check if the arrival input is empty
        if (arrivalButton) {
            arrivalButton.disabled = arrivalInput.value.trim() === '';
        }
    }

    // Add event listeners to the input fields
    document.getElementById('departure-schedule-id').addEventListener('input', toggleButtonState);

    const arrivalInput = document.getElementById('arrival-schedule-id');
    if (arrivalInput) {
        arrivalInput.addEventListener('input', toggleButtonState);
    }

    // Initial check to set the correct state on page load
    toggleButtonState();

    // Add event listener to update button states when schedules are selected
    $(document).on('click', '.btn-book', function() {
        // Wait for the next tick to ensure the input values are updated
        setTimeout(toggleButtonState, 0);
    });
</script>


<!-- Pick Arrival Seat -->
<script>
    $(document).on('click', '.arrival-pick-seat-btn', function (event) {
        // Prevent default action
        event.preventDefault();
        
        var schedule_id = $('#arrival-schedule-id').val();  // Get schedule ID
        var booking_id = $('#booking-id').val();  // Get booking ID from hidden input

        // Reset seat grid and any previous data
        $('.seat-grid').html('');  // Clear seat grid
        $('.loading').remove();    // Remove any existing loading animation

        // Fetch number of passengers and total seats based on schedule ID and booking ID
        $.ajax({
            url: '../api/booking/fetch-available-seats.php',  // PHP script to handle seat fetching
            type: 'POST',
            data: { 
                schedule_id: schedule_id,
                booking_id: booking_id
            },
            dataType: 'json',
            beforeSend: function() {
                // Show a loading animation
                $('.seat-grid').html('<div class="loading">Loading seats...</div>');
            },
            success: function (data) {
                // Clear the seat grid
                $('.seat-grid').empty();

                // Retrieve the number of passengers and total seats from the response
                var passengerCount = data.passenger_count;
                var totalSeats = data.total_seats;

                $('#passenger-count').val(data.passenger_count);

                // Iterate through each seat and determine its status
                for (var i = 1; i <= totalSeats; i++) {
                    // Handle normal rows with 4 seats (2 pairs per row)
                    if (i <= 40) {
                        if (i % 4 === 1) {
                            // Start a new row for every 4 seats
                            $('.seat-grid').append('<div class="seat-row row">');
                        }

                        // Check if the seat is booked or available
                        var statusClass = '';  // Default for available
                        var disabled = '';     // Default for available
                        if (data.seats[i] === 'Pending') {
                            statusClass = 'pending-seat';
                            disabled = 'disabled';
                        } else if (data.seats[i] === 'Confirmed') {
                            statusClass = 'confirmed-seat';
                            disabled = 'disabled';
                        }

                        // Append seat with appropriate status and styling
                        $('.seat-grid').append(`
                            <div class="seat-pair">
                                <label class="seat ${statusClass}">
                                    <input type="checkbox" name="seat[]" value="${i}" class="seat-checkbox" ${disabled}>
                                    <span class="seat-number">${i}</span>
                                </label>
                            </div>
                        `);

                        // Close the row after every 4 seats (2 pairs)
                        if (i % 4 === 0) {
                            $('.seat-grid').append('</div>');
                        }
                    }
                    
                    // Handle the last row with 5 seats
                    if (i > 40) {
                        if (i === 41) {
                            // Start a new row for the last 5 seats
                            $('.seat-grid').append('<div class="seat-row row last-row">');
                        }

                        var statusClass = '';  // Default for available
                        var disabled = '';     // Default for available
                        if (data.seats[i] === 'Pending') {
                            statusClass = 'pending-seat';
                            disabled = 'disabled';
                        } else if (data.seats[i] === 'Confirmed') {
                            statusClass = 'confirmed-seat';
                            disabled = 'disabled';
                        }

                        // Append the seat for the last row
                        $('.seat-grid').append(`
                            <div class="seat-pair">
                                <label class="seat ${statusClass}">
                                    <input type="checkbox" name="seat[]" value="${i}" class="seat-checkbox" ${disabled}>
                                    <span class="seat-number">${i}</span>
                                </label>
                            </div>
                        `);

                        // Close the row after seat 45 (last seat)
                        if (i === 45) {
                            $('.seat-grid').append('</div>');
                        }
                    }
                }

                // Hide loading animation
                $('.loading').remove();

                // Apply seat selection limit based on passenger count
                applySeatLimit(passengerCount);

                // Show the pick-seat modal without hiding the reschedule-booking modal
                $('#arrival-pick-seat').modal('show');
            },
            error: function (xhr, status, error) {
                console.error('Error fetching seats:', error);
            }
        });
    });

    // Function to limit the number of seat selections based on passenger count
    function applySeatLimit(maxSeats) {
        // Unbind any existing event to avoid multiple bindings
        $(document).off('change', '.seat-checkbox').on('change', '.seat-checkbox', function() {
            var selectedSeats = $('.seat-checkbox:checked').length;

            if (selectedSeats > maxSeats) {
                this.checked = false; // Uncheck the seat if the limit is exceeded
                alert('You can only select up to ' + maxSeats + ' seats.');
            }
        });
    }

    // Add event listener for saving selected seats
    $(document).on('click', '.arrival-save-seats', function() {
        var selectedSeats = []; // Array to hold selected seat numbers

        // Loop through each checked seat checkbox and push the seat number to the array
        $('.seat-checkbox:checked').each(function() {
            selectedSeats.push($(this).val());
        });

        // Check if the number of selected seats matches the passenger count
        var passengerCount = parseInt($('#passenger-count').val()); // Assuming you have a hidden input for passenger count
        if (selectedSeats.length !== passengerCount) {
            alert('You must select exactly ' + passengerCount + ' seats.');
            return; // Stop if the number of selected seats does not match the passenger count
        }

        if (selectedSeats.length === 0) {
            alert('Please select at least one seat.');
            return; // Stop if no seats are selected
        }

        // Place the selected seat numbers into the `departure-seat-number` input field
        $('#arrival-seat-number').val(selectedSeats.join(', ')); // Join seat numbers with a comma and space
    });

</script>











</html>