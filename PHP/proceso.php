<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturing the form data
    $tipo_factura = $_POST['tipo_factura'];
    $cuil_emisor = $_POST['cuil_emisor'];
    $nombre_emisor = $_POST['nombre_emisor'];
    $cuil_receptor = $_POST['cuil_receptor'];
    $nombre_receptor = $_POST['nombre_receptor'];
    $nro_factura = $_POST['nro_factura'];
    $monto = $_POST['monto'];
    $descripcion = $_POST['descripcion'];
    $iva = $_POST['iva'];
    $total = $_POST['total'];

    // Database connection
    $conn = new mysqli('localhost', 'username', 'password', 'facturacion_db');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert into the emisor_receptor table
    $sql_emisor_receptor = "INSERT INTO emisor_receptor (nombre_emisor, nombre_receptor, cuil_emisor, cuil_receptor)
                            VALUES ('$nombre_emisor', '$nombre_receptor', '$cuil_emisor', '$cuil_receptor')";
    
    if ($conn->query($sql_emisor_receptor) === TRUE) {
        $emisor_receptor_id = $conn->insert_id; // Get the inserted id for foreign key
    } else {
        echo "Error: " . $sql_emisor_receptor . "<br>" . $conn->error;
        exit;
    }

    // Insert into the factura table
    $sql_factura = "INSERT INTO factura (nro_factura, cuil_emisor, cuil_receptor, monto, descripcion, iva, total, tipo_id)
                    VALUES ('$nro_factura', '$cuil_emisor', '$cuil_receptor', '$monto', '$descripcion', '$iva', '$total', '$tipo_factura')";
    
    if ($conn->query($sql_factura) === TRUE) {
        echo "Factura generada exitosamente.";
    } else {
        echo "Error: " . $sql_factura . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
