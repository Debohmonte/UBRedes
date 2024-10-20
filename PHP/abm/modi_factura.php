<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nro_factura = $_POST['nro_factura'];
    $cuil_emisor = $_POST['cuil_emisor'];
    $cuil_receptor = $_POST['cuil_receptor'];
    $monto = $_POST['monto'];
    $descripcion = $_POST['descripcion'];
    $iva = $_POST['iva'];
    $tipo_id = $_POST['tipo_id'];
    $fecha = $_POST['fecha'];
    $total = $monto + $iva;

    $sql = "UPDATE factura SET nro_factura = :nro_factura, cuil_emisor = :cuil_emisor, cuil_receptor = :cuil_receptor, 
            monto = :monto, descripcion = :descripcion, iva = :iva, total = :total, tipo_id = :tipo_id, fecha = :fecha 
            WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nro_factura', $nro_factura);
    $stmt->bindParam(':cuil_emisor', $cuil_emisor);
    $stmt->bindParam(':cuil_receptor', $cuil_receptor);
    $stmt->bindParam(':monto', $monto);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':iva', $iva);
    $stmt->bindParam(':total', $total);
    $stmt->bindParam(':tipo_id', $tipo_id);
    $stmt->bindParam(':fecha', $fecha);

    if ($stmt->execute()) {
        echo "Factura modificada exitosamente.";
    } else {
        echo "Error al modificar la factura.";
    }
} else {
    // Retrieve invoice data to pre-fill form
    $id = $_GET['id'];
    $stmt = $dbh->prepare("SELECT * FROM factura WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $factura = $stmt->fetch(PDO::FETCH_ASSOC);
    // Generate form with the data
    echo "<form method='POST' action='modi_factura.php'>
            <input type='hidden' name='id' value='{$factura['id']}'>
            <label for='nro_factura'>Número de Factura</label>
            <input type='text' id='nro_factura' name='nro_factura' value='{$factura['nro_factura']}'>
            <label for='cuil_emisor'>CUIL Emisor</label>
            <input type='text' id='cuil_emisor' name='cuil_emisor' value='{$factura['cuil_emisor']}'>
            <label for='cuil_receptor'>CUIL Receptor</label>
            <input type='text' id='cuil_receptor' name='cuil_receptor' value='{$factura['cuil_receptor']}'>
            <label for='monto'>Monto</label>
            <input type='number' id='monto' name='monto' value='{$factura['monto']}'>
            <label for='descripcion'>Descripción</label>
            <input type='text' id='descripcion' name='descripcion' value='{$factura['descripcion']}'>
            <label for='iva'>IVA</label>
            <input type='number' id='iva' name='iva' value='{$factura['iva']}'>
            <label for='tipo_id'>Tipo de Factura</label>
            <select id='tipo_id' name='tipo_id'>
                <option value='1' ".($factura['tipo_id'] == 1 ? 'selected' : '').">Factura A</option>
                <option value='2' ".($factura['tipo_id'] == 2 ? 'selected' : '').">Factura B</option>
                <option value='3' ".($factura['tipo_id'] == 3 ? 'selected' : '').">Factura C</option>
            </select>
            <label for='fecha'>Fecha</label>
            <input type='date' id='fecha' name='fecha' value='{$factura['fecha']}'>
            <button type='submit'>Modificar Factura</button>
        </form>";
}
?>
