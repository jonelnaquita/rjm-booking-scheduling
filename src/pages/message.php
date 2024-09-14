<!DOCTYPE html>
<html lang="en">
<?php
    include '../components/header.php';
    include '../api/destroy-session.php';
?>
<body>
    <?php
        include '../components/nav.php';
    ?>

    <head>
        <link rel="stylesheet" href="../../assets/css/message.css">
    </head>

<div class="container mt-5">
    <!-- Step 2 Row -->
    <div class="row step-row">
        <div class="col-12">
            <b>All Done</b>
        </div>
    </div>

    <?php
        // Retrieve passenger_id from the URL
        $passenger_id = isset($_GET['passenger_id']) ? htmlspecialchars($_GET['passenger_id']) : 'N/A';
    ?>

    <div class="col-12">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <!-- Check Icon -->
                <div class="mb-3">
                    <i class="fa fa-check" style="font-size: 4rem; color: #28a745;"></i>
                </div>
                <h5 class="card-title"><b>All Done!</b></h5>
                <p class="card-text">
                    Your booking was successfully completed.<br>
                    We will send you an email once your payment and booking are verified.
                </p>
                <h3><strong>Passenger ID: </strong><span id="passenger-id"><?php echo $passenger_id; ?></span></h3>
                <p>Note: Please keep this ID for future reference.</p>

                <a href="../../index.php" class="btn btn-primary">DONE</a>
            </div>
        </div>
    </div>

</div>

<?php
    include '../components/footer.php'
?>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Flag to check if this is the first load of the page
        var isFirstLoad = !sessionStorage.getItem('messagePageVisited');
        
        if (isFirstLoad) {
            // Mark that the page has been visited
            sessionStorage.setItem('messagePageVisited', 'true');
            
            // Replace the current history entry
            history.replaceState(null, '', location.href);
            
            // Add a new history entry
            history.pushState(null, '', location.href);
        }

        // Handle navigation events
        window.addEventListener('popstate', function() {
            window.location.href = '../../../index.php';
        });

        // Clear the flag when leaving the page
        window.addEventListener('beforeunload', function() {
            sessionStorage.removeItem('messagePageVisited');
        });
    });
</script>

</html>