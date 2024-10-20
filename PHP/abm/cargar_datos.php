<?php
require_once 'db_connection.php';

header('Content-Type: application/json');  // Ensure the response is JSON

$sql = "SELECT * FROM factura";
$result = mysqli_query($conn, $sql);

$facturas = array();
while ($row = mysqli_fetch_assoc($result)) {
    $facturas[] = $row;
}

echo json_encode($facturas);
?>
