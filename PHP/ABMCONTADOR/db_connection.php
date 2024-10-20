<?php
$host = 'localhost'; 
$username = 'c2660848_UBRedes'; 
$password = 'po06kiSOto';  
$dbname = 'c2660848_UBRedes';  


$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
