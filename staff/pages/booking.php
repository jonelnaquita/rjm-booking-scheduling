<!DOCTYPE html>
<html lang="en">
<?php
include '../api/session.php';
include '../../models/conn.php';
include '../components/header.php';
?>

<head>

    <link rel="stylesheet" href="../../admin/assets/css/destination-tab.css">
    <link rel="stylesheet" href="../../admin/assets/css/theme.css">
    <link rel="stylesheet" href="../../admin/assets/css/booking.css">


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
                    <h3 class="tab-title">Bookings</h3>

                    <div class="row filter-field" id="filter-field" style="margin-bottom: 20px;">
                        <div class="col-12 col-md-auto mt-2 mt-md-0">
                            <div class="row">
                                <div class="col">
                                    <select class="form-select form-select-sm" id="direction-filter">
                                        <option value="" selected>Filter by Direction</option>
                                        <option value="Departure">Departure</option>
                                        <option value="Arrival">Arrival</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-auto mb-2 mb-md-0">
                            <div class="row gx-2 align-items-center">
                                <div class="col">
                                    <!-- Date Picker -->
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm"
                                            placeholder="Select Date" id="datepicker">
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Time Picker -->
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm"
                                            placeholder="Select Time" id="timepicker">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dropdown Menu -->
                        <div class="col-12 col-md-auto mt-2 mt-md-0">
                            <div class="row">
                                <div class="col">
                                    <select class="form-select form-select-sm" id="bus-filter">
                                        <option value="">Filter by Bus</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Clear Button -->
                        <div class="col-12 col-md-auto mt-2 mt-md-0">
                            <button id="clear-filters" class="btn btn-sm btn-secondary text-light">Clear
                                Filters</button>
                        </div>
                    </div>


                    <div class="table-responsive ">
                        <table id="table-example" class="table table-data2 nowrap dt-responsive w-100"
                            style="margin-top: 20px; margin-bottom: 20px;">
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
                                include '../api/booking/fetch-booking-list.php';
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE -->
                </div>


                <!--Include Footer -->
                <?php
                include '../components/footer.php';
                include '../modal/booking-modal.php';
                ?>

            </div>
        </div>
    </div>
</body>

<script>
    // Function to update booking statuses
    function updateCancelledBookings() {
        $.ajax({
            url: '../../admin/api/booking/cancel-past-booking.php', // PHP script path
            type: 'POST',
            data: { action: 'updateCancelledBookings' }, // Optional data if needed
            success: function (response) {
                console.log(response); // Log the response
            },
            error: function (xhr, status, error) {
                console.error('Error updating booking statuses:', xhr.responseText); // Log detailed error response
            }
        });
    }

    // Call the function when the document is ready
    $(document).ready(function () {
        updateCancelledBookings();
    });
</script>


<script>
    $(document).on('click', '.btn-accept', function () {
        // Get the booking ID from the data-book-id attribute
        var book_id = $(this).data('book-id');

        // Log the booking ID to ensure it's being retrieved correctly
        console.log('Booking ID:', book_id);

        // Send AJAX request to fetch payment details
        $.ajax({
            url: '../api/booking/get-payment-details.php', // Adjust path to your API
            type: 'POST',
            data: { book_id: book_id },
            dataType: 'json',
            success: function (response) {
                console.log('AJAX response:', response); // Log the response to check the data

                if (response.success) {
                    // Populate the modal with the fetched details
                    var modalBody = `
                    <h2 class="modal-total-amount">Total Amount: ₱${response.data.price}</h2>
                    <h5 class="modal-reference-number">Reference Number: ${response.data.reference_number}</h5>
                    <img src="../../src/payment/${response.data.screenshot_filename}" alt="Screenshot" class="modal-screenshot img-fluid" />
                `;
                    $('#accept-booking-modal .modal-body').html(modalBody);

                    $('#confirm-booking-modal .booking_id').val(book_id);
                    $('#confirm-booking-modal .passenger-id').html(book_id);
                } else {
                    alert('No payment details found.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // Log the full error details for debugging
                console.error('Error fetching payment details:', textStatus, errorThrown);
                console.log('Response text:', jqXHR.responseText);
            }
        });
    });

</script>

<!-- Confirm Booking -->
<script>
    $('#confirmBooking').on('click', function () {
        let bookingId = $('.booking_id').val(); // Get the booking ID
        let confirmBtn = $(this); // Reference to the button

        console.log('Booking ID:', bookingId); // Log the booking ID

        // Disable the button and show a loading spinner inside it
        confirmBtn.prop('disabled', true);
        confirmBtn.html('Confirming <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

        // Perform the AJAX request
        $.ajax({
            url: '../api/booking/confirm-booking.php',
            type: 'POST',
            data: { booking_id: bookingId },
            dataType: 'json', // Expect JSON response
            success: function (response) {
                console.log('Success response:', response); // Log the success response

                // Close the modal
                $('#confirm-booking-modal').modal('hide');

                if (response.success) {
                    // Show a success toastr message
                    toastr.success(response.message || 'Booking confirmed and e-ticket sent successfully!', 'Success');

                    // Reload the page after a short delay
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    // Show an error toastr message
                    toastr.error(response.message || 'An error occurred. Please try again.', 'Error');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', xhr.responseText); // Log the error response

                // Close the modal in case of error
                $('#confirm-booking-modal').modal('hide');

                // Show an error toastr message
                toastr.error('An error occurred. Please try again.', 'Error');
            },
            complete: function () {
                // Re-enable the button and remove the spinner
                confirmBtn.prop('disabled', false);
                confirmBtn.html('Confirm');
            }
        });
    });
</script>

<!--Cancel Booking-->
<script>
    $(document).on('click', '.btn-cancel', function () {
        var book_id = $(this).data('book-id');

        // Log the booking ID to ensure it's being retrieved correctly
        console.log('Booking ID:', book_id);

        // Prepare the form HTML with a select dropdown for cancellation reasons
        var formHtml = `
      <div class="form-group">
        <label for="cancellation-reason">Reason for Cancellation</label>
        <select class="form-select" id="cancellation-reason" name="cancellation_reason" required>
          <option value="" selected disabled>Select Reason</option>
          <option value="Payment Not Confirmed">Payment Not Confirmed</option>
          <option value="Change Schedule">Change Schedule</option>
          <option value="Vehicle Maintenance Issues">Vehicle Maintenance Issues</option>
          <option value="Low Passenger Count">Low Passenger Count</option>
          <option value="Adverse Weather Conditions">Adverse Weather Conditions</option>
          <option value="Traffic Restrictions">Traffic Restrictions</option>
          <option value="Route Closure or Detour">Route Closure or Detour</option>
          <option value="System Error or Double Booking">System Error or Double Booking</option>
          <option value="Other">Other</option>
        </select>
      </div>
    `;

        // Insert the form into the modal body
        $('#cancel-booking-modal .modal-body').html(formHtml);

        // Set the booking ID into the hidden input in the confirm modal
        $('#confirm-cancel-modal .booking-id').val(book_id);
        $('#confirm-cancel-modal .passenger-id').html(book_id);
    });

    // Capture the selected cancellation reason and transfer it to the confirm modal
    $(document).on('change', '#cancellation-reason', function () {
        var selectedReason = $(this).val(); // Get the selected reason
        console.log('Selected Reason:', selectedReason);

        // Set the selected reason into the hidden input in the confirm modal
        $('#confirm-cancel-modal .cancel-reason').val(selectedReason);
    });
</script>

<script>
    $(document).on('click', '#confirmCancel', function () {
        var bookingId = $('.booking-id').val(); // Get the booking ID from the modal
        var cancellationReason = $('#confirm-cancel-modal .cancel-reason').val(); // Get the selected cancellation reason
        var confirmBtn = $(this); // Reference to the button

        // Disable the button and show a loading spinner inside it
        confirmBtn.prop('disabled', true);
        confirmBtn.html('Cancelling <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

        $.ajax({
            url: '../api/booking/cancel-booking.php', // PHP file to handle the cancellation
            type: 'POST',
            data: {
                booking_id: bookingId,
                cancellation_reason: cancellationReason
            },
            success: function (response) {
                // Show a success toastr message
                toastr.success(response, 'Success');

                // Reload the page after a short delay
                setTimeout(function () {
                    location.reload();
                }, 1000);

                $('#cancel-booking-modal').modal('hide'); // Close the cancel modal
                $('#confirm-cancel-modal').modal('hide'); // Close the confirm modal
            },
            error: function (xhr, status, error) {
                toastr.error(xhr, 'Error');

                // Re-enable the button and restore the original text in case of an error
                confirmBtn.prop('disabled', false);
                confirmBtn.html('Confirm');
            }
        });
    });
</script>


<!--Filter-->
<script type="text/javascript">
    $(function () {
        // Initialize time picker and store its instance
        const timePickerInstance = $("#timepicker").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
            time_24hr: false,
        });

        // Initialize date picker and store its instance
        const datePickerInstance = $("#datepicker").flatpickr({
            altInput: true,
            dateFormat: "F j, Y"
        });

        // Clear filter inputs when "Clear Filters" button is clicked
        $('#clear-filters').on('click', function () {
            // Clear all filters
            $('#direction-filter').val('');  // Reset direction filter
            datePickerInstance.clear();      // Clear date picker using Flatpickr's clear method
            timePickerInstance.clear();      // Clear time picker using Flatpickr's clear method
            $('#bus-filter').val('');        // Reset bus filter

            // Trigger the redraw of the DataTable
            $('#table-example').DataTable().draw();
        });
    });
</script>


<script>
    $(document).ready(function () {
        // Fetch all bus numbers when the page loads
        $.ajax({
            url: '../api/booking/fetch-buses.php', // Adjust the URL to your actual path
            type: 'GET',
            dataType: 'json', // Expecting a JSON response
            success: function (response) {
                if (response.success) {
                    var buses = response.data; // Assuming the bus numbers are in the 'data' field
                    var $busFilter = $('#bus-filter');

                    // Clear the dropdown first
                    $busFilter.empty();

                    // Add the default option
                    $busFilter.append('<option value="">Filter by Bus</option>');

                    // Loop through each bus and append as options
                    buses.forEach(function (bus) {
                        $busFilter.append('<option value="' + bus.bus_id + '">' + bus.bus_number + '</option>');
                    });
                } else {
                    console.error('Failed to fetch buses:', response.error);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching buses:', error);
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        // Initialize DataTable
        var table = $('#table-example').DataTable({
            "aLengthMenu": [[10, 25, -1], [10, 25, 50, "All"]],
            "iDisplayLength": 10
        });


        // Event listener for Date Picker
        $('#datepicker').on('keyup change', function () {
            table.draw(); // Redraw the table on change
        });

        // Event listener for Time Picker
        $('#timepicker').on('keyup change', function () {
            table.draw(); // Redraw the table on change
        });

        // Event listener for Bus Filter Dropdown
        $('#bus-filter').on('change', function () {
            table.draw(); // Redraw the table on change
        });

        $('#direction-filter').on('change', function () {
            table.draw();
        })

        // Custom filtering function for DataTable
        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            var selectedDate = $('#datepicker').val().trim();  // Get the date from the Date Picker
            var selectedTime = $('#timepicker').val().trim();  // Get the time from the Time Picker
            var selectedBus = $('#bus-filter').val().trim();   // Get the bus from the Bus Filter
            var selectedDirection = $('#direction-filter').val().trim();

            // Assuming the Date is in the 5th column, Time in the 5th (part of Schedule), and Bus in the 6th
            var tableSchedule = data[4].trim(); // Column 5 for Schedule (Date and Time)
            var tableBus = data[5].trim();      // Column 6 for Bus

            // Check Date filter
            if (selectedDate && tableSchedule.indexOf(selectedDate) === -1) {
                return false;
            }

            // Check Time filter (optional: handle combined date and time or separate time)
            if (selectedTime && tableSchedule.indexOf(selectedTime) === -1) {
                return false;
            }

            // Check Bus filter
            if (selectedBus && tableBus.indexOf(selectedBus) === -1) {
                return false;
            }

            if (selectedDirection && tableSchedule.indexOf(selectedDirection) === -1) {
                return false;
            }

            return true; // If all filters pass, show the row
        });
    });
</script>


</html>