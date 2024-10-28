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

        .card-header{
            height: 60px;
        }
    </style>
</head>
<body>

    <div class="container-scroller">
        <?php include '../components/navbar.php'; ?>

        <div class="container-fluid page-body-wrapper">
            <?php include '../components/sidebar-driver.php';?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <h3 class="tab-title">Trip Schedules</h3>

                    <div class="container">
                        <div class="row">
                            <!-- Left column: Flatpickr Calendar -->
                            <div class="col-md-4 col-12">
                                <div id="embeddedCalendar"></div>
                            </div>

                            <!-- Right column: Card with event list -->
                            <div class="col-md-8 col-12 mt-3 mt-md-0">
                                <div class="card shadow-sm border-0">
                                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
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

<script>
    // Initialize Flatpickr
flatpickr("#embeddedCalendar", {
    inline: true,
    dateFormat: "Y-m-d",
    minDate: "today", // Disable past dates by setting the minimum date to today
    onChange: function(selectedDates, dateStr, instance) {
        // Fetch the schedule when a new date is selected
        fetchSchedule(dateStr);
    }
});

// Function to fetch the schedule and update the placeholders
function fetchSchedule(departureDate) {
    $.ajax({
        url: '../api/driver/fetch-driver-schedules.php',
        method: 'GET',
        data: { departure_date: departureDate }, // Send the selected departure date
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                $('#scheduleList').html('<p class="text-danger">' + response.error + '</p>');
            } else if (response.length === 0) {
                // Display a message if no trips are available
                $('#scheduleList').html('<p class="text-warning">No available trips on the selected date.</p>');
            } else {
                $('#scheduleList').empty(); // Clear existing schedule
                $.each(response, function(index, schedule) {
                    // Generate schedule items
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
                    
                    // Append the generated item to the schedule list
                    $('#scheduleList').append(scheduleItem);
                });
            }
        },
        error: function(xhr, status, error) {
            $('#scheduleList').html('<p class="text-danger">An error occurred while fetching the schedule.</p>');
        }
    });
}

// Fetch the schedule for the default date (today) on page load
$(document).ready(function() {
    var today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format
    fetchSchedule(today);
});

</script>





</html>