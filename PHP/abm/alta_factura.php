<?php
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

    // Handle PDF upload
    $pdf_path = null;
    if (!empty($_FILES['pdf_file']['name'])) {
        $upload_dir = 'uploads/';
        $pdf_filename = basename($_FILES['pdf_file']['name']);
        $target_file = $upload_dir . $pdf_filename;

        if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $target_file)) {
            $pdf_path = $target_file;  // Save the file path to store in the DB
        }
    }

    // Insert data into the database
    $sql = "INSERT INTO factura (nro_factura, cuil_emisor, cuil_receptor, monto, iva, total, descripcion, fecha, pdf_path)
            VALUES ('$nro_factura', '$cuil_emisor', '$cuil_receptor', '$monto', '$iva', '$total', '$descripcion', '$fecha', '$pdf_path')";

    if (mysqli_query($conn, $sql)) {
        header("Location: factura.html");
        exit();
    } else {
        echo "Error al insertar la factura: " . mysqli_error($conn);
    }
}
?>
