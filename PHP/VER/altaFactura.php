<?php
require('conexion.php');  // Archivo de conexión a la base de datos

$nro_factura = $_POST['nro_factura'];
$cuil_emisor = $_POST['cuil_emisor'];
$cuil_receptor = $_POST['cuil_receptor'];
$monto = $_POST['monto'];
$descripcion = $_POST['descripcion'];
$iva = $_POST['iva'];
$total = $_POST['total'];
$tipo_id = $_POST['tipo_id'];
$fecha = $_POST['fecha'];

$query = "INSERT INTO factura (nro_factura, cuil_emisor, cuil_receptor, monto, descripcion, iva, total, tipo_id, fecha) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('sssssssss', $nro_factura, $cuil_emisor, $cuil_receptor, $monto, $descripcion, $iva, $total, $tipo_id, $fecha);
$resultado = $stmt->execute();

if ($resultado) {
    echo "Factura insertada correctamente.";
} else {
    echo "Error al insertar la factura: " . $conn->error;
}
?>
