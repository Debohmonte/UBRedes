<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Conectar a la base de datos
    $conexion = new PDO("mysql:host=localhost;dbname=c2660848_UBRedes", "c2660848", "po06kiSOto");
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los filtros si existen
    $filtroNumero = isset($_GET['f_numero']) ? $_GET['f_numero'] : '';
    $filtroCuilEmisor = isset($_GET['f_cuil_emisor']) ? $_GET['f_cuil_emisor'] : '';
    $filtroCuilReceptor = isset($_GET['f_cuil_receptor']) ? $_GET['f_cuil_receptor'] : '';
    $filtroMonto = isset($_GET['f_monto']) ? $_GET['f_monto'] : '';
    $filtroIva = isset($_GET['f_iva']) ? $_GET['f_iva'] : '';
    $filtroTotal = isset($_GET['f_total']) ? $_GET['f_total'] : '';

    // Consultar las facturas con los filtros aplicados
    $sql = "SELECT nro_factura as numero, cuil_emisor, cuil_receptor, monto, iva, total 
            FROM factura 
            WHERE nro_factura LIKE :numero 
            AND cuil_emisor LIKE :cuil_emisor 
            AND cuil_receptor LIKE :cuil_receptor
            AND monto LIKE :monto 
            AND iva LIKE :iva 
            AND total LIKE :total";

    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        ':numero' => "%$filtroNumero%",
        ':cuil_emisor' => "%$filtroCuilEmisor%",
        ':cuil_receptor' => "%$filtroCuilReceptor%",
        ':monto' => "%$filtroMonto%",
        ':iva' => "%$filtroIva%",
        ':total' => "%$filtroTotal%"
    ]);

    // Obtener los resultados y devolver en formato JSON
    $facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['facturas' => $facturas]);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

