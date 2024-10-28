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
$sql = "DELETE FROM factura WHERE id=:id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $Id);
$stmt->execute();

echo json_encode(["status" => "success", "message" => "Factura borrada exitosamente"]);
?>