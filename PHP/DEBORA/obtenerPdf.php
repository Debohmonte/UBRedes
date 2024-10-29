<?php
include('./db.php'); 


try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    exit;
}


$id = $_GET['id'];
$stmt = $conn->prepare("SELECT pdf FROM factura WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$factura = $stmt->fetch(PDO::FETCH_ASSOC);

if ($factura) {
    echo json_encode(["pdf" => base64_encode($factura['pdf'])]); //pdf en 64 y envia json 
} else {
    echo json_encode(["status" => "error", "message" => "Factura no encontrada."]);
}