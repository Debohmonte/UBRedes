<?php

include("./db.php");

try {

    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // errores conexxion
    echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
    exit;
}

// facturas
$sql = "SELECT id, nro_factura, cuil_emisor, cuil_receptor, monto, iva, descripcion, fecha, pdf FROM factura";
$stmt = $dbh->prepare($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();

$facturas = [];
while ($fila = $stmt->fetch()) {
    $objFactura = new stdClass();
    $objFactura->id = $fila['id'];
    $objFactura->nro_factura = $fila['nro_factura'];
    $objFactura->cuil_emisor = $fila['cuil_emisor'];
    $objFactura->cuil_receptor = $fila['cuil_receptor'];
    $objFactura->monto = $fila['monto'];
    $objFactura->iva = $fila['iva'];
    $objFactura->descripcion = $fila['descripcion'];
    $objFactura->fecha = $fila['fecha'];
    $objFactura->pdf = base64_encode($fila['pdf']); 

    $facturas[] = $objFactura; // agragar lista si es alta
}

// json formato
echo json_encode(["facturas" => $facturas]);

// cierra conexion
$dbh = null;
?>