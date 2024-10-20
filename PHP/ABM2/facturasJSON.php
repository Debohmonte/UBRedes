<?php
include 'conexion.php'; // Asegúrate de que la conexión a la base de datos está incluida

try {
    $filtros = [];
    $where = [];

    // Filtros para cada campo (si son enviados)
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
    $facturas = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Devolver el resultado en formato JSON
    header('Content-Type: application/json');
    echo json_encode(['facturas' => $facturas]);

} catch (Exception $e) {
    // Devolver el error en formato JSON si algo falla
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
?>
