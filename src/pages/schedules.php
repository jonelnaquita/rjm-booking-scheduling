<!DOCTYPE html>
<html lang="en">
<?php
    include '../components/header.php';
?>
<body>
    <?php
        include '../components/nav.php';
    ?>

    <div>
    <div class="container mt-5">
    <!-- Step 1 Row -->
    <div class="row step-row">
        <div class="col-12 ">
            <b>Step 1:</b> Choose a departure schedule
        </div>
    </div>

    <!-- Date Selection -->
    <div class="row">
        <div class="col-12">
            <div class="date-wrapper">
                <button class="scroll-btn left" id="scroll-left"><</button>
                <div class="date-container" id="date-container">
                    <a href="#" class="date-button">
                        <span class="date-day">Thu</span>
                        <span class="date-date">Aug 29</span>
                    </a>
                </div>
                <button class="scroll-btn right" id="scroll-right">></button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 destination">
            <p class="destination-route">Cubao &gt; Baguio</p>
        </div>
        <div class="col-12 details">
            <div class="detail-item">
                <span id="booking-date">Aug 29, 2024</span> | <span id="round-trip">One Way</span> | Total Passengers: <span id="total-passengers">3</span>
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
                <tbody>
                    <tr scope="row">
                        <td> 12:15 AM </td>
                        <td> Royal Class </td></td>
                        <td> 20 </td>
                        <td> ₱1,500.00</td>
                        <td> <a href="passenger-form.php" type="button" class="btn btn-primary">Book</a></td>
                    </tr>

                    <tr scope="row">
                        <td> 12:15 AM </td>
                        <td> Royal Class </td></td>
                        <td> 20 </td>
                        <td> ₱1,500.00</td>
                        <td> <a href="passenger-form.php" type="button" class="btn btn-primary">Book</a></td>
                    </tr>
                    
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
        document.getElementById('scroll-left').addEventListener('click', function() {
            document.getElementById('date-container').scrollBy({
                left: -200, // Adjust this value to control scroll amount
                behavior: 'smooth'
            });
        });

        document.getElementById('scroll-right').addEventListener('click', function() {
            document.getElementById('date-container').scrollBy({
                left: 200, // Adjust this value to control scroll amount
                behavior: 'smooth'
            });
        });
    </script>
</html>