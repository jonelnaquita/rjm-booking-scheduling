<?php
// Function to generate years for the revenue selector
function generateYearRevenue($startYear = 2024, $numYears = 5)
{
    $currentYear = date('Y');
    $years = [];

    // Start from the maximum of the current year or start year
    $start = max($currentYear, $startYear);

    // Generate the years array
    for ($i = 0; $i < $numYears; $i++) {
        $years[] = $start + $i; // Populate years in descending order
    }

    return $years;
}
?>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="card-title">Gross Income Details</p>
                    <div>
                        <!-- Month selector dropdown -->
                        <select id="month-selector" class="form-select"
                            style="width: 100px; display: inline-block; margin-right: 10px;">
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

                        <!-- Year selector dropdown -->
                        <select id="year-selector" class="form-select" style="width: 100px; display: inline-block;">
                            <?php
                            $years = generateYearRevenue();
                            foreach ($years as $year) {
                                $selected = ($year == date('Y')) ? 'selected' : '';
                                echo "<option value=\"$year\" $selected>$year</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <p class="font-weight-500 card-description">This shows the daily income breakdown for the selected month
                    and year.</p>
                <canvas id="revenue-chart" width="485" height="180"
                    style="display: block; box-sizing: border-box; height: 194px; width: 388px;"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        let chartInstance;

        // Function to load revenue data
        function loadRevenueData(year, month) {
            $.ajax({
                url: '../api/dashboard/fetch-revenue-summary.php',
                method: 'GET',
                dataType: 'json',
                data: { year: year, month: month }, // Pass both year and month
                success: function (revenueData) {
                    const ctx = document.getElementById('revenue-chart');

                    if (chartInstance) {
                        chartInstance.destroy();
                    }

                    // Generate day labels from 1 to 31
                    const daysInMonth = new Date(year, month, 0).getDate();
                    const dayLabels = Array.from({ length: daysInMonth }, (_, i) => i + 1); // Day 1 to 31
                    const revenue = dayLabels.map(day => revenueData[day] || 0); // Default to 0 if no revenue for that day

                    chartInstance = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: dayLabels, // Use day numbers as labels
                            datasets: [{
                                data: revenue,
                                borderColor: '#4747A1',
                                borderWidth: 2,
                                fill: false,
                                label: "Revenue",
                                pointRadius: 0,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            elements: { line: { tension: .4 } },
                            scales: {
                                x: { ticks: { color: "#6C7383" }, grid: { display: false } },
                                y: {
                                    ticks: { color: "#6C7383", stepSize: 200, callback: (value) => '₱' + value },
                                    grid: { display: true },
                                }
                            },
                            plugins: { legend: { display: false } }
                        }
                    });
                },
                error: function (error) {
                    console.error('Error fetching revenue data:', error);
                }
            });
        }

        // Set initial month and year based on the current month
        const currentYear = new Date().getFullYear();
        const currentMonth = new Date().getMonth() + 1; // months are zero-based, so add 1

        // Set the default selected month and year in the dropdowns
        $('#month-selector').val(currentMonth.toString().padStart(2, '0'));
        $('#year-selector').val(currentYear);

        // Load revenue data with the current month and year
        loadRevenueData(currentYear, currentMonth);

        // Update chart on year or month change
        $('#year-selector, #month-selector').on('change', function () {
            const selectedYear = $('#year-selector').val();
            const selectedMonth = $('#month-selector').val();
            loadRevenueData(selectedYear, selectedMonth);
        });
    });
</script>