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

        $sql = "DELETE FROM factura WHERE nro_factura = :nro_factura";

        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':nro_factura', $nro_factura);
        $stmt->execute();

        echo json_encode(["message" => "Factura eliminada correctamente"]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error al eliminar la factura: " . $e->getMessage()]);
    }
    $dbh = null;
}
?>
