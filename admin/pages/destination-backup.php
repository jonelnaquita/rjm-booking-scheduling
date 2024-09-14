<!DOCTYPE html>
<html lang="en">
<?php
include '../api/session.php';
    include '../../models/conn.php';
    include '../components/header.php';
?>

<head>

    <link rel="stylesheet" href="../assets/css/destination-tab.css">
</head>
<body>

    <div class="container-scroller">
        <!--Include Navigation Bar-->
        <?php include '../components/navbar.php'; ?>
        <!--End-->

        <div class="container-fluid page-body-wrapper">
            <!-- Include Sidebar-->
            <?php
                include '../components/sidebar.php';
            ?>


            <div class="main-panel">
                <div class="content-wrapper">

                    <!-- Tab Indicator or Title -->
                    <h3 class="tab-title">Destination Overview</h3>

                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-primary btn-icon-text">
                                <i class="ti-plus btn-icon-prepend"></i> Add Destinations
                            </button>
                        </div>
                    </div>

                    <?php
                        $sql = "SELECT * FROM tblroutefrom";
                        $result = $conn->query($sql);
                    ?>

                    <div class="row destination-section">
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <div class="col-lg-2">
                                <div class="card card-margin">
                                    <div class="card-body pt-0">
                                        <div class="widget-49">
                                            <h5 class="card-title"><?php echo $row['destination_from']; ?></h5>
                                            <div class="card-description" style="display: none;">
                                                <p>This is a random description for <?php echo $row['destination_from']; ?>.</p>
                                                <div class="widget-49-meeting-action">
                                                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#destination-modal" data-pickup-id="<?php echo $row['from_id']; ?>">Add</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="widget-49-meeting-action">
                                                    <button class="btn btn-sm btn-outline-primary" onclick="toggleCard(this)">View Drop Location</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                </div>

            <?php
                include '../modal/destination-modal.php';
            ?>

            <!--Include Footer -->
            <?php
                include '../components/footer.php';
            ?>

            </div>
        </div>
      <!-- page-body-wrapper ends -->
    </div>
</body>

<script>
function toggleCard(button) {
    var card = button.closest('.card');
    var description = card.querySelector('.card-description');
    if (description.style.display === "none") {
        description.style.display = "block";
    } else {
        description.style.display = "none";
    }
}
</script>

<script>
    $(document).ready(function() {
        $('.destination-from').select2({
            dropdownParent: $('#destination-modal'),
            width: '100%' // Ensure full width
        });

        $('.destination-to').select2({
            dropdownParent: $('#destination-modal'),
            width: '100%' // Ensure full width
        });
    });
</script>

<!-- Button to Open Modal with pickup_id -->

<script>
    // When the modal is shown, set the pickup-location input value
    $('#destination-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var pickupId = button.data('pickup-id'); // Extract info from data-* attributes
        var modal = $(this);
        modal.find('#pickup-location').val(pickupId);
    });
</script>



</script>

<script>
    function submitForm() {
        // Get the value of the pick-up location (from_id)
        const fromId = document.getElementById('pickup-location').value;
        
        // Get the selected drop-off locations
        const dropOffSelect = document.querySelector('.destination-from');
        const dropOffLocations = Array.from(dropOffSelect.selectedOptions).map(option => option.value);

        // Prepare the data to be sent
        const data = {
            pickup_id: fromId,
            drop_off: dropOffLocations
        };

        // AJAX request to send the data to the server
        fetch('../api/insert-dropoff.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('Drop-off locations added successfully!');
                location.reload(); // Optionally reload the page to reflect changes
            } else {
                alert('Failed to add drop-off locations.');
            }
        })
        .catch(error => console.error('Error:', error));
    }

</script>

</html>