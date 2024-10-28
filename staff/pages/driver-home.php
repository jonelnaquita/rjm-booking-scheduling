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
        .card-header{
            height: 50px;
            background-color: #de5108;
            color: #fff;
        }

        .card-header h6{
            margin-top: 10px;
        }

        .collapsed{
            color: #fff;
            margin-top: 30px;
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

                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                <h3 class="font-weight-bold">Welcome, <?php echo $fullname?></h3>
                                <h6 class="font-weight-normal mb-0">All systems are running smoothly!</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Today's Travel</h4>
                  <p class="card-description">Here is your schedule and list of bookings for today.</p>
                  <div class="mt-4">
                    <div class="accordion accordion-solid-header" id="accordion-4" role="tablist">
                        <!--Contents Here-->
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

<script>
$(document).ready(function() {
    $.ajax({
        url: '../api/driver/fetch-booking-schedules.php', // Adjust the path
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            // Clear any previous schedule
            $('#accordion-4').empty();

            // Log the response to see the structure
            console.log(response);

            // Check if the response contains an error
            if (response.error) {
                console.error('Error:', response.error);
                $('#accordion-4').append(`<div class="alert alert-danger">${response.error}</div>`);
                return;
            }

            // Adjust this condition based on the actual response structure
            if (Array.isArray(response) && response.length > 0) {
                response.forEach(function(schedule, index) {
                    let departureDate = new Date(`${schedule.schedule_date}T${schedule.schedule_time}`);
                    
                    // Format the date to "September 23, 2024"
                    let formattedDate = departureDate.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });

                    // Format the time to "10:00 PM"
                    let formattedTime = departureDate.toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true
                    });
                    
                    let scheduleCard = `
                        <div class="card">
                            <div class="card-header" role="tab" id="heading-${index}">
                                <h6 class="mb-0">
                                    <a data-bs-toggle="collapse" href="#collapse-${index}" aria-expanded="false" aria-controls="collapse-${index}" class="collapsed">
                                        ${formattedDate} | ${formattedTime}
                                    </a>
                                </h6>
                            </div>
                            <div id="collapse-${index}" class="collapse" role="tabpanel" aria-labelledby="heading-${index}">
                                <div class="card-body">
                                    <h5 class="destination card-title">${schedule.departure_destination} to ${schedule.arrival_destination}</h5>
                                    <div class="table-responsive">
                                        <table class="table table-data2 nowrap dt-responsive w-100">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Book ID</th>
                                                    <th>Full Name</th>
                                                    <th>Travel Cost</th>
                                                    <th>Passengers</th>
                                                    <th>Seat Number(s)</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;

                    // Add bookings for each schedule
                    schedule.bookings.forEach(function(booking, idx) {
                        // Split seat numbers and join them with a comma if multiple seats
                        let seatNumbers = booking.seat_numbers ? booking.seat_numbers.split(',').join(', ') : 'N/A';

                        scheduleCard += `
                            <tr>
                                <td>${idx + 1}</td>
                                <td>${booking.book_id}</td>
                                <td>${booking.fullname}</td>
                                <td>${booking.travel_cost}</td>
                                <td>${booking.passengers}</td>
                                <td>${seatNumbers}</td>
                                <td>${booking.status}</td>
                            </tr>`;
                    });

                    scheduleCard += `
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                    // Append the schedule card to the accordion container
                    $('#accordion-4').append(scheduleCard);
                });
            } else {
                // If no schedules, display a message
                $('#accordion-4').append('<div class="alert alert-info">No schedules found for today.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching schedules:', error);
            console.log('Response Text:', xhr.responseText); // Log the response text for debugging
            $('#accordion-4').append('<div class="alert alert-danger">Error fetching schedules. Please try again later.</div>');
        }
    });
});
</script>




</html>