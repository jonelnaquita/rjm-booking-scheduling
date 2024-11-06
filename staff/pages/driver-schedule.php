<?php
include '../api/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php
include '../components/header.php';
?>

<head>
    <style>
        /* Add some padding to the container */
        .container {
            margin-top: 20px;
        }

        /* Set the Flatpickr calendar to take full width */
        #embeddedCalendar {
            width: 100%;
        }

        .card-header {
            height: 60px;
        }
    </style>
</head>

<body>

    <div class="container-scroller">
        <?php include '../components/navbar.php'; ?>

        <div class="container-fluid page-body-wrapper">
            <?php include '../components/sidebar-driver.php'; ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <h3 class="tab-title">Trip Schedules</h3>

                    <div class="container">
                        <div class="row justify-content-center">
                            <!-- Left column: Flatpickr Calendar -->
                            <div class="col-md-4 col-12">
                                <div id="embeddedCalendar"></div>
                            </div>

                            <!-- Right column: Card with event list -->
                            <div class="col-md-8 col-12 mt-3 mt-md-0">
                                <div class="card shadow-sm border-0">
                                    <div
                                        class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Today's Bus Schedule</h5>
                                        <i class="bi bi-calendar2-week-fill"></i>
                                    </div>
                                    <div class="card-body" id="scheduleList">
                                        <!--Content Here-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <!--Include Footer -->
                <?php
                include '../components/footer.php';
                ?>

            </div>
        </div>
        <!-- page-body-wrapper ends -->
    </div>
</body>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<!-- Include Bootstrap Datepicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<style>
    /* Style for the datepicker input */
    #embeddedCalendar {
        font-size: 1.5rem;
        /* Increase font size */
        padding: 12px 16px;
        /* Add padding for a larger input area */
        border: 1px solid #ced4da;
        /* Light border */
        border-radius: 4px;
        margin-right: 200px;

    }

    /* Style the datepicker calendar */
    .datepicker {
        font-size: 1rem;
        /* Set a default font size for the calendar */
        border-radius: 8px;

    }

    /* Style the header of the datepicker */
    .datepicker-header {
        background-color: #007bff;
        /* Bootstrap primary color */
        color: white;
        /* White text for header */
        border-top-left-radius: 8px;
        /* Match the corner radius */
        border-top-right-radius: 8px;
        /* Match the corner radius */
    }

    /* Style the days of the month */
    .datepicker-days td,
    .datepicker-days th {
        padding: 10px;
        /* Increase padding */
        border-radius: 4px;
        /* Round the corners */
    }

    /* Style the selected day */
    .datepicker-days .active {
        background-color: #007bff;
        /* Active color */
        color: white;
        /* White text */
    }

    /* Hover effect for days */
    .datepicker-days td:hover {
        background-color: rgba(0, 123, 255, 0.1);
        /* Light hover effect */
        cursor: pointer;
        /* Pointer on hover */
    }

    /* Style disabled dates */
    .datepicker-days .disabled {
        color: #d9534f;
        /* Bootstrap danger color for disabled */
        cursor: not-allowed;
        /* Not allowed cursor */
    }
</style>

<script>
    function fetchAvailableDates() {
        return $.ajax({
            url: '../api/driver/fetch-available-schedules.php',
            method: 'GET',
            dataType: 'json'
        });
    }

    function fetchSchedule(departureDate) {
        $.ajax({
            url: '../api/driver/fetch-driver-schedules.php',
            method: 'GET',
            data: { departure_date: departureDate },
            dataType: 'json',
            success: function (response) {
                if (response.error) {
                    $('#scheduleList').html('<p class="text-danger">' + response.error + '</p>');
                } else if (response.length === 0) {
                    $('#scheduleList').html('<p class="text-warning">No available trips on the selected date.</p>');
                } else {
                    $('#scheduleList').empty();
                    $.each(response, function (index, schedule) {
                        var scheduleItem = `
                        <div class="schedule-item p-3 mb-3 rounded border shadow-sm">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold">${schedule.departure_time}</span>
                                <span class="badge bg-info text-light">Bus #${schedule.bus_number}</span>
                            </div>
                            <div class="text-muted">
                                <i class="bi bi-arrow-right-circle"></i>
                                <span class="ms-1">From: ${schedule.from_destination}</span>
                            </div>
                            <div class="text-muted">
                                <i class="bi bi-arrow-right-circle"></i>
                                <span class="ms-1">To: ${schedule.to_destination}</span>
                            </div>
                        </div>`;

                        $('#scheduleList').append(scheduleItem);
                    });
                }
            },
            error: function (xhr, status, error) {
                $('#scheduleList').html('<p class="text-danger">An error occurred while fetching the schedule.</p>');
            }
        });
    }

    function getTodayDateInPhilippineTime() {

        const utcDate = new Date();
        const utcOffset = 8 * 60 * 60 * 1000; // 8 hours in milliseconds
        const philippineDate = new Date(utcDate.getTime() + utcOffset);
        return philippineDate.toISOString().split('T')[0];
    }

    // Usage in your document ready function
    $(document).ready(function () {
        fetchAvailableDates().then(function (availableDates) {
            console.log('Available dates:', availableDates);
            if (Array.isArray(availableDates) && availableDates.length) {
                // Adjust available dates for the timezone
                availableDates = availableDates.map(date => {
                    const localDate = new Date(date + 'T00:00:00'); // Create date object in local time
                    return localDate.toISOString().split('T')[0]; // Convert to 'yyyy-mm-dd'
                });

                $('#embeddedCalendar').datepicker({
                    format: 'yyyy-mm-dd',
                    startDate: 'today',
                    beforeShowDay: function (date) {
                        const dateString = date.toISOString().split('T')[0];
                        return availableDates.includes(dateString) ? true : false; // Enable only available dates
                    },
                    autoclose: true
                }).on('changeDate', function (e) {
                    const selectedDate = e.format(); // Get the selected date in 'yyyy-mm-dd' format
                    console.log('Selected date:', selectedDate); // Log selected date
                    fetchSchedule(selectedDate); // Call the fetchSchedule function
                });
            } else {
                console.error('No available dates found or the response is invalid.');
            }
        }).fail(function () {
            console.error('Error fetching available dates.');
        });

        // Fetch the schedule for today
        var today = getTodayDateInPhilippineTime(); // Get today's date in Philippine time
        fetchSchedule(today); // Fetch the schedule using the correct date
    });

</script>





</html>