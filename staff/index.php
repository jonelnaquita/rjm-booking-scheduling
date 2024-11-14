<?php
session_start();

// Check if the 'role' session variable exists
if (isset($_SESSION['role'])) {
  $role = $_SESSION['role'];

  // Redirect based on the role
  if ($role === 'Driver') {
    header('location: pages/home.php');
  } else {
    header('location: pages/driver-home.php');
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>

<head>

</head>

<body style="background-image: url('assets/images/bg_1.jpg');" data-stellar-background-ratio="0.5">
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="../admin/assets/images/logo-mini.png" alt="logo">
                <h4>Terminal Staff / Driver / Conductor</h4>
              </div>
              <h4>Hello! let's get started</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form id="loginForm" class="pt-3">
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email"
                    name="email" required>
                </div>
                <div class="form-group position-relative"> <!-- Added position-relative class -->
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1"
                    placeholder="Password" name="password" required>
                  <span class="mdi mdi-eye" id="togglePassword"
                    style="cursor: pointer; position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
                  </span>
                </div>
                <div class="mt-3 d-grid gap-2">
                  <button type="submit"
                    class="btn btn-block btn-primary btn-rounded btn-lg font-weight-medium auth-form-btn">SIGN
                    IN</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                  </div>
                  <a href="pages/forgot-password.php" class="auth-link text-black">Forgot password?</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#loginForm').on('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        $.ajax({
          url: 'api/verify-login.php', // PHP script to process the login
          type: 'POST',
          data: $(this).serialize(),
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              // Redirect based on the role
              if (response.role === 'Terminal Staff') {
                window.location.href = 'pages/home.php'; // Redirect to home.php for Terminal Staff
              } else {
                window.location.href = 'pages/driver-home.php'; // Redirect to driver-home.php for other roles
              }
            } else {
              alert(response.message); // Show error message
            }
          },
          error: function () {
            alert('An error occurred during login.'); // Improved error message
          }
        });
      });

      // Show/Hide password functionality
      $('#togglePassword').on('click', function () {
        const passwordInput = $('#exampleInputPassword1');
        const eyeIcon = $('#eyeIcon');
        const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
        passwordInput.attr('type', type);
        eyeIcon.toggleClass('mdi-eye mdi-eye-off'); // Toggle eye icon
      });
    });
  </script>

</body>

</html>