<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection variables
$host = 'localhost'; 
$username = 'c2660848_UBRedes'; // Corrected variable
$password = 'po06kiSOto';  // Corrected password
$dbname = 'c2660848_UBRedes';  

try {
    // Use $username instead of $user for database connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connected successfully!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
