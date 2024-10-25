<?php
require_once 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM factura WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Factura eliminadda correctamente.";
    } else {
        echo "Error al eliminar la factura.";
    }

    $stmt->close();
} else {
    echo "No se proporcionó el ID de la factura.";
}

$conn->close();
?>
