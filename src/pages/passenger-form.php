<!DOCTYPE html>
<html lang="en">
<?php
    include '../components/header.php';
    include '../api/store-schedule.php';
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
    <form id="passengerForm" method="POST" action="../api/store-passenger-details.php">
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" class="form-control form-line" placeholder="Juan">
                    <small class="error-message" style="color: red; display: none;">First Name is required.</small>
                </div>
                <div class="form-group">
                    <label for="middleName">Middle Name</label>
                    <input type="text" id="middleName" name="middleName" class="form-control form-line" placeholder="M" maxlength="1">
                    <small class="error-message" style="color: red; display: none;">Middle Name must be exactly 1 character.</small>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" class="form-control form-line" placeholder="Dela Cruz">
                    <small class="error-message" style="color: red; display: none;">Last Name is required.</small>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" class="form-control form-line" placeholder="Enter your city">
                    <small class="error-message" style="color: red; display: none;">City is required.</small>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control form-line" placeholder="juandelacruz@gmail.com">
                    <small class="error-message" style="color: red; display: none;">A valid email is required.</small>
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile Number</label>
                    <input type="text" id="mobile" name="mobile" class="form-control form-line" placeholder="09xxxxxxxxx">
                    <small class="error-message" style="color: red; display: none;">Mobile Number is required.</small>
                </div>
                <div class="form-group">
                    <label for="fullAddress">Full Address</label>
                    <input type="text" id="fullAddress" name="fullAddress" class="form-control form-line" placeholder="Enter your full address">
                    <small class="error-message" style="color: red; display: none;">Full Address is required.</small>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="row mt-4">
            <div class="col-6">
                <a href="schedules.php" class="btn btn-outline-primary btn-block">Back to Step 1</a>
            </div>
            <div class="col-6 text-right">
                <button type="submit" class="btn btn-primary btn-block">Next</button>
            </div>
        </div>
    </form>

</div>

    <?php
        include '../components/footer.php'
    ?>
</body>

<script>
document.getElementById('passengerForm').addEventListener('submit', function(event) {
    // Initialize a flag to check if the form is valid
    let formIsValid = true;

    // Validate First Name
    const firstName = document.getElementById('firstName');
    if (firstName.value.trim() === '') {
        showError(firstName, 'First Name is required.');
        formIsValid = false;
    } else {
        clearError(firstName);
    }

    // Validate Last Name
    const lastName = document.getElementById('lastName');
    if (lastName.value.trim() === '') {
        showError(lastName, 'Last Name is required.');
        formIsValid = false;
    } else {
        clearError(lastName);
    }

    // Validate City
    const city = document.getElementById('city');
    if (city.value.trim() === '') {
        showError(city, 'City is required.');
        formIsValid = false;
    } else {
        clearError(city);
    }

    // Validate Email
    const email = document.getElementById('email');
    if (email.value.trim() === '' || !validateEmail(email.value)) {
        showError(email, 'A valid email is required.');
        formIsValid = false;
    } else {
        clearError(email);
    }

    // Validate Mobile Number
    const mobile = document.getElementById('mobile');
    if (mobile.value.trim() === '') {
        showError(mobile, 'Mobile Number is required.');
        formIsValid = false;
    } else {
        clearError(mobile);
    }

    // Validate Full Address
    const fullAddress = document.getElementById('fullAddress');
    if (fullAddress.value.trim() === '') {
        showError(fullAddress, 'Full Address is required.');
        formIsValid = false;
    } else {
        clearError(fullAddress);
    }

    // Validate Middle Name (Optional but must be 1 character if provided)
    const middleName = document.getElementById('middleName');
    if (middleName.value.trim() !== '' && middleName.value.length !== 1) {
        showError(middleName, 'Middle Name must be exactly 1 character.');
        formIsValid = false;
    } else {
        clearError(middleName);
    }

    // If the form is not valid, prevent form submission
    if (!formIsValid) {
        event.preventDefault();
    }
});

// Function to display error messages
function showError(inputElement, message) {
    const errorElement = inputElement.nextElementSibling;
    errorElement.textContent = message;
    errorElement.style.display = 'block';
    inputElement.classList.add('is-invalid');
}

// Function to clear error messages
function clearError(inputElement) {
    const errorElement = inputElement.nextElementSibling;
    errorElement.style.display = 'none';
    inputElement.classList.remove('is-invalid');
}

// Function to validate email format
function validateEmail(email) {
    const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return re.test(String(email).toLowerCase());
}
</script>
</html>