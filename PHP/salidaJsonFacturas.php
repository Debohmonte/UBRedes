<?php
// Conectar a la base de datos
$conexion = new PDO("mysql:host=localhost;dbname=c2660848_UBRedes", "c2660848", "po06kiSOto");

// Obtener filtros
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'numero';
$filtroNumero = isset($_GET['f_factura_numero']) ? $_GET['f_factura_numero'] : '';
$filtroFamilia = isset($_GET['f_factura_familia']) ? $_GET['f_factura_familia'] : '';
$filtroDescripcion = isset($_GET['f_factura_descripcion']) ? $_GET['f_factura_descripcion'] : '';
$filtroFechaAlta = isset($_GET['f_factura_fechaAlta']) ? $_GET['f_factura_fechaAlta'] : '';
$filtroSaldoStock = isset($_GET['f_factura_saldoStock']) ? $_GET['f_factura_saldoStock'] : '';

// Preparar consulta con filtros
$sql = "SELECT numero, familia, descripcion, fechaAlta, saldoStock FROM facturas 
        WHERE numero LIKE :numero AND familia LIKE :familia 
        AND descripcion LIKE :descripcion AND fechaAlta LIKE :fechaAlta
        AND saldoStock LIKE :saldoStock
        ORDER BY $orden";
$stmt = $conexion->prepare($sql);
$stmt->execute([
    ':numero' => "%$filtroNumero%",
    ':familia' => "%$filtroFamilia%",
    ':descripcion' => "%$filtroDescripcion%",
    ':fechaAlta' => "%$filtroFechaAlta%",
    ':saldoStock' => "%$filtroSaldoStock%"
]);

// Devolver los resultados en formato JSON
$facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(['facturas' => $facturas]);
?>

