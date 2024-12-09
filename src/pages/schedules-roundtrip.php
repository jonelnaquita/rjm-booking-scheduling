<!DOCTYPE html>
<html lang="en">
<?php
include '../api/fetch-booking.php';
include '../api/fetch-schedules-function.php';
include '../components/header.php';


// Fetch unique dates for the date wrapper
$dates = fetchUniqueDates($conn);
?>

<head>
    <style>
        .date-button.active {
            background-color: #de5108;
            /* Active button background color */
            color: white;
            /* Active button text color */
            border-radius: 5px;
            padding: 5px 10px;
        }

        body {
            color: black;
        }
    </style>
</head>

<body>
    <?php
    include '../components/nav.php';
    ?>

    <>
        <div class="container mt-5" style="height: 100vh;">
            <!-- Step 1 Row -->
            <div class="row step-row">
                <div class="col-12 ">
                    <b>Step 1:</b> Choose a arrival schedule
                </div>
            </div>

            <!-- Date Selection -->
            <div class="row">
                <div class="col-12">
                    <div class="date-wrapper">
                        <button class="scroll-btn left" id="scroll-left">
                            < </button>
                                <div class="date-container" id="date-container">
                                    <?php foreach ($dates as $date): ?>
                                        <a href="#" class="date-button" data-date="<?php echo $date; ?>">
                                            <span class="date-day"><?php echo date('D', strtotime($date)); ?></span>
                                            <span class="date-date"><?php echo date('M j', strtotime($date)); ?></span>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                                <button class="scroll-btn right" id="scroll-right">></button>
                    </div>
                </div>
            </div>


            <div class="row">
                <?php include '../api/fetch-destination.php' ?>
                <div class="col-12 destination">
                    <p class="destination-route"><?php echo $to_name; ?> &gt; <?php echo $from_name; ?></p>
                </div>

                <div class="col-12 details">
                    <div class="detail-item">
                        <span id="booking-date"><?php echo $date_arrival ?></span> |
                        <span id="round-trip"><?php echo $direction ?></span> |
                        Total Passengers: <span id="total-passengers"><?php echo $passenger ?></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 schedules">
                    <div class="table-responsive custom-table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th scope="col">Departure Time</th>
                                    <th scope="col">Class</th>
                                    <th scope="col">Available Seats</th>
                                    <th scope="col">Fare</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="schedule-table-body">
                                <!-- Schedule rows will be injected here by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <?php
        include '../components/footer.php'
            ?>
</body>

<script>
    document.getElementById('scroll-left').addEventListener('click', function () {
        document.getElementById('date-container').scrollBy({
            left: -200, // Adjust this value to control scroll amount
            behavior: 'smooth'
        });
    });

    document.getElementById('scroll-right').addEventListener('click', function () {
        document.getElementById('date-container').scrollBy({
            left: 200, // Adjust this value to control scroll amount
            behavior: 'smooth'
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectedDate = "<?php echo $date_arrival; ?>"; // Get the selected date from PHP

        // Convert selectedDate to a consistent format (YYYY-MM-DD)
        const [month, day, year] = selectedDate.split('/');
        const formattedSelectedDate = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;

        // Find the date button that matches the selected date
        const dateButtons = document.querySelectorAll('.date-button');
        let activeButtonFound = false;

        dateButtons.forEach(button => {
            const buttonDate = button.getAttribute('data-date');

            if (buttonDate === formattedSelectedDate) {
                button.classList.add('active'); // Set the active class
                activeButtonFound = true;

                // Trigger the click event to load schedules
                loadSchedulesForDate(formattedSelectedDate);
            }

            button.addEventListener('click', function (event) {
                event.preventDefault();

                // Remove the active class from all buttons
                dateButtons.forEach(btn => btn.classList.remove('active'));

                // Add the active class to the clicked button
                this.classList.add('active');

                // Fetch and display schedules for the clicked date
                loadSchedulesForDate(buttonDate);
            });
        });

        if (!activeButtonFound && dateButtons.length > 0) {
            dateButtons[0].classList.add('active');
            loadSchedulesForDate(dateButtons[0].getAttribute('data-date'));
        }

        function loadSchedulesForDate(date) {
            // Add destination_from and destination_to as query parameters
            const destinationFrom = encodeURIComponent("<?php echo $_SESSION['booking']['destination_from'] ?? ''; ?>");
            const destinationTo = encodeURIComponent("<?php echo $_SESSION['booking']['destination_to'] ?? ''; ?>");
            const busType = encodeURIComponent("<?php echo $_SESSION['booking']['bus_type'] ?? ''; ?>");

            fetch(`../api/fetch-schedule.php?date=${date}&destination_from=${destinationTo}&destination_to=${destinationFrom}&bus_type=${busType}`)
                .then(response => response.json())
                .then(data => {
                    let tableBody = document.getElementById('schedule-table-body');
                    tableBody.innerHTML = ''; // Clear previous entries

                    data.forEach(schedule => {
                        let disabled = schedule.available_seats == 0 ? 'disabled' : '';

                        let row = `<tr>
                        <td>${schedule.departure_time}</td>
                        <td>${schedule.bus_type}</td>
                        <td>${schedule.available_seats}</td>
                        <td>₱${schedule.fare}</td>
                        <td><a href='passenger-form.php?scheduleArrival_id=${schedule.schedule_id}' class='btn btn-primary book-btn ${disabled}' ${disabled}>Book</a></td>
                    </tr>`;
                        tableBody.insertAdjacentHTML('beforeend', row);
                    });

                    document.getElementById('booking-date').textContent = new Date(date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
                })
                .catch(error => console.error('Error fetching schedules:', error));
        }
    });
</script>




<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateButtons = document.querySelectorAll('.date-button');

        dateButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                // Remove the active class from all buttons
                dateButtons.forEach(btn => btn.classList.remove('active'));

                // Add the active class to the clicked button
                this.classList.add('active');
            });
        });
    });

</script>

</html>