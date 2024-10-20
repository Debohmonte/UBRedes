<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $nro_factura = $_POST['nro_factura'];
    $cuil_emisor = $_POST['cuil_emisor'];
    $cuil_receptor = $_POST['cuil_receptor'];
    $monto = $_POST['monto'];
    $iva = $_POST['iva'];
    $total = $_POST['total'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];

    // Insert data into the database
    $sql = "INSERT INTO factura (nro_factura, cuil_emisor, cuil_receptor, monto, iva, total, descripcion, fecha)
            VALUES ('$nro_factura', '$cuil_emisor', '$cuil_receptor', '$monto', '$iva', '$total', '$descripcion', '$fecha')";

    if (mysqli_query($conn, $sql)) {
        // Perform the redirect before any output
        header("Location: factura.html");
        exit(); // Ensure the script stops here to avoid any output
    } else {
        echo "Error al insertar la factura: " . mysqli_error($conn);
    }
}
