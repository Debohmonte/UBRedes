<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $dbhost = 'localhost';
        $dbuser = 'c2660848_UBRedes';
        $dbpass = 'po06kiSOto';
        $dbname = 'c2660848_UBRedes';

        $dsn = "mysql:host=$dbhost;dbname=$dbname";
        $dbh = new PDO($dsn, $dbuser, $dbpass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $nro_factura = $_POST['nro_factura'];
        $emisor = $_POST['emisor'];
        $receptor = $_POST['receptor'];
        $monto = $_POST['monto'];
        $descripcion = $_POST['descripcion'];
        $iva = $_POST['iva'];
        $tipo_id = $_POST['tipo_id'];
        $fecha = $_POST['fecha'];

        $sql = "INSERT INTO factura (nro_factura, cuil_emisor, cuil_receptor, monto, descripcion, iva, tipo_id, fecha) 
                VALUES (:nro_factura, :emisor, :receptor, :monto, :descripcion, :iva, :tipo_id, :fecha)";

        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':nro_factura', $nro_factura);
        $stmt->bindParam(':emisor', $emisor);
        $stmt->bindParam(':receptor', $receptor);
        $stmt->bindParam(':monto', $monto);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':iva', $iva);
        $stmt->bindParam(':tipo_id', $tipo_id);
        $stmt->bindParam(':fecha', $fecha);

        $stmt->execute();
        echo json_encode(["message" => "Factura añadida correctamente"]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error en la inserción: " . $e->getMessage()]);
    }
    $dbh = null;
}
?>
