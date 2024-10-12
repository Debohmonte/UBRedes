<?php
header('Content-Type: application/json');

// Datos de conexión a la base de datos
$dbhost = 'localhost';  // Asegúrate de usar el host correcto proporcionado por DonWeb
$dbuser = 'c2660848_UBRedes';  // Usuario proporcionado por DonWeb
$dbpass = 'po06kiSOto';  // Contraseña proporcionada por DonWeb
$dbname = 'c2660848_UBRedes';  // Nombre de la base de datos

// Conectar a la base de datos utilizando mysqli
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Verificar la conexión
if (!$conn) {
    die(json_encode(['error' => 'Error al conectarse a MySQL: ' . mysqli_connect_error()]));
}

// Obtener los filtros desde la URL (GET)
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'nro_factura';
$f_numero = isset($_GET['f_factura_numero']) ? $_GET['f_factura_numero'] : '';
$f_cuil_emisor = isset($_GET['f_factura_cuil_emisor']) ? $_GET['f_factura_cuil_emisor'] : '';
$f_cuil_receptor = isset($_GET['f_factura_cuil_receptor']) ? $_GET['f_factura_cuil_receptor'] : '';
$f_monto = isset($_GET['f_factura_monto']) ? $_GET['f_factura_monto'] : '';
$f_fechaAlta = isset($_GET['f_factura_fechaAlta']) ? $_GET['f_factura_fechaAlta'] : '';

// Crear la consulta SQL con los filtros aplicados
$sql = "SELECT nro_factura, cuil_emisor, cuil_receptor, monto, fechaAlta, saldoStock 
        FROM factura 
        WHERE nro_factura LIKE '%$f_numero%'
        AND cuil_emisor LIKE '%$f_cuil_emisor%'
        AND cuil_receptor LIKE '%$f_cuil_receptor%'
        AND monto LIKE '%$f_monto%'
        AND fechaAlta LIKE '%$f_fechaAlta%'
        ORDER BY $orden";

// Ejecutar la consulta y manejar los resultados
$result = mysqli_query($conn, $sql);

// Verificar si hay resultados
if ($result) {
    $facturas = [];

    // Recorrer los resultados y almacenarlos en el array
    while ($row = mysqli_fetch_assoc($result)) {
        $facturas[] = $row;
    }

    // Devolver los resultados como JSON
    echo json_encode(['facturas' => $facturas]);

} else {
    // Devolver el error en caso de fallo de la consulta
    echo json_encode(['error' => 'Error en la consulta: ' . mysqli_error($conn)]);
}

// Cerrar la conexión
mysqli_close($conn);
?>
