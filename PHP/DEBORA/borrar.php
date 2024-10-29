<?php
include('./db.php');

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    exit;
}

$Id = $_POST['id']; // resive el id de la factura a eliminar 
$sql = "DELETE FROM factura WHERE id=:id"; // consulta al sql 
$stmt = $conn->prepare($sql); // prepara para evitar inyesiones ssql
$stmt->bindParam(':id', $Id); //vincula id con variable id
$stmt->execute(); // ejecuta elimionado

echo json_encode(["status" => "success", "message" => "Factura borrada exitosamente"]);
?>