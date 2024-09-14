<?php
if (isset($_SESSION['destroyed']) && $_SESSION['destroyed'] === true) {
    // Redirect to index.php or perform any other action
    header("Location: ../../index.php");
    exit();
}
// Rest of your page code
?>