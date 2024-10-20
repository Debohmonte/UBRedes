<?php
ini_set('display_errors', 1);  // Display errors
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'db_connection.php';

// Ensure the response is JSON
header('Content-Type: application/json');

// Query to retrieve all invoices
$sql = "SELECT * FROM factura";
$result = mysqli_query($conn, $sql);

// Initialize an array to hold invoice data
$facturas = array();

if ($result->num_rows > 0) {
    // Fetch each row as an associative array and add it to the $facturas array
    while ($row = mysqli_fetch_assoc($result)) {
        $facturas[] = $row;
    }
    // Encode the array as JSON and return it
    echo json_encode($facturas);
} else {
    // Return an empty array if no invoices are found
    echo json_encode([]);
}

mysqli_close($conn);  // Close the database connection
?>
