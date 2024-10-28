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
                    <h3 class="tab-title">Schedule Archive</h3>

                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-auto">
                            <button type="button" class="btn btn-outline-info btn-rounded btn-icon" id="filter-button">
                                <i class="ti-filter"></i>
                            </button>
                        </div>
                    </div>


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
                        
                        <!-- Dropdown Menu -->
                        <div class="col-12 col-md-auto mt-2 mt-md-0">
                            <div class="row">
                                <div class="col">
                                    <select class="form-select form-select-sm" id="status-filter">
                                        <option value="">Filter by Status</option>
                                        <option value="1">N/A</option>
                                        <option value="2">Arrived</option>
                                        <option value="3">Departed</option>
                                        <option value="4">Boarding</option>
                                        <option value="5">En Route</option>
                                        <option value="6">Delayed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="table-responsive">
                        <table id="schedule-table" class="table table-hover" style="margin-top: 20px; margin-bottom: 20px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Destination From</th>
                                    <th>Destination To</th>
                                    <th>Departure Date</th>
                                    <th>Departure Time</th>
                                    <th>Bus Number</th>
                                    <th>Bus Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include '../api/schedule/fetch-schedule-table-archive.php'; ?> <!-- Adjust the path to where you save this PHP code -->
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
            function getManilaDate() {
                // Manila timezone offset in minutes (UTC+8)
                const MANILA_OFFSET = 480;
                // Get the current date and time
                const now = new Date();
                // Convert current date to UTC
                const utcDate = new Date(now.getTime() - (now.getTimezoneOffset() * 60000));
                // Adjust to Manila time
                const manilaDate = new Date(utcDate.getTime() + (MANILA_OFFSET * 60000));
                // Format the date to YYYY-MM-DD
                return manilaDate.toISOString().split('T')[0];
            }

            // Get the current date in Manila timezone
            const currentDate = getManilaDate();

            // Initialize Flatpickr with date restrictions
            $("#schedule-datepicker").flatpickr({
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
                mode: "multiple",
                minDate: currentDate, // Disable all dates before today
                defaultDate: currentDate // Optional: Set default date to today
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
    // Handle the save-schedule button click event
    $('.save-schedule').on('click', function() {
        var from_id = $('.destination-from').val();
        var to_id = $('.destination-to').val();
        var departure_dates_str = $('#schedule-datepicker').val(); // This might be a comma-separated string
        var departure_time = $('#schedule-timepicker').val();
        var bus_id = $('.bus-number').val();

        // Split the string into an array of dates
        var departure_dates = departure_dates_str.split(', '); // Split the dates by comma and space

        // Validate that all fields are filled in
        if (!from_id || !to_id || !departure_dates.length || !departure_time || !bus_id) {
            toastr.info('Please fill in all fields before saving the schedule.');
            return;
        }

        // Loop through each selected date and send it to the server
        $.each(departure_dates, function(index, departure_date) {
            $.ajax({
                url: '../api/schedule/save-schedule.php', // Adjust the URL to your setup
                type: 'POST',
                data: {
                    from_id: from_id,
                    to_id: to_id,
                    departure_date: departure_date.trim(), // Trim any leading/trailing spaces
                    departure_time: departure_time,
                    bus_id: bus_id
                },
                success: function(response) {
                    console.log('Schedule saved for date: ' + departure_date);
                },
                error: function() {
                    alert('Error saving schedule for date: ' + departure_date);
                }
            });
        });

        toastr.success('Schedules saved successfully!');
        // Add a delay before reloading the page
        setTimeout(function() {
            location.reload(); // Refresh the page
        }, 1000);
    });
});
</script>

<!--Filter Table -->
<script>
$(document).ready(function() {
    function fetchSchedules() {
        // Get filter values
        var departureDate = $('#datepicker').val();
        var departureTime = $('#timepicker').val();
        var status = $('#status-filter').val();

        $.ajax({
            url: '../api/schedule/filter-table.php', // PHP script to fetch filtered data
            type: 'POST',
            data: {
                departure_date: departureDate,
                departure_time: departureTime,
                status: status
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
    $('#datepicker, #timepicker, #status-filter').on('change', function() {
        fetchSchedules();
    });

});
</script>



</html>