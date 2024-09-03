<?php
// Start the session if it's not already started
session_start();

// Clear all session variables
$_SESSION = [];

// If you want to destroy the session entirely, uncomment the following lines
if (ini_get("session.use_cookies")) {
    // Get session parameters
    $params = session_get_cookie_params();
    
    // Delete the session cookie
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();
?>
