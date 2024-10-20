<?php
// Replace with your actual database connection details
$dbhost = 'localhost';
	$dbuser = 'c2660848_UBRedes';
	$dbpass = 'po06kiSOto';
	$dbname = 'c2660848_UBRedes';

$conn = new mysqli($host, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

