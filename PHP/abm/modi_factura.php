<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nro_factura = mysqli_real_escape_string($conn, $_POST['nro_factura']);
    $cuil_emisor = mysqli_real_escape_string($conn, $_POST['cuil_emisor']);
    $cuil_receptor = mysqli_real_escape_string($conn, $_POST['cuil_receptor']);
    $monto = mysqli_real_escape_string($conn, $_POST['monto']);
    $iva = mysqli_real_escape_string($conn, $_POST['iva']);
    $total = $monto + $iva;
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $fecha = mysqli_real_escape_string($conn, $_POST['fecha']);

    $sql = "UPDATE factura SET nro_factura='$nro_factura', cuil_emisor='$cuil_emisor', cuil_receptor='$cuil_receptor', monto='$monto', iva='$iva', total='$total', descripcion='$descripcion', fecha='$fecha' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "Factura modificada exitosamente.";
    } else {
        echo "Error al modificar la factura: " . mysqli_error($conn);
    }
}
?>
