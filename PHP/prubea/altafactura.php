<?php
// CONEXION BASE DE DATOS
$dbhost = 'localhost';
$dbuser = 'c2660848_UBRedes';
$dbpass = 'po06kiSOto';
$dbname = 'c2660848_UBRedes';

// CREA CONEXION
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// VALIDA CONEXION
if (!$conn) {
    die(json_encode(["error" => "Conexion fallida: " . mysqli_connect_error()]));
}

// OBTENER DATOS DEL FORMULARIO
$nro_factura = mysqli_real_escape_string($conn, $_POST['nro_factura']);
$emisor = mysqli_real_escape_string($conn, $_POST['emisor']);
$receptor = mysqli_real_escape_string($conn, $_POST['receptor']);
$monto = floatval($_POST['monto']);
$descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
$iva = floatval($_POST['iva']);
$tipo_id = mysqli_real_escape_string($conn, $_POST['tipo_id']);
$fecha = mysqli_real_escape_string($conn, $_POST['fecha']);

// QUERY DE INSERCIÓN
$sql = "INSERT INTO factura (nro_factura, cuil_emisor, cuil_receptor, monto, descripcion, iva, total, tipo_id, fecha) 
        VALUES ('$nro_factura', '$emisor', '$receptor', '$monto', '$descripcion', '$iva', '$monto', '$tipo_id', '$fecha')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Error al insertar la factura: " . mysqli_error($conn)]);
}

// CIERRA CONEXION
mysqli_close($conn);
?>
