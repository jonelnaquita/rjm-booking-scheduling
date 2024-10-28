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
                <h4>Reset Password</h4>
                <form id="reset-password" class="pt-3">
                  <div class="form-group position-relative"> <!-- Added position-relative class -->
                    <input type="password" class="form-control form-control-lg" id="newPassword" placeholder="New Password" name="password" required>
                    <span class="mdi mdi-eye" id="toggleNewPassword"
                          style="cursor: pointer; position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
                    </span>
                  </div>
                  <div class="form-group position-relative"> <!-- Added position-relative class -->
                    <input type="password" class="form-control form-control-lg" id="confirmPassword" placeholder="Confirm Password" name="password" required>
                    <span class="mdi mdi-eye" id="toggleConfirmPassword"
                          style="cursor: pointer; position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
                    </span>
                  </div>
                  <div id="passwordMismatch" style="color: red; display: none;">Passwords do not match.</div> <!-- Error message -->
                  <div class="mt-3 d-grid gap-2">
                    <button type="submit" id="resetButton" class="btn btn-block btn-primary btn-rounded btn-lg font-weight-medium auth-form-btn" disabled>Reset Password</button> <!-- Initially disabled -->
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                    </div>
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
  $('#toggleNewPassword').on('click', function() { // Updated for new password
      const passwordInput = $('#newPassword');
      const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
      passwordInput.attr('type', type);
      $(this).toggleClass('mdi-eye mdi-eye-off'); // Toggle eye icon
  });

  $('#toggleConfirmPassword').on('click', function() { // Added for confirm password
      const passwordInput = $('#confirmPassword');
      const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
      passwordInput.attr('type', type);
      $(this).toggleClass('mdi-eye mdi-eye-off'); // Toggle eye icon
  });

  // Function to check password match
  function checkPasswordMatch() {
      const newPassword = $('#newPassword').val();
      const confirmPassword = $('#confirmPassword').val();
      const resetButton = $('#resetButton');
      const mismatchMessage = $('#passwordMismatch');

      // Only check if the confirm password field is not empty
      if (confirmPassword !== '' && newPassword !== confirmPassword) {
          mismatchMessage.show(); // Show mismatch message
          resetButton.prop('disabled', true); // Disable reset button
      } else {
          mismatchMessage.hide(); // Hide mismatch message
          resetButton.prop('disabled', confirmPassword === ''); // Disable if confirm password is empty
      }
  }

  // Event listener for confirm password input field
  $('#confirmPassword').on('input', checkPasswordMatch); // Check on input change
</script>

<script>
  // Handle Form Submission via AJAX
    $('#reset-password').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        let newPassword = $('#newPassword').val();
        let token = new URLSearchParams(window.location.search).get('token'); // Get token from URL

        $.ajax({
            url: '../api/reset-password/reset-password-process.php', // PHP script path
            type: 'POST',
            data: {
                password: newPassword,
                token: token // Send the token along with the password
            },
            success: function(response) {
                let res = JSON.parse(response);
                if (res.success) {
                    toastr.success('Password has been successfully reset.', 'Success');
                    setTimeout(function() {
                        window.location.href = '../index.php'; // Redirect to login page
                    }, 1000); // Delay of 1000 milliseconds (1 second)
                } else {
                    alert('Error: ' + res.message);
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    });
</script>
</html>
