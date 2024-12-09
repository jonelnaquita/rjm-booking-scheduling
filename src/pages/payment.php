<!DOCTYPE html>
<html lang="en">
<?php
include '../components/header.php';
include '../api/fetch-total-amount.php';
include '../api/store-schedule.php';
include '../api/fetch-passenger-details.php';
include '../api/fetch-departure-seats.php';
include '../api/fetch-arrival-seats.php';
include '../api/fetch-destination.php';
include '../api/fetch-departure-details.php';
include '../api/fetch-arrival-details.php';
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

        <form id="paymentForm" enctype="multipart/form-data">
            <div class="row fare-summary2 mt-4">
                <div class="col-12 col-md-6">
                    <div class="fare-summary p-4">
                        <div class="row">
                            <div class="col-12">
                                Total Amount to be paid
                                <div class="fare-amount-right">₱ <?php echo $formattedAmount; ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="payment-box p-4">
                        <!-- Image Display -->
                        <div class="image-container mb-3">
                            <?php
                            // Fetch the GCash image filename from the admin table
                            include_once '../../models/conn.php';
                            $sql = "SELECT gcash FROM tbladmin LIMIT 1";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $gcashImage = $row['gcash'];
                                echo "<img src='../../assets/images/payment/{$gcashImage}' alt='GCash QR Code' class='img-fluid'>";
                            } else {
                                echo "<p>No GCash QR code available.</p>";
                            }
                            $conn->close();
                            ?>
                        </div>

                        <!-- File Upload Input -->
                        <div class="file-upload mb-3">
                            <label for="file-upload" class="form-label">Upload Payment Proof:</label>
                            <input type="file" id="file-upload" name="payment-proof" class="form-control"
                                accept="image/*">
                            <div class="invalid-feedback" id="file-error" style="display:none;">Please upload your
                                payment proof (image files only).</div>
                        </div>

                        <!-- Reference Number Input -->
                        <div class="reference-number">
                            <label for="reference-number" class="form-label">Reference Number:</label>
                            <input type="number" id="reference-number" name="reference-number" class="form-control"
                                placeholder="Enter your reference number">
                            <div class="invalid-feedback" id="reference-error" style="display:none;">Please enter your
                                reference number.</div>
                        </div>

                    </div>
                </div>
            </div>

            <input type="hidden" name="totalAmount" value="<?php echo htmlspecialchars($totalAmount); ?>"
                placeholder="Total Amount">
            <input type="hidden" name="scheduleDeparture_id"
                value="<?php echo htmlspecialchars($scheduleDeparture_id); ?>" placeholder="Schedule Departure ID">
            <input type="hidden" name="scheduleArrival_id" value="<?php echo htmlspecialchars($scheduleArrival_id); ?>"
                placeholder="Schedule Arrival ID">
            <input type="hidden" name="direction" value="<?php echo htmlspecialchars($direction); ?>"
                placeholder="Direction">
            <input type="hidden" name="passenger" value="<?php echo htmlspecialchars($passenger); ?>"
                placeholder="Passenger">

            <!-- Passenger Details -->
            <input type="hidden" name="firstName"
                value="<?php echo htmlspecialchars($passengerDetails['firstName']); ?>" placeholder="First Name">
            <input type="hidden" name="middleName"
                value="<?php echo htmlspecialchars($passengerDetails['middleName']); ?>" placeholder="Middle Name">
            <input type="hidden" name="lastName" value="<?php echo htmlspecialchars($passengerDetails['lastName']); ?>"
                placeholder="Last Name">
            <input type="hidden" name="gender" value="<?php echo htmlspecialchars($passengerDetails['gender']); ?>"
                placeholder="Gender">
            <input type="hidden" name="province" value="<?php echo htmlspecialchars($passengerDetails['province']); ?>"
                placeholder="Province">
            <input type="hidden" name="city" value="<?php echo htmlspecialchars($passengerDetails['city']); ?>"
                placeholder="City">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($passengerDetails['email']); ?>"
                placeholder="Email">
            <input type="hidden" name="mobile" value="<?php echo htmlspecialchars($passengerDetails['mobile']); ?>"
                placeholder="Mobile Number">
            <input type="hidden" name="fullAddress"
                value="<?php echo htmlspecialchars($passengerDetails['fullAddress']); ?>" placeholder="Full Address">

            <!-- Seats -->
            <input type="hidden" name="departureSeats"
                value="<?php echo htmlspecialchars(implode(', ', $departureSeats)); ?>" placeholder="Departure Seats">
            <?php if ($direction === "Round-Trip"): ?>
                <input type="hidden" name="arrivalSeats"
                    value="<?php echo htmlspecialchars(implode(', ', $arrivalSeats)); ?>" placeholder="Arrival Seats">
            <?php endif; ?>

            <!-- Navigation Buttons -->
            <div class="row mt-4">
                <div class="col-6">
                    <a href="summary.php" class="btn btn-outline-primary btn-block">Back to Step 4</a>
                </div>
                <div class="col-6 text-right">
                    <button type="button" class="btn btn-primary btn-block" id="submitBtn"
                        onclick="submitPaymentForm()">Submit</button>
                    <div id="spinner" style="display: none;" class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

            </div>
        </form>
    </div>

</body>

<?php
include '../components/footer.php'
    ?>

<script>
    function validatePaymentForm() {
        // Get input values
        const fileInput = document.getElementById('file-upload');
        const referenceNumber = document.getElementById('reference-number').value.trim();

        // Initialize validation status
        let isValid = true;

        // Validate file input
        if (fileInput.files.length === 0) {
            document.getElementById('file-error').style.display = 'block';
            fileInput.classList.add('is-invalid');
            isValid = false;
        } else {
            const file = fileInput.files[0];
            const fileType = file.type;
            if (!fileType.startsWith('image/')) {
                document.getElementById('file-error').textContent = 'Please upload an image file.';
                document.getElementById('file-error').style.display = 'block';
                fileInput.classList.add('is-invalid');
                isValid = false;
            } else {
                document.getElementById('file-error').style.display = 'none';
                fileInput.classList.remove('is-invalid');
            }
        }

        // Validate reference number
        if (referenceNumber === "") {
            document.getElementById('reference-error').style.display = 'block';
            document.getElementById('reference-number').classList.add('is-invalid');
            isValid = false;
        } else {
            document.getElementById('reference-error').style.display = 'none';
            document.getElementById('reference-number').classList.remove('is-invalid');
        }

        return isValid;
    }

    function submitPaymentForm() {
        // Run the validation function
        if (!validatePaymentForm()) {
            return; // Stop the form submission if validation fails
        }

        // Disable the submit button and show the spinner
        var submitBtn = document.getElementById('submitBtn');
        var spinner = document.getElementById('spinner');
        submitBtn.disabled = true; // Disable the button
        spinner.style.display = 'inline-block'; // Show the spinner

        // Proceed with the AJAX form submission if validation is successful
        var formData = new FormData(document.getElementById('paymentForm'));

        $.ajax({
            url: '../api/save-payment.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                var result = JSON.parse(response);
                if (result.success) {
                    alert('Payment submitted successfully. Your Passenger ID is: ' + result.passenger_id);

                    // Clear the form inputs
                    $('#file-upload').val('');
                    $('#reference-number').val('');

                    // Clear the file input (for better UX in some browsers)
                    var fileInput = $("#payment-proof");
                    fileInput.replaceWith(fileInput.val('').clone(true));

                    // Optionally, redirect to a confirmation page
                    window.location.href = 'message.php?passenger_id=' + result.passenger_id;
                } else {
                    alert('Error: ' + result.message);
                }
            },
            error: function () {
                alert('An error occurred while submitting the payment.');
            },
            complete: function () {
                // Re-enable the submit button and hide the spinner
                submitBtn.disabled = false; // Enable the button again
                spinner.style.display = 'none'; // Hide the spinner
            }
        });
    }
</script>

</html>