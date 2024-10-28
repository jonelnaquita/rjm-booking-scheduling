<!DOCTYPE html>
<html lang="en">
<?php include '../components/header.php'; ?>

<head>

</head>
<body data-stellar-background-ratio="0.5">
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                <div class="brand-logo">
                  <img src="../../admin/assets/images/logo.png" alt="logo">
                </div>
                <h4>Forgot Password</h4>
                <form id="forgot-password" class="pt-3">
                    <div class="form-group">
                        <input type="email" class="form-control form-control-lg" id="emailInput" placeholder="Email" name="email" required>
                    </div>
                    <div class="mt-3 d-grid gap-2">
                        <button id="submitButton" type="submit" class="btn btn-block btn-primary btn-rounded btn-lg font-weight-medium auth-form-btn">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Reset Password
                        </button>
                    </div>
                    <div class="my-2 d-flex justify-content-between align-items-center">
                        <div class="form-check"></div>
                        <a href="../index.php" class="auth-link text-black">
                        <i class="mdi mdi-arrow-left"></i> Back to Sign in
                        </a>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>

<script>
$(document).ready(function() {
    $('#forgot-password').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        var email = $('#emailInput').val(); // Get the email from the input
        var $submitButton = $('#submitButton'); // Reference to the submit button
        var $spinner = $submitButton.find('.spinner-border'); // Reference to the spinner

        $submitButton.prop('disabled', true); // Disable button
        $spinner.removeClass('d-none'); // Show spinner

        $.ajax({
            url: '../api/reset-password/reset-password.php', // Update this path to the PHP file
            type: 'POST',
            data: { email: email },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.success) {
                    toastr.success('A password reset link has been sent to your email.'); // Show success message
                } else {
                    alert('Error: ' + res.message);
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            },
            complete: function() {
                $submitButton.prop('disabled', false); // Re-enable button
                $spinner.addClass('d-none'); // Hide spinner
            }
        });
    });
});
</script>

</html>
