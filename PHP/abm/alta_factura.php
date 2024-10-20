<?php
require_once 'db_connection.php';

$respuesta_estado = "Respuesta del servidor para alta factura:";

// Receive form data
$nro_factura = $_POST['nro_factura'];
$cuil_emisor = $_POST['cuil_emisor'];
$cuil_receptor = $_POST['cuil_receptor'];
$monto = $_POST['monto'];
$descripcion = $_POST['descripcion'];
$iva = $_POST['iva'];
$tipo_id = $_POST['tipo_id'];
$fecha = $_POST['fecha'];

// Calculate total
$total = $monto + $iva;

// Insert new factura into the database
$sql = "INSERT INTO factura (nro_factura, cuil_emisor, cuil_receptor, monto, descripcion, iva, total, tipo_id, fecha) 
        VALUES (:nro_factura, :cuil_emisor, :cuil_receptor, :monto, :descripcion, :iva, :total, :tipo_id, :fecha)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':nro_factura', $nro_factura);
$stmt->bindParam(':cuil_emisor', $cuil_emisor);
$stmt->bindParam(':cuil_receptor', $cuil_receptor);
$stmt->bindParam(':monto', $monto);
$stmt->bindParam(':descripcion', $descripcion);
$stmt->bindParam(':iva', $iva);
$stmt->bindParam(':total', $total);
$stmt->bindParam(':tipo_id', $tipo_id);
$stmt->bindParam(':fecha', $fecha);

if ($stmt->execute()) {
    $respuesta_estado .= " Factura insertada exitosamente.";
} else {
    $respuesta_estado .= " Error al insertar la factura.";
}

echo $respuesta_estado;
?>
