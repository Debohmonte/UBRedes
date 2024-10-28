<?php
session_start(); // Start the session

// Regenerate session ID to prevent session fixation attacks
if (!isset($_SESSION['created'])) {
    $_SESSION['created'] = time(); // Store the time when the session was created
} else if (time() - $_SESSION['created'] > 1800) { // Check if the session is older than 30 minutes
    // Session is old, regenerate ID
    session_regenerate_id(true); // Regenerate session ID and delete old session
    $_SESSION['created'] = time(); // Update creation time
}

// Optional: Set session cookie parameters for increased security
session_set_cookie_params([
    'lifetime' => 0, // Session cookie lasts until the browser is closed
    'path' => '/', // Available within the entire domain
    'domain' => $_SERVER['HTTP_HOST'], // Domain
    'secure' => true, // Send cookie only over HTTPS
    'httponly' => true, // Accessible only through HTTP protocol
    'samesite' => 'Strict', // Prevent CSRF attacks
]);
?>
