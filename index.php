<?php
  include_once 'models/conn.php';
  include_once 'src/api/destroy-session.php';
?>

<!DOCTYPE html>
<html lang="en">
	<?php
    include 'components/header.php'
  ?>
	<body>

    <?php include 'src/components/nav.php'?>

    <!-- END nav -->

    <section class="probootstrap-cover overflow-hidden relative"  style="background-image: url('assets/images/bg_1.jpg');" data-stellar-background-ratio="0.5"  id="section-home">
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
                    <label for="oneway"><input type="radio" id="oneway" value="One-Way" name="direction" required>  One-Way</label>
                    <label for="round" class="mr-5"><input type="radio" id="round" value="Round-Trip" name="direction" required>  Round-Trip</label>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md">
                    <div class="form-group">
                      <label for="id_label_single">From</label>
                      <label for="id_label_single" style="width: 100%;">
                        <select class="js-example-basic-single js-states form-control destination-from" id="id_label_single" name="destination-from" style="width: 100%;" required>
                            <!-- Options will be dynamically added here -->
                        </select> 
                    </div>
                  </div>
                  <div class="col-md">
                    <div class="form-group">
                      <label for="id_label_single">To</label>
                      <label for="id_label_single" style="width: 100%;">
                        <select class="js-example-basic-single js-states form-control destination-to" id="id_label_single2" name="destination-to" style="width: 100%;" required>
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
                        <input type="text" id="probootstrap-date-departure" class="form-control" name="date-departure" placeholder="" required>
                      </div>
                    </div>
                  </div>
                  <div class="col-md">
                    <div class="form-group">
                      <label for="probootstrap-date-arrival">Arrival</label>
                      <div class="probootstrap-date-wrap">
                        <span class="icon ion-calendar"></span> 
                        <input type="text" id="probootstrap-date-arrival" class="form-control" name="date-arrival" placeholder="" required>
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
                        <input type="hidden" id="passenger-count" value="1" min="1" name="passenger">
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
    <!-- END section -->
  
    <!-- END section -->
     <?php
        include 'src/components/footer.php'
     ?>
	</body>

  <script>
    $(document).ready(function() {

        $.ajax({
            url: 'admin/api/schedule/fetch-destination-from.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var select = $('.destination-from');

                // Add a default empty option
                select.append('<option value="" selected disabled>Select Destination From</option>');

                $.each(data, function(index, destination) {
                    select.append('<option value="' + destination.from_id + '">' + destination.destination_from + '</option>');
                });
            },
            error: function() {
                console.error('Error fetching destinations');
            }
        });
    });
    </script>

    <!--Enable or Disable Arrival Date-->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
          const onewayRadio = document.getElementById('oneway');
          const roundTripRadio = document.getElementById('round');
          const dateArrivalInput = document.getElementById('probootstrap-date-arrival');

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
    $(document).ready(function() {
        // Event listener for when destination-from dropdown value changes
        $('.destination-from').on('change', function() {
            var from_id = $(this).val();
            
            // Check if from_id is valid
            if (from_id) {
                $.ajax({
                    url: 'admin/api/schedule/fetch-destination-to.php',
                    type: 'POST',
                    data: {from_id: from_id},
                    dataType: 'json',
                    success: function(data) {
                        var select = $('.destination-to');
                        select.empty(); // Clear existing options

                        // Add a default empty option
                        select.append('<option value="" selected disabled>Select Destination To</option>');

                        $.each(data, function(index, destination) {
                            select.append('<option value="' + destination.from_id + '">' + destination.destination_from + '</option>');
                        });
                        select.trigger('change'); // Update Select2
                    },
                    error: function() {
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
      document.getElementById('btn-plus').addEventListener('click', function() {
          let passengerCount = parseInt(document.getElementById('passenger-count').value);
          passengerCount++;
          document.getElementById('passenger-count').value = passengerCount;
          document.getElementById('passenger-number').textContent = passengerCount;
      });

      document.getElementById('btn-minus').addEventListener('click', function() {
          let passengerCount = parseInt(document.getElementById('passenger-count').value);
          if (passengerCount > 1) {
              passengerCount--;
              document.getElementById('passenger-count').value = passengerCount;
              document.getElementById('passenger-number').textContent = passengerCount;
          }
      });
    </script>
</html>