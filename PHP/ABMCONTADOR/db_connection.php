<?php
$host = 'localhost';  // Your database host
$username = 'c2660848_UBRedes';  // Your database username
$password = 'po06kiSOto';  // Your database password
$dbname = 'c2660848_UBRedes';  // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
