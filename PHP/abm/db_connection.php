<?php
// Database connection
$host = 'localhost';     // Database host (usually localhost)
$dbname = 'c2660848_UBRedes';  // Database name
$username = 'root';      // Database username
$password = '';          // Database password (leave blank if no password)

// PDO connection
try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Enable exceptions for errors
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
