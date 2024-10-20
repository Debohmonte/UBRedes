<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_factura = mysqli_real_escape_string($conn, $_POST['id_factura']);
    $nro_factura = mysqli_real_escape_string($conn, $_POST['nro_factura']);
    $cuil_emisor = mysqli_real_escape_string($conn, $_POST['cuil_emisor']);
    $cuil_receptor = mysqli_real_escape_string($conn, $_POST['cuil_receptor']);
    $monto = mysqli_real_escape_string($conn, $_POST['monto']);
    $iva = mysqli_real_escape_string($conn, $_POST['iva']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $fecha = mysqli_real_escape_string($conn, $_POST['fecha']);

    $sql = "UPDATE factura SET nro_factura='$nro_factura', cuil_emisor='$cuil_emisor', cuil_receptor='$cuil_receptor', monto='$monto', iva='$iva',  descripcion='$descripcion', fecha='$fecha' WHERE id='$id_factura'";

    if (mysqli_query($conn, $sql)) {
        header("Location: factura.html"); 
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
