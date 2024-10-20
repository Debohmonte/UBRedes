<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nro_factura = $_POST['nro_factura'];
    $cuil_emisor = $_POST['cuil_emisor'];
    $cuil_receptor = $_POST['cuil_receptor'];
    $monto = $_POST['monto'];
    $iva = $_POST['iva'];
    $total = $_POST['total'];
    $descripcion = $_POST['descripcion'];  // Use 'descripcion' instead of 'tipo'
    $fecha = $_POST['fecha'];

    $sql = "INSERT INTO factura (nro_factura, cuil_emisor, cuil_receptor, monto, iva, total, descripcion, fecha)
            VALUES ('$nro_factura', '$cuil_emisor', '$cuil_receptor', '$monto', '$iva', '$total', '$descripcion', '$fecha')";

    if (mysqli_query($conn, $sql)) {
        echo "Factura insertada correctamente.";
    } else {
        echo "Error al insertar la factura: " . mysqli_error($conn);
    }

    header("Location: factura.html");
    exit();
}
?>
