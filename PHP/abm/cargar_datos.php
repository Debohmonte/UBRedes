<?php
require_once 'db_connection.php';

// Send JSON response header
header('Content-Type: application/json');

// Prepare SQL query to get all invoices (facturas)
$sql = "SELECT * FROM factura";  // Replace with the actual table name
$result = $conn->query($sql);

$facturas = array();

// Check if any rows are returned
if ($result->num_rows > 0) {
    // Fetch rows and store in the array
    while ($row = $result->fetch_assoc()) {
        $facturas[] = $row;
    }
    // Return the result as a JSON response
    echo json_encode($facturas);
} else {
    echo json_encode([]);  // Return an empty array if no records found
}

$conn->close();  // Close the database connection
?>
