<?php
include 'conexion.php';

try {
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

    // Orden y dirección
    $orden = $_GET['orden'] ?? 'nro_factura';
    $direccion = $_GET['direccion'] ?? 'ASC';

    // Construcción de la consulta con filtros y orden
    $sql = "SELECT * FROM factura";
    if (!empty($where)) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }
    $sql .= " ORDER BY $orden $direccion";

    // Ejecutar consulta y verificar errores
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        throw new Exception("Error en la preparación de la consulta: " . mysqli_error($conn));
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $factura = mysqli_fetch_all($result, MYSQLI_ASSOC);

    header('Content-Type: application/json');
    echo json_encode(['factura' => $factura]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
