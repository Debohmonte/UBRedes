<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nro_factura = $_POST['nro_factura'];
    $cuil_emisor = $_POST['cuil_emisor'];
    $cuil_receptor = $_POST['cuil_receptor'];
    $monto = $_POST['monto'];
    $iva = $_POST['iva'];
    $total = $_POST['total'];
    $tipo = $_POST['tipo'];
    $fecha = $_POST['fecha'];

    $sql = "INSERT INTO factura (nro_factura, cuil_emisor, cuil_receptor, monto, iva, total, tipo, fecha)
            VALUES ('$nro_factura', '$cuil_emisor', '$cuil_receptor', '$monto', '$iva', '$total', '$tipo', '$fecha')";

    if (mysqli_query($conn, $sql)) {
        echo "Factura insertada correctamente.";
    } else {
        echo "Error al insertar la factura: " . mysqli_error($conn);
    }

    header("Location: factura.html");  // Redirect after submission
    exit();
}
?>
