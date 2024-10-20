<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nro_factura = mysqli_real_escape_string($conn, $_POST['nro_factura']);
    $cuil_emisor = mysqli_real_escape_string($conn, $_POST['cuil_emisor']);
    $cuil_receptor = mysqli_real_escape_string($conn, $_POST['cuil_receptor']);
    $monto = mysqli_real_escape_string($conn, $_POST['monto']);
    $iva = mysqli_real_escape_string($conn, $_POST['iva']);

    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $fecha = mysqli_real_escape_string($conn, $_POST['fecha']);

    $sql = "INSERT INTO factura (nro_factura, cuil_emisor, cuil_receptor, monto, iva,  descripcion, fecha)
            VALUES ('$nro_factura', '$cuil_emisor', '$cuil_receptor', '$monto', '$iva', '$descripcion', '$fecha')";

    if (mysqli_query($conn, $sql)) {
        header("Location: factura.html");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
