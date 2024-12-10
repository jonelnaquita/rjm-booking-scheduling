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

    #north-america-chart-legend> :first-child,
    #booking-status-chart-legend> :first-child {
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


<script>
    $(document).ready(function () {
        // Fetch city-wise booking counts
        $.ajax({
            url: '../api/dashboard/fetch-booking-city.php', // Ensure the path is correct
            method: 'GET',
            dataType: 'json',
            success: function (cityCounts) {
                const cities = Object.keys(cityCounts); // Extract city names
                const counts = Object.values(cityCounts); // Extract booking counts

                // Create the doughnut chart with fetched data
                const doughnutChartCanvas = document.getElementById('booking-city-chart');
                new Chart(doughnutChartCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: cities,
                        datasets: [{
                            data: counts,
                            backgroundColor: ["#4B49AC", "#FFC100", "#FF5733", "#28A745", "#17A2B8"], // Add more colors as needed
                            borderColor: "rgba(0,0,0,0)"
                        }]
                    },
                    options: {
                        cutout: 70,
                        animation: {
                            easing: "easeOutBounce",
                            animateRotate: true,
                            animateScale: false
                        },
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom'
                            }
                        }
                    }
                });
            },
            error: function (error) {
                console.error('Error fetching city counts:', error);
            }
        });
    });

</script>