<div class="row" style="margin-top: 20px;">
    <!-- Dropdown for selecting month -->
    <div class="col-md-2 mb-2">
        <select id="monthDropdown" class="form-select">
            <option value="01">January</option>
            <option value="02">February</option>
            <option value="03">March</option>
            <option value="04">April</option>
            <option value="05">May</option>
            <option value="06">June</option>
            <option value="07">July</option>
            <option value="08">August</option>
            <option value="09">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
    </div>

    <div class="col-md-2 mb-4" style="float: right;">
        <select id="yearDropdown" class="form-select">
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
            <option value="2027">2027</option>
            <option value="2028">2028</option>
            <option value="2029">2029</option>
            <option value="2030">2030</option>
        </select>
    </div>

    <div class="col-md-12 grid-margin transparent">
        <div class="row">
            <!-- Cards for booking summaries -->
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
                        <p class="mb-4">Number of Passengers</p>
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
    $(document).ready(function () {
        // Function to fetch and update dashboard data based on selected month and year
        function fetchDashboardData(month, year) {
            $.ajax({
                url: '../api/dashboard/fetch-booking-summary.php', // Adjust path if necessary
                method: 'GET',
                data: {
                    month: month,
                    year: year
                },
                dataType: 'json',
                success: function (data) {
                    if (data) {
                        animateCount('.todays-bookings', data.todaysBookings);
                        animateCount('.total-bookings', data.totalBookings);
                        animateCount('.total-passengers', data.totalPassengers);
                        animateCount('.total-revenue', data.totalRevenue, '₱');
                    } else {
                        console.log("Data structure not as expected:", data);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        }

        // Trigger data fetch when month or year changes
        $('#monthDropdown, #yearDropdown').on('change', function () {
            const selectedMonth = $('#monthDropdown').val();
            const selectedYear = $('#yearDropdown').val();
            fetchDashboardData(selectedMonth, selectedYear);
        });

        // Initial data fetch with the current month and year
        const currentMonth = new Date().getMonth() + 1;
        const currentYear = new Date().getFullYear();
        $('#monthDropdown').val(('0' + currentMonth).slice(-2)).trigger('change');
        $('#yearDropdown').val(currentYear);

        // Animate count function
        function animateCount(selector, targetValue, prefix = '') {
            let currentVal = parseInt($(selector).text().replace(/\D/g, '')) || 0;
            $({ countNum: currentVal }).animate({ countNum: targetValue }, {
                duration: 1000,
                easing: 'swing',
                step: function () {
                    $(selector).text(prefix + Math.floor(this.countNum));
                },
                complete: function () {
                    $(selector).text(prefix + this.countNum);
                }
            });
        }
    });
</script>