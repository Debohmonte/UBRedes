<?php
require('conexion.php');  // Archivo de conexión a la base de datos

$nro_factura = $_GET['nro_factura'];

$query = "DELETE FROM factura WHERE nro_factura = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $nro_factura);
$resultado = $stmt->execute();

if ($resultado) {
    echo "Factura eliminada correctamente.";
} else {
    echo "Error al eliminar la factura: " . $conn->error;
}
?>
