<?php

// Start the session to ensure access to session variables
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Clear the session cookie (optional but recommended)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, 
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]
    );
}

// Redirect to the login page or homepage
header("Location: ../../index.php");
exit;
?>
