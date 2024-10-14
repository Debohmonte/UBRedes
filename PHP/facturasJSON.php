<?php
// Establecer el tipo de contenido para JSON
header('Content-Type: application/json');

// Conectar a la base de datos
$dbhost = 'localhost';
$dbuser = 'c2660848_UBRedes';
$dbpass = 'po06kiSOto';
$dbname = 'c2660848_UBRedes';

try {
    // Establecer conexión con PDO
    $dsn = "mysql:host=$dbhost;dbname=$dbname";
    $dbh = new PDO($dsn, $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Manejo de error en la conexión
    echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
    exit;
}

// Obtener los valores de IVA desde la tabla factura (o una tabla separada si es necesario)
try {
    $sql = "SELECT DISTINCT iva FROM factura";  // Puedes ajustar esta consulta según tu estructura
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $ivas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error al obtener IVA: " . $e->getMessage()]);
    exit;
}

// Capturar los filtros enviados por GET
$orden = isset($_GET["orden"]) && !empty($_GET["orden"]) ? $_GET["orden"] : 'f.nro_factura';
$filterNroFactura = '%' . (isset($_GET['filterNroFactura']) ? $_GET['filterNroFactura'] : '') . '%';
$filterEmisor = '%' . (isset($_GET['filterEmisor']) ? $_GET['filterEmisor'] : '') . '%';
$filterReceptor = '%' . (isset($_GET['filterReceptor']) ? $_GET['filterReceptor'] : '') . '%';
$filterMonto = '%' . (isset($_GET['filterMonto']) ? $_GET['filterMonto'] : '') . '%';
$filterFecha = '%' . (isset($_GET['filterFecha']) ? $_GET['filterFecha'] : '') . '%';
$filterIVA = isset($_GET['filterIVA']) ? $_GET['filterIVA'] : ''; // Filtro de IVA
$filterDescripcion = '%' . (isset($_GET['filterDescripcion']) ? $_GET['filterDescripcion'] : '') . '%';

try {
    // Consulta SQL para facturas con unión de emisor_receptor y tipo de factura
    $sql = "SELECT f.nro_factura, e.nombre_emisor, e.nombre_receptor, f.monto, f.descripcion, f.iva, f.total, t.nombre_tipo, f.fecha
            FROM factura f
            LEFT JOIN emisor_receptor e ON f.cuil_emisor = e.cuil_emisor
            LEFT JOIN tipo t ON f.tipo_id = t.id
            WHERE 
                f.nro_factura LIKE :NroFactura AND 
                e.nombre_emisor LIKE :Emisor AND 
                e.nombre_receptor LIKE :Receptor AND 
                f.monto LIKE :Monto AND 
                f.descripcion LIKE :Descripcion AND 
                f.fecha LIKE :Fecha";
    
    if (!empty($filterIVA)) {
        $sql .= " AND f.iva = :IVA";  // Añadir filtro de IVA
    }

    $sql .= " ORDER BY " . $orden;

    // Preparar la consulta
    $stmt2 = $dbh->prepare($sql);

    // Vincular los parámetros
    $stmt2->bindParam(':NroFactura', $filterNroFactura);
    $stmt2->bindParam(':Emisor', $filterEmisor);
    $stmt2->bindParam(':Receptor', $filterReceptor);
    $stmt2->bindParam(':Monto', $filterMonto);
    $stmt2->bindParam(':Descripcion', $filterDescripcion);
    $stmt2->bindParam(':Fecha', $filterFecha);
    
    if (!empty($filterIVA)) {
        $stmt2->bindParam(':IVA', $filterIVA);  // Añadir valor de IVA si existe
    }

    // Ejecutar la consulta
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
    $stmt2->execute();

    // Crear un array para almacenar las facturas
    $facturas = [];
    while ($fila = $stmt2->fetch()) {
        $objFactura = new stdClass();
        $objFactura->NroFactura = $fila['nro_factura'];
        $objFactura->Emisor = $fila['nombre_emisor'];
        $objFactura->Receptor = $fila['nombre_receptor'];
        $objFactura->Monto = $fila['monto'];
        $objFactura->Descripcion = $fila['descripcion'];
        $objFactura->IVA = $fila['iva'];
        $objFactura->Total = $fila['total'];
        $objFactura->Tipo = $fila['nombre_tipo'];
        $objFactura->Fecha = $fila['fecha'];
        array_push($facturas, $objFactura);
    }

    // Crear el objeto JSON con la lista de facturas y valores de IVA
    $objFacturas = new stdClass();
    $objFacturas->facturas = $facturas;
    $objFacturas->cuenta = count($facturas);
    $objFacturas->ivas = $ivas;  // Incluir los valores de IVA en el JSON

    // Enviar la respuesta en formato JSON
    echo json_encode($objFacturas);

} catch (PDOException $e) {
    echo json_encode(["error" => "Error en la consulta SQL: " . $e->getMessage()]);
    exit;
}

// Cerrar la conexión
$dbh = null;
?>
