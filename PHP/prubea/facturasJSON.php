<?php
header('Content-Type: application/json');

// Conexión a la base de datos
$dbhost = 'localhost';
$dbuser = 'c2660848_UBRedes';
$dbpass = 'po06kiSOto';
$dbname = 'c2660848_UBRedes';

try {
    $dsn = "mysql:host=$dbhost;dbname=$dbname";
    $dbh = new PDO($dsn, $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
    exit;
}

// Parámetros de filtrado
$filterNroFactura = isset($_GET['filterNroFactura']) ? '%' . $_GET['filterNroFactura'] . '%' : '%';
$filterEmisor = isset($_GET['filterEmisor']) ? '%' . $_GET['filterEmisor'] . '%' : '%';
$filterReceptor = isset($_GET['filterReceptor']) ? '%' . $_GET['filterReceptor'] . '%' : '%';
$filterMonto = isset($_GET['filterMonto']) ? floatval($_GET['filterMonto']) : 0;
$filterDescripcion = isset($_GET['filterDescripcion']) ? '%' . $_GET['filterDescripcion'] . '%' : '%';
$filterIVA = isset($_GET['filterIVA']) ? $_GET['filterIVA'] : '';
$filterFecha = isset($_GET['filterFecha']) ? $_GET['filterFecha'] : '';

try {
    // Consulta SQL con filtros
    $sql = "SELECT f.nro_factura, f.cuil_emisor, f.cuil_receptor, f.monto, f.descripcion, f.iva, f.total, f.tipo_id, f.fecha 
            FROM factura f 
            WHERE f.nro_factura LIKE :NroFactura 
            AND f.cuil_emisor LIKE :Emisor 
            AND f.cuil_receptor LIKE :Receptor 
            AND f.descripcion LIKE :Descripcion";

    if (!empty($filterIVA)) {
        $sql .= " AND f.iva = :IVA";
    }
    if (!empty($filterFecha)) {
        $sql .= " AND f.fecha = :Fecha";
    }

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':NroFactura', $filterNroFactura);
    $stmt->bindParam(':Emisor', $filterEmisor);
    $stmt->bindParam(':Receptor', $filterReceptor);
    $stmt->bindParam(':Descripcion', $filterDescripcion);

    if (!empty($filterIVA)) {
        $stmt->bindParam(':IVA', $filterIVA);
    }
    if (!empty($filterFecha)) {
        $stmt->bindParam(':Fecha', $filterFecha);
    }

    $stmt->execute();
    $facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['facturas' => $facturas]);

} catch (PDOException $e) {
    echo json_encode(["error" => "Error en la consulta SQL: " . $e->getMessage()]);
    exit;
}

$dbh = null;
?>
