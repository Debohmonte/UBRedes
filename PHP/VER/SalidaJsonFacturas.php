<?php
header('Content-Type: application/json');
require('conexion.php');  // Archivo de conexión a la base de datos

// Filtros opcionales
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'nro_factura';
$filtro_nro_factura = isset($_GET['f_facturas_nro_factura']) ? $_GET['f_facturas_nro_factura'] : '';
$filtro_cuil_emisor = isset($_GET['f_facturas_cuil_emisor']) ? $_GET['f_facturas_cuil_emisor'] : '';
$filtro_cuil_receptor = isset($_GET['f_facturas_cuil_receptor']) ? $_GET['f_facturas_cuil_receptor'] : '';
$filtro_monto = isset($_GET['f_facturas_monto']) ? $_GET['f_facturas_monto'] : '';

// Consulta a la tabla de facturas con filtros
$query = "SELECT * FROM factura 
          WHERE nro_factura LIKE ? AND cuil_emisor LIKE ? AND cuil_receptor LIKE ? AND monto LIKE ? 
          ORDER BY $orden";
$stmt = $conn->prepare($query);
$stmt->bind_param('ssss', $filtro_nro_factura, $filtro_cuil_emisor, $filtro_cuil_receptor, $filtro_monto);
$stmt->execute();
$result = $stmt->get_result();

$facturas = [];
while ($row = $result->fetch_assoc()) {
    $facturas[] = $row;
}

// Genera el JSON
echo json_encode(['facturas' => $facturas]);
?>
