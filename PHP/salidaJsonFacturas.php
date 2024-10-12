<?php
header('Content-Type: application/json');

try {
    // Conectar a la base de datos
    $conexion = new PDO("mysql:host=localhost;dbname=c2660848_UBRedes", "c2660848", "po06kiSOto");
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los filtros desde la URL
    $orden = isset($_GET['orden']) ? $_GET['orden'] : 'nro_factura';
    $f_numero = isset($_GET['f_factura_numero']) ? $_GET['f_factura_numero'] : '';
    $f_cuil_emisor = isset($_GET['f_factura_cuil_emisor']) ? $_GET['f_factura_cuil_emisor'] : '';
    $f_cuil_receptor = isset($_GET['f_factura_cuil_receptor']) ? $_GET['f_factura_cuil_receptor'] : '';
    $f_monto = isset($_GET['f_factura_monto']) ? $_GET['f_factura_monto'] : '';
    $f_fechaAlta = isset($_GET['f_factura_fechaAlta']) ? $_GET['f_factura_fechaAlta'] : '';

    // Consulta SQL con filtros
    $sql = "SELECT nro_factura, cuil_emisor, cuil_receptor, monto, fechaAlta, saldoStock 
            FROM factura 
            WHERE nro_factura LIKE :numero
            AND cuil_emisor LIKE :cuil_emisor
            AND cuil_receptor LIKE :cuil_receptor
            AND monto LIKE :monto
            AND fechaAlta LIKE :fechaAlta
            ORDER BY $orden";

    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        ':numero' => "%$f_numero%",
        ':cuil_emisor' => "%$f_cuil_emisor%",
        ':cuil_receptor' => "%$f_cuil_receptor%",
        ':monto' => "%$f_monto%",
        ':fechaAlta' => "%$f_fechaAlta%"
    ]);

    // Obtener los resultados y devolverlos como JSON
    $facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Comprobar si hay facturas
    if ($facturas) {
        echo json_encode(['facturas' => $facturas]);
    } else {
        echo json_encode(['facturas' => []]); // Devolver un array vacío si no hay resultados
    }

} catch (PDOException $e) {
    // En caso de error, devolver el mensaje de error en formato JSON
    echo json_encode(['error' => $e->getMessage()]);
}
?>
``
