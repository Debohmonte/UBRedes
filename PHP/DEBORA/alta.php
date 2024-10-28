<?php
include('./db.php');

header('Content-Type: application/json'); // respuesta  JSON

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Error de conexión: " . $e->getMessage()]);
    exit;
}

// datos form
$nro_factura = $_POST['nro_factura'] ?? null;
$cuil_emisor = $_POST['cuil_emisor'] ?? null;
$cuil_receptor = $_POST['cuil_receptor'] ?? null;
$monto = $_POST['monto'] ?? null;
$iva = $_POST['iva'] ?? null;
$descripcion = $_POST['descripcion'] ?? null;
$fecha = $_POST['fecha'] ?? null; 

// V
if (!$nro_factura || !$cuil_emisor || !$cuil_receptor || !$monto || !$iva || !$descripcion || !$fecha) {
    echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios."]);
    exit;
}

// 
$pdf = null;
if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) {
    $pdf = file_get_contents($_FILES['pdf']['tmp_name']);
}

// aactulizr
try {
    $sql = "INSERT INTO factura (nro_factura, cuil_emisor, cuil_receptor, monto, iva, descripcion, fecha, pdf) 
            VALUES (:nro_factura, :cuil_emisor, :cuil_receptor, :monto, :iva, :descripcion, :fecha, :pdf)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':nro_factura', $nro_factura);
    $stmt->bindParam(':cuil_emisor', $cuil_emisor);
    $stmt->bindParam(':cuil_receptor', $cuil_receptor);
    $stmt->bindParam(':monto', $monto);
    $stmt->bindParam(':iva', $iva);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':fecha', $fecha); 
    $stmt->bindParam(':pdf', $pdf, PDO::PARAM_LOB);

    // Eje
    $stmt->execute();
    echo json_encode(["status" => "success", "message" => "Factura creada exitosamente"]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Error al crear factura: " . $e->getMessage()]);
}