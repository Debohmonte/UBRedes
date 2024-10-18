<?php
include 'conexion.php'; // Incluimos la conexión a la base de datos

$filtros = [];
$where = [];

// Filtros para cada campo
if (!empty($_GET['filterNroFactura'])) {
    $where[] = "nro_factura LIKE ?";
    $filtros[] = '%' . $_GET['filterNroFactura'] . '%';
}
if (!empty($_GET['filterEmisor'])) {
    $where[] = "emisor LIKE ?";
    $filtros[] = '%' . $_GET['filterEmisor'] . '%';
}
if (!empty($_GET['filterReceptor'])) {
    $where[] = "receptor LIKE ?";
    $filtros[] = '%' . $_GET['filterReceptor'] . '%';
}
if (!empty($_GET['filterMonto'])) {
    $where[] = "monto = ?";
    $filtros[] = $_GET['filterMonto'];
}
if (!empty($_GET['filterDescripcion'])) {
    $where[] = "descripcion LIKE ?";
    $filtros[] = '%' . $_GET['filterDescripcion'] . '%';
}
if (!empty($_GET['filterIVA'])) {
    $where[] = "iva = ?";
    $filtros[] = $_GET['filterIVA'];
}
if (!empty($_GET['filterFecha'])) {
    $where[] = "fecha = ?";
    $filtros[] = $_GET['filterFecha'];
}

// Construcción de la consulta con filtros
$sql = "SELECT * FROM facturas";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$stmt = $conn->prepare($sql);
$stmt->execute($filtros);
$facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode(['facturas' => $facturas]);
?>
