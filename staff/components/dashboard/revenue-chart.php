<?php
// Function to generate years for the revenue selector
function generateYearRevenue($startYear = 2024, $numYears = 5) {
    $currentYear = date('Y');
    $years = [];
    
    // Start from the maximum of the current year or start year
    $start = max($currentYear, $startYear);
    
    // Generate the years array
    for ($i = 0; $i < $numYears; $i++) {
        $years[] = $start - $i; // Populate years in descending order
    }
    
    return $years;
}
?>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="card-title">Revenue Details</p>
                    <select id="year-selector" class="form-select" style="width: 150px;">
                        <?php
                        // Call the function and store the years in an array
                        $years = generateYearRevenue();
                        
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
                <canvas id="revenue-chart" width="485" height="180" style="display: block; box-sizing: border-box; height: 194px; width: 388px;"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let chartInstance; // Variable to hold the chart instance

    function loadRevenueData(year, terminal_id) {
        var terminal_id = <?php echo json_encode($terminal); ?>; // Assuming $terminal_id is fetched from PHP
        console.log('Loading revenue data for year:', year, 'and terminal ID:', terminal_id); // Debugging log
        
        $.ajax({
            url: '../api/dashboard/fetch-revenue-summary.php', // Ensure this path is correct
            method: 'GET',
            dataType: 'json',
            data: { 
                year: year, // Pass the selected year as a parameter
                terminal: terminal_id // Pass the terminal ID as a parameter
            },
            success: function(revenueData) {
                console.log('Revenue data received:', revenueData); // Debugging log
                
                const ctx = document.getElementById('revenue-chart');

                // Destroy existing chart if it exists
                if (chartInstance) {
                    chartInstance.destroy();
                }

                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const revenue = months.map((_, index) => revenueData[index + 1] || 0);

                // Initialize the chart
                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [
                            {
                                data: revenue,
                                borderColor: '#4747A1',
                                borderWidth: 2,
                                fill: false,
                                label: "Revenue",
                                pointRadius: 0,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        elements: {
                            line: {
                                tension: .4,
                            }
                        },
                        scales: {
                            x: {
                                border: {
                                    display: false
                                },
                                grid: {
                                    display: false,
                                    drawTicks: true,
                                },
                                ticks: {
                                    color: "#6C7383",
                                },
                            },
                            y: {
                                border: {
                                    display: false
                                },
                                grid: {
                                    display: true,
                                },
                                ticks: {
                                    color: "#6C7383",
                                    stepSize: 200,
                                    callback: function(value) {
                                        return '₱' + value; // Add peso sign
                                    }
                                },
                            }
                        },
                        plugins: {
                            legend: {
                                display: false,
                            }
                        }
                    },
                });
            },
            error: function(error) {
                console.error('Error fetching revenue data:', error);
            }
        });
    }

    // Load initial data for the current year and terminal
    const initialYear = $('#year-selector').val();
    const terminalId = $('#terminal-selector').val(); // Assuming you have a terminal selector
    loadRevenueData(initialYear, terminalId);

    // Update chart on year change
    $('#year-selector').on('change', function() {
        const selectedYear = $(this).val();
        loadRevenueData(selectedYear, terminalId); // Pass terminal ID again
    });
    
    // Update chart on terminal change
    $('#terminal-selector').on('change', function() {
        const selectedTerminalId = $(this).val();
        loadRevenueData(initialYear, selectedTerminalId); // Pass new terminal ID
    });
});
</script>

