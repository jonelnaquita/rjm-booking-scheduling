<style>
#north-america-chart-legend ul,
#booking-status-chart-legend ul {
  margin-bottom: 0;
  list-style: none;
  padding-left: 0;
  display: none;
}
#north-america-chart-legend ul li,
#booking-status-chart-legend ul li {
  display: -webkit-flex;
  display: flex;
  -webkit-align-items: center;
  align-items: center;
  margin-top: 1rem;
}
#north-america-chart-legend ul li span,
#booking-status-chart-legend ul li span {
  width: 20px;
  height: 20px;
  margin-right: 0.4rem;
  display: inline-block;
  font-size: 0.875rem;
  border-radius: 50%;
}
#north-america-chart-legend > :first-child,
#booking-status-chart-legend > :first-child {
  display: block;
}
.rtl #north-america-chart-legend ul,
.rtl #booking-status-chart-legend ul {
  padding-right: 0;
}
.rtl #north-america-chart-legend ul li,
.rtl #booking-status-chart-legend ul li {
  margin-right: 0;
  margin-left: 8%;
}
.rtl #north-america-chart-legend ul li span,
.rtl #booking-status-chart-legend ul li span {
  margin-right: 0;
  margin-left: 1rem;
}
</style>

<div class="col-md-6 mt-3">
    <div class="doughnutchart-wrapper">
        <canvas id="booking-status-chart" height="250" style="display: block; box-sizing: border-box; height: 200px; width: 200px;" width="250"></canvas>
    </div>
    <div id="booking-status-chart-legend"> <!-- Updated ID to match canvas -->
        <ul>
            <li>
                <span style="background-color: #4B49AC"></span>
                Confirmed Bookings
            </li>
            <li>
                <span style="background-color: #FFC100"></span>
                Pending Bookings
            </li>
            <li>
                <span style="background-color: #248AFD"></span>
                Cancelled Bookings
            </li>
        </ul>
    </div>
</div>

<script>
$(document).ready(function() {
    // Fetch booking counts
    $.ajax({
        url: '../api/dashboard/fetch-booking-status-summary.php', // Ensure this path is correct
        method: 'GET',
        dataType: 'json',
        success: function(bookingCounts) {
            // Create the doughnut chart with fetched data
            const doughnutChartCanvas = document.getElementById('booking-status-chart');
            new Chart(doughnutChartCanvas, {
                type: 'doughnut',
                data: {
                    labels: ["Confirmed Bookings", "Pending Bookings", "Cancelled Bookings"],
                    datasets: [{
                        data: [bookingCounts.confirmed, bookingCounts.pending, bookingCounts.cancelled],
                        backgroundColor: [
                            "#4B49AC", "#FFC100", "#248AFD",
                        ],
                        borderColor: "rgba(0,0,0,0)"
                    }]
                },
                options: {
                    cutout: 70,
                    animationEasing: "easeOutBounce",
                    animateRotate: true,
                    animateScale: false,
                    responsive: true,
                    maintainAspectRatio: true,
                    showScale: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    }
                },
                plugins: [{
                    afterDatasetUpdate: function(chart, args, options) {
                        const chartId = chart.canvas.id;
                        const legendId = `${chartId}-legend`; // This now matches the legend ID
                        const ul = document.createElement('ul');
                        for (let i = 0; i < chart.data.datasets[0].data.length; i++) {
                            ul.innerHTML += `
                                <li>
                                    <span style="background-color: ${chart.data.datasets[0].backgroundColor[i]}"></span>
                                    ${chart.data.labels[i]}
                                </li>
                            `;
                        }
                        return document.getElementById(legendId).appendChild(ul);
                    }
                }]
            });
        },
        error: function(error) {
            console.error('Error fetching booking counts:', error);
        }
    });
});
</script>
