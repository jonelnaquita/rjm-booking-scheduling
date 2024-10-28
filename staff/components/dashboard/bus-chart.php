<?php
function generateYearOptions($startYear = 2024, $numYears = 5) {
    $currentYear = date('Y');
    $years = [];
    
    // Start from the maximum of the current year or start year
    $start = max($currentYear, $startYear);
    
    // Generate the years array
    for ($i = 0; $i < $numYears; $i++) {
        $years[] = $start + $i;
    }
    
    return $years;
}
?>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="card-title">Most Booked Bus</p>
                    <!-- Year Selector -->
                    <select id="year-selector-bus" class="form-select" style="width: 150px;">
                        <?php
                        // Call the function and store the years in an array
                        $years = generateYearOptions();
                        
                        // Loop through the years to create options
                        foreach ($years as $year) {
                            // Set the current year as selected
                            $selected = ($year == date('Y')) ? 'selected' : '';
                            echo "<option value=\"$year\" $selected>$year</option>";
                        }
                        ?>
                    </select>
                </div>
                <p class="font-weight-500">Description</p>
                <canvas id="bus-chart" width="485" height="200" style="display: block; box-sizing: border-box; height: 150px; width: 388px;"></canvas>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    const ctx = document.getElementById('bus-chart');
    let busChart; // Declare a variable to store the chart instance

    // Assuming $terminal is fetched from PHP and converted to JSON
    var terminalId = <?php echo json_encode($terminal); ?>; 

    // Function to fetch and display data
    function fetchBusData(selectedYear) {
        $.ajax({
            url: '../api/dashboard/fetch-bus-summary.php', // URL to your PHP file
            method: 'GET',
            data: { 
                year: selectedYear, // Pass the selected year as a parameter
                terminal: terminalId // Pass the terminal ID as a parameter
            },
            dataType: 'json',
            success: function(busTypesData) {
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const colors = ['#FFC100', '#4B49AC', '#248AFD'];

                // Prepare datasets for each bus type
                const datasets = Object.keys(busTypesData).map((busType, index) => {
                    const data = months.map((_, monthIndex) => busTypesData[busType][monthIndex + 1] || 0);

                    return {
                        label: busType,
                        data: data,
                        backgroundColor: colors[index % colors.length],
                        borderRadius: 5
                    };
                });

                // If chart already exists, destroy it first to update with new data
                if (busChart) {
                    busChart.destroy();
                }

                // Initialize the chart with new data
                busChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { color: "#6C7383" }
                            },
                            y: {
                                grid: { display: true },
                                ticks: {
                                    color: "#6C7383",
                                    callback: function(value) { return value + ' Bookings'; }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                labels: { color: '#6C7383' }
                            }
                        }
                    }
                });
            },
            error: function(error) {
                console.error('Error fetching bus bookings data:', error);
            }
        });
    }

    // Fetch data for the initially selected year
    const initialYear = $('#year-selector-bus').val();
    fetchBusData(initialYear);

    // Event listener for year selection change
    $('#year-selector-bus').change(function() {
        const selectedYear = $(this).val();
        fetchBusData(selectedYear); // Fetch and reload the chart data based on the selected year
    });
});
</script>
