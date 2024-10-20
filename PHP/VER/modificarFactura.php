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

$query = "UPDATE factura SET cuil_emisor = ?, cuil_receptor = ?, monto = ?, descripcion = ?, iva = ?, total = ?, tipo_id = ?, fecha = ? 
          WHERE nro_factura = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('sssssssss', $cuil_emisor, $cuil_receptor, $monto, $descripcion, $iva, $total, $tipo_id, $fecha, $nro_factura);
$resultado = $stmt->execute();

if ($resultado) {
    echo "Factura modificada correctamente.";
} else {
    echo "Error al modificar la factura: " . $conn->error;
}
?>
