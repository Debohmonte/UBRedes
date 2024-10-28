<?php
include('./db.php');

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    exit;
}

$Id = $_POST['id'];
$nro_factura = $_POST['nro_factura'];
$cuil_emisor = $_POST['cuil_emisor'];
$cuil_receptor = $_POST['cuil_receptor'];
$monto = $_POST['monto'];
$iva = $_POST['iva'];
$descripcion = $_POST['descripcion'];

// Obtener  PDF
$pdf = null;
if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) {
    $pdf = file_get_contents($_FILES['pdf']['tmp_name']);
}

$sql = "UPDATE factura SET nro_factura=:nro_factura, cuil_emisor=:cuil_emisor, cuil_receptor=:cuil_receptor, monto=:monto, iva=:iva, descripcion=:descripcion" . ($pdf ? ", pdf=:pdf" : "") . " WHERE id=:id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $Id);
$stmt->bindParam(':nro_factura', $nro_factura);
$stmt->bindParam(':cuil_emisor', $cuil_emisor);
$stmt->bindParam(':cuil_receptor', $cuil_receptor);
$stmt->bindParam(':monto', $monto);
$stmt->bindParam(':iva', $iva);
$stmt->bindParam(':descripcion', $descripcion);

$stmt->execute();

echo json_encode(["status" => "success", "message" => "Factura actualizada exitosamente"]);
?>