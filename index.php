<?php
  include_once 'models/conn.php';
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
            <form action="#" class="probootstrap-form">
              <div class="form-group">
                <div class="row mb-2">
                  <div class="col-md">
                    <label for="oneway"><input type="radio" id="oneway" name="direction">  Oneway</label>
                    <label for="round" class="mr-5"><input type="radio" id="round" name="direction">  Round </label>
                  </div>
                </div>
                <div class="row mb-3">
                  <?php
                    // Fetch data from tblroutefrom
                    $sql = "SELECT destination_from FROM tblroutefrom";
                    $result = $conn->query($sql);
                    ?>

                  <div class="col-md">
                    <div class="form-group">
                        <label for="id_label_single">From</label>
                        <label for="id_label_single" style="width: 100%;">
                            <select class="js-example-basic-single js-states form-control" id="id_label_single" style="width: 100%;">
                                <?php
                                // Check if there are results
                                if ($result->num_rows > 0) {
                                    // Output data for each row
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['from_id'] . "'>" . $row['destination_from'] . "</option>";
                                    }
                                } else {
                                    echo "<option>No destinations available</option>";
                                }
                                ?>
                            </select>
                        </label>
                    </div>
                  </div>
                  <?php
                    // Fetch data from tblroutefrom
                    $sql = "SELECT destination_from FROM tblroutefrom";
                    $result = $conn->query($sql);
                    ?>

                  <div class="col-md">
                    <div class="form-group">
                        <label for="id_label_single">From</label>
                        <label for="id_label_single" style="width: 100%;">
                            <select class="js-example-basic-single js-states form-control" id="id_label_single2" style="width: 100%;">
                                <?php
                                // Check if there are results
                                if ($result->num_rows > 0) {
                                    // Output data for each row
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['from_id'] . "'>" . $row['destination_from'] . "</option>";
                                    }
                                } else {
                                    echo "<option>No destinations available</option>";
                                }
                                ?>
                            </select>
                        </label>
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
                        <input type="text" id="probootstrap-date-departure" class="form-control" placeholder="">
                      </div>
                    </div>
                  </div>
                  <div class="col-md">
                    <div class="form-group">
                      <label for="probootstrap-date-arrival">Arrival</label>
                      <div class="probootstrap-date-wrap">
                        <span class="icon ion-calendar"></span> 
                        <input type="text" id="probootstrap-date-arrival" class="form-control" placeholder="">
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
                        <input type="hidden" id="passenger-count" value="1" min="1">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END row -->
                <div class="row">
                  <div class="col-md">
                    <a href="src/pages/schedules.php" type="submit" class="btn btn-primary btn-block">Search</a>
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
</html>