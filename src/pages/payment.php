<!DOCTYPE html>
<html lang="en">
<?php
    include '../components/header.php';
?>
<body>
    <?php
        include '../components/nav.php';
    ?>

    <head>
        <link rel="stylesheet" href="../../assets/css/payment.css">
    </head>

<div class="container mt-5">
    <!-- Step 2 Row -->
    <div class="row step-row">
        <div class="col-12">
            <b>Step 5:</b> Payment
        </div>
    </div>


    <div class="row fare-summary2 mt-4">
        <div class="col-12 col-md-6">
            <div class="fare-summary p-4">
                <div class="row">
                    <div class="col-12">
                        Total Amount to be paid
                        <div class="fare-amount-right">656.00</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="payment-box p-4">
                <!-- Image Display -->
                <div class="image-container mb-3">
                    <img src="../../assets/images/payment.jpg" alt="Payment Image" class="img-fluid">
                </div>

                <!-- File Upload Input -->
                <div class="file-upload mb-3">
                    <label for="file-upload" class="form-label">Upload Payment Proof:</label>
                    <input type="file" id="file-upload" name="payment-proof" class="form-control">
                </div>

                <!-- Reference Number Input -->
                <div class="reference-number">
                    <label for="reference-number" class="form-label">Reference Number:</label>
                    <input type="text" id="reference-number" name="reference-number" class="form-control" placeholder="Enter your reference number">
                </div>
            </div>
        </div>
    </div>



    <!-- Navigation Buttons -->
    <div class="row mt-4">
        <div class="col-6">
            <a href="summary.php" class="btn btn-outline-primary btn-block">Back to Step 4</a>
        </div>
        <div class="col-6 text-right">
            <a href="summary.php" class="btn btn-primary btn-block">Submit</a>
        </div>
    </div>
</div>

<?php
    include '../components/footer.php'
?>
</body>
</html>