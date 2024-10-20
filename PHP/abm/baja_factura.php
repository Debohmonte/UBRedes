<?php
require_once 'db_connection.php';

$id = $_GET['id'];

$sql = "DELETE FROM factura WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    echo "Factura eliminada correctamente.";
} else {
    echo "Error al eliminar la factura.";
}
?>
