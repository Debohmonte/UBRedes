<?php
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
} catch(PDOException $e) {
    // Manejo de error en la conexión
    echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
    exit;
}

sleep(2); // Simulación de retraso para pruebas

// Capturar los filtros enviados por GET
$orden = isset($_GET["orden"]) && !empty($_GET["orden"]) ? $_GET["orden"] : 'f.nro_factura';
$filterNroFactura = '%' . $_GET['filterNroFactura'] . '%';
$filterEmisor = '%' . $_GET['filterEmisor'] . '%';
$filterReceptor = '%' . $_GET['filterReceptor'] . '%';
$filterMonto = '%' . $_GET['filterMonto'] . '%';
$filterFecha = '%' . $_GET['filterFecha'] . '%'; // Filtrar por fecha

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
                f.fecha LIKE :Fecha"; // Filtrar por fecha

    // Ordenar según el campo elegido
    $sql .= " ORDER BY " . $orden;

    // Preparar la consulta
    $stmt2 = $dbh->prepare($sql);

    // Vincular los parámetros
    $stmt2->bindParam(':NroFactura', $filterNroFactura);
    $stmt2->bindParam(':Emisor', $filterEmisor);
    $stmt2->bindParam(':Receptor', $filterReceptor);
    $stmt2->bindParam(':Monto', $filterMonto);
    $stmt2->bindParam(':Fecha', $filterFecha); // Vincular el parámetro de fecha

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
        $objFactura->Fecha = $fila['fecha']; // Agregar el valor de la fecha
        array_push($facturas, $objFactura);
    }

    // Crear el objeto JSON con la lista de facturas
    $objFacturas = new stdClass();
    $objFacturas->facturas = $facturas;
    $objFacturas->cuenta = count($facturas);

    // Enviar la respuesta en formato JSON
    echo json_encode($objFacturas);

} catch (PDOException $e) {
    // Enviar el error si la consulta falla
    echo json_encode(["error" => "Error en la consulta SQL: " . $e->getMessage()]);
    exit;
}

// Cerrar la conexión
$dbh = null;
?>
