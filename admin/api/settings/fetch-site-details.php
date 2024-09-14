<?php
    // Fetch the current logo and company name from the database
    $admin_id = $_SESSION['admin'];
    $sql_logo = "SELECT company_name, logo FROM tbladmin WHERE admin_id = ?";
    $stmt_logo = $conn->prepare($sql_logo);
    $stmt_logo->bind_param('i', $admin_id);
    $stmt_logo->execute();
    $stmt_logo->bind_result($company_name, $logo_path);
    $stmt_logo->fetch();
    $stmt_logo->close();
?>