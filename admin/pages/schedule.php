<!DOCTYPE html>
<html lang="en">
<?php
    include '../api/session.php';
    include '../../models/conn.php';
    include '../components/header.php';
?>

<head>

    <link rel="stylesheet" href="../assets/css/destination-tab.css">
    <link rel="stylesheet" href="../assets/css/theme.css">

    <style>
        .highlight-red {
            background-color: #f8d7da; /* Light red background */
            color: #721c24;           /* Dark red text */
        }
    </style>
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
                    <h3 class="tab-title">Travel Schedules</h3>

                    <div class="row" style="margin-bottom: 20px;">
                        <!-- Left-aligned buttons -->
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary btn-rounded btn-icon-text" data-bs-toggle="modal" data-bs-target="#schedule-modal">
                                <i class="ti-plus btn-icon-prepend"></i> Add Schedule
                            </button>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-outline-info btn-rounded btn-icon" id="filter-button">
                                <i class="ti-filter"></i>
                            </button>
                        </div>

                        <!-- Right-aligned "Archive" button -->
                        <div class="col-auto ms-auto">
                            <a href="schedule-archives.php" type="button" class="btn btn-light btn-sm">
                                <i class="ti-archive"></i> Archive
                            </a>
                        </div>
                    </div>

                    <!-- Note about highlighted schedules -->
                    <p class="text-muted mt-2">
                        <i class="ti-info-alt text-warning"></i>
                        <span class="highlight-red px-1">Highlighted schedules</span> indicate a conflict with another schedule.
                    </p>

                    <!-- Line Separator -->
                    <hr>

                    <!-- Filter Row with Date Picker, Time Picker, and Dropdown Menu -->
                    <div class="row filter-field" id="filter-field" style="display: none; margin-bottom: 20px;">
                        <div class="col-12 col-md-auto mb-2 mb-md-0">
                            <div class="row gx-2 align-items-center">
                                <div class="col">
                                    <!-- Date Picker -->
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" placeholder="Select Date" id="datepicker">
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Time Picker -->
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" placeholder="Select Time" id="timepicker">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="table-responsive">
                        <table id="schedule-table" class="table table-hover" style="margin-top: 20px; margin-bottom: 20px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Destination</th>
                                    <th>Departure Date</th>
                                    <th>Departure Time</th>
                                    <th>Bus Number</th>
                                    <th>Bus Type</th>
                                    <th>Fare</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include '../api/schedule/fetch-schedule-table.php'; ?> <!-- Adjust the path to where you save this PHP code -->
                            </tbody>
                        </table>
                    </div>
                </div>


            <!--Include Footer -->
            <?php
                include '../components/footer.php';
                include '../modal/schedule-modal.php';
            ?>

            </div>
        </div>
      <!-- page-body-wrapper ends -->
    </div>
</body>

<script>
    $(document).ready(function() {
        new DataTable('#schedule-table', {
            paging: true,         // Enable pagination
            searching: true,      // Enable search box
            info: true            // Show "Showing X to Y of Z entries" information
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        // Toggle visibility of filter-field with animation when filter button is clicked
        $('#filter-button').on('click', function () {
            $('#filter-field').slideToggle(300); // Adjust the duration (300ms) as needed
        });
    });
</script>


<script type="text/javascript">
    $(function () {
        $("#timepicker").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
            time_24hr: false,
        });
    });
</script>

<script type="text/javascript">
    $(function () {
        $("#datepicker").flatpickr({
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
        });
    });
</script>

<script type="text/javascript">
    $(function () {
        $("#schedule-timepicker").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
            time_24hr: false,
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        // Function to get the current date in Manila timezone
        function getManilaDate(daysToAdd = 0) {
            // Manila timezone offset in minutes (UTC+8)
            const MANILA_OFFSET = 480;
            // Get the current date and time
            const now = new Date();
            // Convert current date to UTC
            const utcDate = new Date(now.getTime() - (now.getTimezoneOffset() * 60000));
            // Adjust to Manila time
            const manilaDate = new Date(utcDate.getTime() + (MANILA_OFFSET * 60000));
            // Add specified number of days (for max date or disabled dates)
            manilaDate.setDate(manilaDate.getDate() + daysToAdd);
            // Format the date to YYYY-MM-DD
            return manilaDate.toISOString().split('T')[0];
        }

        // Get the current date in Manila timezone and the next two days
        const disableDates = [
            getManilaDate(0),  // Disable today
            getManilaDate(1),  // Disable tomorrow
            getManilaDate(2)   // Disable the day after tomorrow
        ];

        // Initialize Flatpickr with date restrictions
        $("#schedule-datepicker").flatpickr({
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
            mode: "multiple",
            minDate: getManilaDate(0), // Disable all dates before today
            disable: disableDates,      // Disable the first 3 consecutive days
            defaultDate: getManilaDate(0) // Optional: Set default date to today
        });
    });
</script>


<!--Fetch Destination From-->
<script>
$(document).ready(function() {
    $('.destination-from').select2({
        dropdownParent: $('#schedule-modal'),
        width: '100%' // Ensure full width
    });

    $.ajax({
        url: '../api/schedule/fetch-destination-from.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var select = $('.destination-from');

            // Add a default empty option
            select.append('<option value="" selected disabled>Select Destination From</option>');

            $.each(data, function(index, destination) {
                select.append('<option value="' + destination.from_id + '">' + destination.destination_from + '</option>');
            });
        },
        error: function() {
            console.error('Error fetching destinations');
        }
    });
});
</script>


<script>
$(document).ready(function() {

    $('.destination-to').select2({
        dropdownParent: $('#schedule-modal'),
        width: '100%' // Ensure full width
    });

    // Event listener for when destination-from dropdown value changes
    $('.destination-from').on('change', function() {
        var from_id = $(this).val();
        
        // Check if from_id is valid
        if (from_id) {
            $.ajax({
                url: '../api/schedule/fetch-destination-to.php',
                type: 'POST',
                data: {from_id: from_id},
                dataType: 'json',
                success: function(data) {
                    var select = $('.destination-to');
                    select.empty(); // Clear existing options

                    // Add a default empty option
                    select.append('<option value="" selected disabled>Select Destination To</option>');

                    $.each(data, function(index, destination) {
                        select.append('<option value="' + destination.from_id + '">' + destination.destination_from + '</option>');
                    });
                    select.trigger('change'); // Update Select2
                },
                error: function() {
                    console.error('Error fetching destinations');
                }
            });
        } else {
            $('.destination-to').empty().trigger('change'); // Clear the dropdown if no from_id
        }
    });
});
</script>


<!-- Fetch Bus Number -->
<script>
$(document).ready(function() {
    // Initialize Select2 for bus-number dropdown (optional)
    $('.bus-number').select2({
        dropdownParent: $('#schedule-modal'), // If using a modal, adjust as needed
        width: '100%' // Ensure full width
    });

    // Fetch bus numbers on page load
    $.ajax({
        url: '../api/schedule/fetch-bus-number.php', // Path to your PHP script
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var select = $('.bus-number');
            select.empty(); // Clear existing options

            // Add a default empty option
            select.append('<option value="" selected disabled>Select a Bus Number</option>');

            $.each(data, function(index, bus) {
                select.append('<option value="' + bus.bus_id + '">' + bus.bus_number + '</option>');
            });
            select.trigger('change'); // Update Select2
        },
        error: function() {
            console.error('Error fetching bus numbers');
        }
    });
});
</script>

<!--Save Schedule -->

<script>
$(document).ready(function() {
    $('.save-schedule').on('click', function() {
        var from_id = $('.destination-from').val();
        var to_id = $('.destination-to').val();
        var departure_dates_str = $('#schedule-datepicker').val(); // String of selected dates
        var departure_time = $('#schedule-timepicker').val();
        var bus_id = $('.bus-number').val();
        var fare = $('.fare').val();

        var departure_dates = departure_dates_str.split(', '); // Array of selected dates

        // Validate that all fields are filled in
        if (!from_id || !to_id || !departure_dates.length || !departure_time || !bus_id || !fare) {
            toastr.info('Please fill in all fields before saving the schedule.');
            return;
        }

        var $saveButton = $('.save-schedule');
        $saveButton.prop('disabled', true);
        $saveButton.find('.spinner-border').removeClass('d-none');

        var formatted_dates = departure_dates.map(function(dateStr) {
            var date = new Date(dateStr.trim());
            var options = { year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }).join(', ');

        // Iterate through selected dates
        $.each(departure_dates, function(index, departure_date) {
            $.ajax({
                url: '../api/schedule/save-schedule.php',
                type: 'POST',
                data: {
                    from_id: from_id,
                    to_id: to_id,
                    departure_date: departure_date.trim(),
                    departure_time: departure_time,
                    bus_id: bus_id,
                    fare: fare
                },
                success: function(response) {
                    if (response === 'Schedule already exists.') {
                        toastr.error(`Schedule on ${departure_date} already exists!`);
                    } else {
                        toastr.success(`Schedule for ${departure_date} saved successfully.`);
                        // After saving, send email if it is a new schedule
                        sendEmailToStaff(bus_id, from_id, to_id, formatted_dates, departure_time);
                    }
                },
                error: function() {
                    alert('Error saving schedule for date: ' + departure_date);
                }
            });
        });

        setTimeout(function() {
            $saveButton.prop('disabled', false);
            $saveButton.find('.spinner-border').addClass('d-none');
            location.reload(); // Refresh after saving schedules
        }, 1000);
    });

    function sendEmailToStaff(bus_id, from_id, to_id, formatted_dates, departure_time) {
        $.ajax({
            url: '../api/schedule/get-staff-email.php',
            type: 'POST',
            data: { bus_id: bus_id },
            dataType: 'json',
            success: function(response) {
                if (response.email) {
                    $.ajax({
                        url: '../api/schedule/send-email.php',
                        type: 'POST',
                        data: {
                            email: response.email,
                            firstname: response.firstname,
                            from_id: from_id,
                            to_id: to_id,
                            departure_dates: formatted_dates,
                            departure_time: departure_time,
                            bus_id: response.bus_number
                        },
                        dataType: 'json',
                        success: function(emailResponse) {
                            if (emailResponse.success) {
                                console.log('Email notification sent to staff.');
                            } else {
                                alert('Error: ' + emailResponse.error);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Error sending email to staff: ' + error);
                        }
                    });
                } else {
                    alert('No staff email found for this bus.');
                }
            },
            error: function(xhr, status, error) {
                alert('Error retrieving staff email: ' + error);
            }
        });
    }
});

</script>



<!--Filter Table -->
<script>
$(document).ready(function() {
    function fetchSchedules() {
        // Get filter values
        var departureDate = $('#datepicker').val();
        var departureTime = $('#timepicker').val();
        $.ajax({
            url: '../api/schedule/filter-table.php', // PHP script to fetch filtered data
            type: 'POST',
            data: {
                departure_date: departureDate,
                departure_time: departureTime,
            },
            success: function(data) {
                // Update the table with filtered data
                $('#schedule-table tbody').html(data);
            },
            error: function() {
                console.error('Error fetching filtered data');
            }
        });
    }

    // Bind change events to filter inputs
    $('#datepicker, #timepicker').on('change', function() {
        fetchSchedules();
    });

});
</script>

<!--Archive Schedule-->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // AJAX request to archive schedules where departure_date is today
        function archiveSchedules() {
            fetch('../api/schedule/archive-schedules.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ action: 'archive' }) // Optional data to send
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Schedules successfully archived.');
                } else {
                    console.error('Error archiving schedules:', data.message);
                }
            })
            .catch(error => console.error('Error in the AJAX request:', error));
        }

        // Call the function to archive schedules when the page loads
        archiveSchedules();
    });
</script>

<!--Delete Schedule-->
<script>
    $(document).ready(function () {
    // When the delete button in the table is clicked, set the schedule ID to be deleted
    let scheduleIdToDelete;
    
    // Capture data-id when the modal opens
    $('#confirm-delete').on('show.bs.modal', function (e) {
        scheduleIdToDelete = $(e.relatedTarget).data('id');
    });

    // Handle the Delete button click in the modal
    $('#confirm-delete-btn').click(function () {
        $.ajax({
            url: '../api/schedule/delete-schedule.php', // The PHP file that handles the deletion
            type: 'POST',
            data: {
                schedule_id: scheduleIdToDelete // Pass the schedule ID to the PHP file
            },
            success: function (response) {
                if (response === 'success') {
                    toastr.success('Record deleted successfully!', 'Success')
                    setTimeout(function() {
                        location.reload(); // Refresh the page
                    }, 1000);
                } else {
                    toastr.danger('Failed to delete record.');

                }
            },
            error: function () {
                alert('Error while deleting the record.');
            }
        });

        // Close the modal after the deletion
        $('#confirm-delete').modal('hide');
    });
});
</script>

<!-- Edit: Populate the Existing Data -->
<script>
    // When the edit button is clicked
    $(document).on('click', '.edit-button', function() {
        var schedule_id = $(this).data('id'); // Get the schedule ID from the button

        // Show the modal
        $('#schedule-modal').modal('show');

        // Hide the destination fields by adding the 'd-none' class
        $('.destination-from').closest('.form-group').addClass('d-none');
        $('.destination-to').closest('.form-group').addClass('d-none');

        // Fetch existing schedule data via AJAX
        $.ajax({
            url: '../api/schedule/fetch-schedule.php',
            type: 'POST',
            data: {schedule_id: schedule_id},
            dataType: 'json',
            success: function(data) {
                // Populate the modal fields with fetched data
                $('.bus-number').val(data.bus_id).trigger('change');  // Populate the bus number
                
                // Reinitialize the datepicker with the fetched date
                $('#schedule-datepicker').flatpickr().destroy(); // Destroy the existing instance
                $('#schedule-datepicker').flatpickr({
                    altInput: true,
                    altFormat: "F j, Y",
                    dateFormat: "Y-m-d",
                    defaultDate: data.departure_date  // Set the departure date
                });

                $('#schedule-timepicker').val(data.departure_time);  // Set the departure time
                $('.fare').val(data.fare);  // Set the fare

                // Show the 'Edit Schedule' button and hide 'Save Schedule' button
                $('.save-schedule').addClass('d-none');
                $('.edit-schedule').removeClass('d-none');

                $('.add-header').addClass('d-none');
                $('.update-header').removeClass('d-none');

                // Store schedule_id in a hidden field if needed
                $('#schedule-modal').data('schedule-id', schedule_id);
            },
            error: function() {
                console.error('Error fetching schedule data');
            }
        });
    });

    // When the modal is closed, remove the 'd-none' class from the destination fields
    $('#schedule-modal').on('hidden.bs.modal', function() {
        // Clear the fields
        $('.bus-number').val('').trigger('change');
        $('#schedule-datepicker').flatpickr().clear();
        $('#schedule-timepicker').val('');
        $('.fare').val('');

        // Hide the destination fields
        $('.destination-from').closest('.form-group').removeClass('d-none');
        $('.destination-to').closest('.form-group').removeClass('d-none');

        $('.update-header').addClass('d-none');
        $('.add-header').removeClass('d-none');
    });
</script>


<!-- Update the Data -->
<script>
$(document).on('click', '.edit-schedule', function() {
    var schedule_id = $('#schedule-modal').data('schedule-id');  // Get the stored schedule ID
    var bus_id = $('.bus-number').val();
    var departure_date = $('#schedule-datepicker').val();
    var departure_time = $('#schedule-timepicker').val();
    var fare = $('.fare').val();

    // Validate form data (optional)
    if (!bus_id || !departure_date || !departure_time || !fare) {
        alert('Please fill all fields.');
        return; // Exit the function if validation fails
    }

    // Send the updated data via AJAX
    $.ajax({
        url: '../api/schedule/update-schedule.php',
        type: 'POST',
        data: {
            schedule_id: schedule_id,
            bus_id: bus_id,
            departure_date: departure_date,
            departure_time: departure_time,
            fare: fare
        },
        dataType: 'json', // Expect a JSON response
        success: function(response) {
            if (response.success) {
                // Close the modal and reload the table or data
                $('#schedule-modal').modal('hide');
                location.reload();  // Reload page to reflect changes
            } else {
                alert('Error updating schedule: ' + response.error);
            }
        },
        error: function() {
            console.error('Error updating schedule');
        }
    });
});
</script>


</html>