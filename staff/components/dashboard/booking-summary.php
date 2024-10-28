<div class="row" style="margin-top: 20px;">
    <div class="col-md-12 grid-margin transparent">
        <div class="row">
            <div class="col-md-3 mb-4 stretch-card transparent">
                <div class="card card-tale">
                    <div class="card-body">
                        <p class="mb-4">Today’s Bookings</p>
                        <p class="fs-30 mb-2 todays-bookings"></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4 stretch-card transparent">
                <div class="card card-dark-blue">
                    <div class="card-body">
                        <p class="mb-4">Total Confirmed Bookings</p>
                        <p class="fs-30 mb-2 total-bookings"></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4 stretch-card transparent">
                <div class="card card-light-blue">
                    <div class="card-body">
                        <p class="mb-4">Number of Confirmed Passengers</p>
                        <p class="fs-30 mb-2 total-passengers"></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4 stretch-card transparent">
                <div class="card card-light-danger">
                    <div class="card-body">
                        <p class="mb-4">Total Revenue</p>
                        <p class="fs-30 mb-2 total-revenue"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Get the terminal ID from a data attribute or some other method
    var terminalId = <?php echo json_encode($terminal); ?>; // Assuming $terminal_id is fetched from PHP

    // Function to fetch data
    function fetchDashboardData() {
        $.ajax({
            url: '../api/dashboard/fetch-booking-summary.php', // Ensure the path is correct
            method: 'GET',
            dataType: 'json',
            data: { terminal_id: terminalId }, // Send terminal_id as a parameter
            success: function(data) {
                console.log(data); // Debug: Print the response to inspect
                if (data) {
                    // Animate counting effect
                    animateCount('.todays-bookings', data.todaysBookings);
                    animateCount('.total-bookings', data.totalBookings);
                    animateCount('.total-passengers', data.totalPassengers);
                    animateCount('.total-revenue', data.totalRevenue, '₱');
                } else {
                    console.log("Data structure is not as expected:", data);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.log(xhr.responseText); // Debug: Print the error response from the server
            }
        });
    }

    // Function to animate counting effect
    function animateCount(selector, targetValue, prefix = '') {
        let currentVal = parseInt($(selector).text().replace(/\D/g, '')) || 0;  // Strip any non-numeric characters
        $({ countNum: currentVal }).animate({ countNum: targetValue }, {
            duration: 1000,
            easing: 'swing',
            step: function() {
                $(selector).text(prefix + Math.floor(this.countNum));
            },
            complete: function() {
                $(selector).text(prefix + this.countNum);  // Ensure final value matches target with prefix
            }
        });
    }

    // Fetch data on page load
    fetchDashboardData();

    // Set interval to refresh data every 5 seconds (5000 milliseconds)
    setInterval(fetchDashboardData, 5000);
});
</script>
