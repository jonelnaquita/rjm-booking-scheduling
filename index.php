<?php
include_once 'models/conn.php';
include_once 'src/api/destroy-session.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php
include 'components/header.php'
  ?>

<head>
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

  <style>
    .available-date-highlight {
      background-color: #28a745 !important;
      /* Green highlight */
      color: white !important;
      border-radius: 50%;
    }
  </style>

</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light probootstrap_navbar" id="probootstrap-navbar">
    <div class="container">
      <a class="navbar-brand" href="../../../index.php">
        <img src="admin/assets/images/logo-mini.png" alt="RJM Transport Corp." style="height: 50px;" />
      </a>
    </div>
  </nav>


  <!-- END nav -->

  <section class="probootstrap-cover overflow-hidden relative" style="background-image: url('assets/images/bg_1.jpg');"
    data-stellar-background-ratio="0.5" id="section-home">
    <div class="overlay"></div>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md">
          <h2 class="heading mb-2 display-4 font-light probootstrap-animate">Your Journey, <br> Our Drive.</h2>
          <p class="lead mb-5 probootstrap-animate">

        </div>
        <div class="col-md probootstrap-animate">
          <form action="src/api/store-booking.php" method="POST" class="probootstrap-form">
            <div class="form-group">
              <div class="row mb-2">
                <div class="col-md">
                  <label for="oneway"><input type="radio" id="oneway" value="One-Way" name="direction" required>
                    One-Way</label>
                  <label for="round" class="mr-5"><input type="radio" id="round" value="Round-Trip" name="direction"
                      required> Round-Trip</label>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md">
                  <div class="form-group">
                    <label for="id_label_single">From</label>
                    <label for="id_label_single" style="width: 100%;">
                      <select class="js-example-basic-single js-states form-control destination-from"
                        id="id_label_single" name="destination-from" style="width: 100%;" required>
                        <!-- Options will be dynamically added here -->
                      </select>
                  </div>
                </div>
                <div class="col-md">
                  <div class="form-group">
                    <label for="id_label_single">To</label>
                    <label for="id_label_single" style="width: 100%;">
                      <select class="js-example-basic-single js-states form-control destination-to"
                        id="id_label_single2" name="destination-to" style="width: 100%;" required>
                        <!-- Options will be dynamically added here -->
                      </select>
                  </div>
                </div>
              </div>
              <!-- END row -->
              <div class="row mb-3">
                <div class="col-md">
                  <div class="form-group">
                    <label for="probootstrap-date-departure">Departure</label>
                    <div class="probootstrap-date-wrap">
                      <span class="icon ion-calendar"></span>
                      <input type="text" id="date-departure" class="form-control" name="date-departure" placeholder=""
                        required>
                    </div>
                  </div>
                </div>
                <div class="col-md">
                  <div class="form-group">
                    <label for="probootstrap-date-arrival">Arrival</label>
                    <div class="probootstrap-date-wrap">
                      <span class="icon ion-calendar"></span>
                      <input type="text" id="date-arrival" class="form-control" name="date-arrival" placeholder=""
                        required>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row mb-5">
                <!-- Passenger Input with Minus and Plus Buttons -->
                <div class="col-md">
                  <div class="form-group">
                    <label for="passenger-count">Number of Passengers</label>
                    <div class="d-flex align-items-center">
                      <button type="button" class="btn-circle" id="btn-minus">-</button>
                      <span id="passenger-number" class="mx-3">1</span>
                      <button type="button" class="btn-circle" id="btn-plus">+</button>
                      <input type="hidden" id="passenger-count" value="1" min="1" max="45" name="passenger">
                    </div>
                  </div>
                </div>
              </div>
              <!-- END row -->
              <div class="row">
                <div class="col-md">
                  <button type="submit" class="btn btn-primary btn-block">Search</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

  </section>

  <section class="container mt-4">
    <div class="row">
      <!-- First column for reminders -->
      <div class="col-md-8">
        <h5>Reminders:</h5>
        <ul>
          <li>Limited trips are available online as of the moment.</li>
          <li>We only accept payment throught GCash.</li>
          <li>Passengers availing student discounts, senior citizen discounts, and PWD discounts must purchase their
            tickets from our terminal ticket booths.</li>
        </ul>
      </div>

      <!-- Second column for the button -->
      <div class="col-md-4 d-flex align-items-start">
        <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#manage-booking">Manage My
          Bookings</button>
      </div>
    </div>
  </section>

  <!-- END section -->

  <!-- END section -->
  <?php
  include 'src/components/footer.php';
  include 'src/modal/bookings.php';
  ?>
</body>

<!-- Archive Past Schedules-->
<script>
  $(document).ready(function () {
    // Function to archive past schedules
    function archivePastSchedules() {
      $.ajax({
        url: 'admin/api/schedule/archive-schedules.php', // Replace with the path to your PHP script
        type: 'POST',
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            console.log(response.message);
          } else {
            console.error(response.message);
          }
        },
        error: function (xhr, status, error) {
          console.error('AJAX Error: ' + status + ': ' + error);
        }
      });
    }

    // Call the function to archive past schedules
    archivePastSchedules();
  });
</script>

<!-- Cancel Past Bookings -->
<script>
  // Function to update booking statuses
  function updateCancelledBookings() {
    $.ajax({
      url: 'admin/api/booking/cancel-past-booking.php', // PHP script path
      type: 'POST',
      data: { action: 'updateCancelledBookings' }, // Optional data if needed
      success: function (response) {
        console.log(response); // Log the response
      },
      error: function (xhr, status, error) {
        console.error('Error updating booking statuses:', xhr.responseText); // Log detailed error response
      }
    });
  }

  // Call the function when the document is ready
  $(document).ready(function () {
    updateCancelledBookings();
  });
</script>


<!--Fetch Destination From -->
<script>
  $(document).ready(function () {

    $.ajax({
      url: 'admin/api/schedule/fetch-destination-from.php',
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        var select = $('.destination-from');

        // Add a default empty option
        select.append('<option value="" selected disabled>Select Destination From</option>');

        $.each(data, function (index, destination) {
          select.append('<option value="' + destination.from_id + '">' + destination.destination_from + '</option>');
        });
      },
      error: function () {
        console.error('Error fetching destinations');
      }
    });
  });
</script>

<!--Enable or Disable Arrival Date-->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const onewayRadio = document.getElementById('oneway');
    const roundTripRadio = document.getElementById('round');
    const dateArrivalInput = document.getElementById('date-arrival');

    function updateDateArrivalState() {
      if (roundTripRadio.checked) {
        dateArrivalInput.disabled = false;
      } else {
        dateArrivalInput.disabled = true;
        dateArrivalInput.value = ''; // Clear the value when disabled
      }
    }

    // Set initial state based on the default checked radio button
    updateDateArrivalState();

    // Add event listeners to radio buttons
    onewayRadio.addEventListener('change', updateDateArrivalState);
    roundTripRadio.addEventListener('change', updateDateArrivalState);
  });
</script>

<script>
  $(document).ready(function () {
    // Event listener for when destination-from dropdown value changes
    $('.destination-from').on('change', function () {
      var from_id = $(this).val();

      // Check if from_id is valid
      if (from_id) {
        $.ajax({
          url: 'admin/api/schedule/fetch-destination-to.php',
          type: 'POST',
          data: { from_id: from_id },
          dataType: 'json',
          success: function (data) {
            var select = $('.destination-to');
            select.empty(); // Clear existing options

            // Add a default empty option
            select.append('<option value="" selected disabled>Select Destination To</option>');

            $.each(data, function (index, destination) {
              select.append('<option value="' + destination.from_id + '">' + destination.destination_from + '</option>');
            });
            select.trigger('change'); // Update Select2
          },
          error: function () {
            console.error('Error fetching destinations');
          }
        });
      } else {
        $('.destination-to').empty().trigger('change'); // Clear the dropdown if no from_id
      }
    });
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const btnMinus = document.getElementById("btn-minus");
    const btnPlus = document.getElementById("btn-plus");
    const passengerNumber = document.getElementById("passenger-number");
    const passengerCountInput = document.getElementById("passenger-count");

    // Function to update the displayed passenger count
    function updatePassengerCount(newCount) {
      passengerNumber.textContent = newCount;
      passengerCountInput.value = newCount;
    }

    // Event listener for the "+" button
    btnPlus.addEventListener("click", function () {
      let count = parseInt(passengerCountInput.value);
      if (count < 45) { // Check if count is less than the max limit
        count++;
        updatePassengerCount(count);
      }
    });

    // Event listener for the "-" button
    btnMinus.addEventListener("click", function () {
      let count = parseInt(passengerCountInput.value);
      if (count > 1) { // Ensure the count doesn't go below 1
        count--;
        updatePassengerCount(count);
      }
    });
  });
</script>



<!--Fetch Departure Available Dates-->
<script>
  $(document).ready(function () {
    // Trigger when both From and To fields are selected
    $('.destination-from, .destination-to').on('change', function () {
      var from = $('.destination-from').val();
      var to = $('.destination-to').val();

      if (from && to) {
        $.ajax({
          url: 'src/api/fetch-dates-enable.php', // Your API endpoint to fetch dates
          type: 'POST',
          data: {
            destination_from: from,
            destination_to: to
          },
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              var availableDates = response.dates.map(function (date) {
                // Convert date from yyyy-mm-dd to mm/dd/yyyy
                var dateParts = date.split("-");
                return dateParts[1] + '/' + dateParts[2] + '/' + dateParts[0];
              });

              console.log('Available Dates:', availableDates); // Log available dates for debugging

              // Destroy any existing datepicker instance
              $('#date-departure').datepicker('destroy');

              // Reinitialize the datepicker with new available dates and highlighting
              $('#date-departure').datepicker({
                format: 'mm/dd/yyyy', // Match the format used in datepicker
                beforeShowDay: function (date) {
                  var formattedDate = (date.getMonth() + 1).toString().padStart(2, '0') + '/' +
                    date.getDate().toString().padStart(2, '0') + '/' +
                    date.getFullYear();

                  if (availableDates.indexOf(formattedDate) != -1) {
                    // Enable date and apply a green highlight class for available dates
                    return { enabled: true, classes: 'available-date-highlight' };
                  } else {
                    // Disable all other dates
                    return { enabled: false };
                  }
                },
                autoclose: true // Close the calendar after selecting a date
              });
            } else {
              console.error('Error: No success in the response.');
            }
          },
          error: function (xhr, status, error) {
            console.error("Error fetching dates:", error); // Log error for debugging
            console.log(xhr.responseText); // Log server response for deeper debugging
          }
        });
      }
    });
  });
</script>

<!--Fetch Arrival Available Dates-->
<script>
  $(document).ready(function () {
    // Trigger when both From and To fields are selected
    $('.destination-from, .destination-to').on('change', function () {
      var from = $('.destination-from').val();
      var to = $('.destination-to').val();

      if (from && to) {
        $.ajax({
          url: 'src/api/fetch-dates-enable.php', // Your API endpoint to fetch dates
          type: 'POST',
          data: {
            destination_from: to,
            destination_to: from
          },
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              var availableDates = response.dates.map(function (date) {
                // Convert date from yyyy-mm-dd to mm/dd/yyyy
                var dateParts = date.split("-");
                return dateParts[1] + '/' + dateParts[2] + '/' + dateParts[0];
              });

              console.log('Available Dates:', availableDates); // Log available dates for debugging

              // Destroy any existing datepicker instance
              $('#date-arrival').datepicker('destroy');

              // Reinitialize the datepicker with new available dates and highlighting
              $('#date-arrival').datepicker({
                format: 'mm/dd/yyyy', // Match the format used in datepicker
                beforeShowDay: function (date) {
                  var formattedDate = (date.getMonth() + 1).toString().padStart(2, '0') + '/' +
                    date.getDate().toString().padStart(2, '0') + '/' +
                    date.getFullYear();

                  if (availableDates.indexOf(formattedDate) != -1) {
                    // Enable date and apply a green highlight class for available dates
                    return { enabled: true, classes: 'available-date-highlight' };
                  } else {
                    // Disable all other dates
                    return { enabled: false };
                  }
                },
                autoclose: true // Close the calendar after selecting a date
              });
            } else {
              console.error('Error: No success in the response.');
            }
          },
          error: function (xhr, status, error) {
            console.error("Error fetching dates:", error); // Log error for debugging
            console.log(xhr.responseText); // Log server response for deeper debugging
          }
        });
      }
    });
  });
</script>

</html>