<?php
session_start();
$_SESSION = []; // Clear session variables
session_destroy(); // Destroy the session
header('Location: FormLogin.php'); // Redirect to login page
exit();
?>
