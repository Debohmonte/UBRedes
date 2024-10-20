<?php
require_once 'db_connection.php';

$sql = "SELECT * FROM factura";  // Replace with your actual invoice table
$result = mysqli_query($conn, $sql);

$facturas = array();
while ($row = mysqli_fetch_assoc($result)) {
    $facturas[] = $row;
}

echo json_encode($facturas);
?>
