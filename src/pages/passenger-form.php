<!DOCTYPE html>
<html lang="en">
<?php
    include '../components/header.php';
?>
<body>
    <?php
        include '../components/nav.php';
    ?>

<div class="container mt-5">
    <!-- Step 2 Row -->
    <div class="row step-row">
        <div class="col-12">
            <b>Step 2:</b> Passenger Information
        </div>
    </div>

    <!-- Passenger Form -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" class="form-control form-line" placeholder="Juan" required>
            </div>
            <div class="form-group">
                <label for="middleName">Middle Name</label>
                <input type="text" id="middleName" class="form-control form-line" placeholder="M">
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" class="form-control form-line" placeholder="Dela Cruz" required>
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" id="city" class="form-control form-line" placeholder="Enter your city" required> 
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control form-line" placeholder="juandelacruz@gmail.com" required>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile Number</label>
                <input type="text" id="mobile" class="form-control form-line" placeholder="09xxxxxxxxx" required>
            </div>
            <div class="form-group">
                <label for="fullAddress">Full Address</label>
                <input type="text" id="fullAddress" class="form-control form-line" placeholder="Enter your full address" required>
            </div>
        </div>
    </div>
    

    <!-- Navigation Buttons -->
    <div class="row mt-4">
        <div class="col-6">
            <a href="schedules.php" class="btn btn-outline-primary btn-block">Back to Step 1</a>
        </div>
        <div class="col-6 text-right">
            <a href="seats.php" class="btn btn-primary btn-block">Next</a>
        </div>
    </div>
</div>

    <?php
        include '../components/footer.php'
    ?>
</body>
</html>