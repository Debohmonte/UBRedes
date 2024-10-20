<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'db_connection.php';

header('Content-Type: application/json');

$sql = "SELECT * FROM factura";
$result = mysqli_query($conn, $sql);

$facturas = array();

if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $facturas[] = $row;
    }
    echo json_encode($facturas);
} else {
    echo json_encode([]);  //aaray vacio si no hay facturas

mysqli_close($conn);
?>
