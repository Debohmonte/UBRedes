<?php
include 'conexion.php'; // Incluimos la conexión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nro_factura = $_POST['nro_factura'];
    $emisor = $_POST['emisor'];
    $receptor = $_POST['receptor'];
    $monto = $_POST['monto'];
    $descripcion = $_POST['descripcion'];
    $iva = $_POST['iva'];
    $total = $_POST['total'];
    $tipo_factura = $_POST['tipo_factura'];
    $fecha = $_POST['fecha'];

    $query = "UPDATE facturas SET emisor = '$emisor', receptor = '$receptor', monto = '$monto', descripcion = '$descripcion', iva = '$iva', total = '$total', tipo_factura = '$tipo_factura', fecha = '$fecha' WHERE nro_factura = '$nro_factura'";
    
    if (mysqli_query($conn, $query)) {
        header('Location: mostrarFacturas.php');
    } else {
        echo "Error al modificar el registro: " . mysqli_error($conn);
    }
} else {
    $nro_factura = $_GET['nro_factura'];
    $query = "SELECT * FROM facturas WHERE nro_factura = '$nro_factura'";
    $result = mysqli_query($conn, $query);
    $factura = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Factura</title>
</head>
<body>
    <form action="modificarFactura.php" method="POST">
        <input type="hidden" name="nro_factura" value="<?= $factura['nro_factura'] ?>">
        <label>Emisor:</label>
        <input type="text" name="emisor" value="<?= $factura['emisor'] ?>" required><br>
        <label>Receptor:</label>
        <input type="text" name="receptor" value="<?= $factura['receptor'] ?>" required><br>
        <label>Monto:</label>
        <input type="number" name="monto" value="<?= $factura['monto'] ?>" required><br>
        <label>Descripción:</label>
        <input type="text" name="descripcion" value="<?= $factura['descripcion'] ?>" required><br>
        <label>IVA:</label>
        <input type="number" name="iva" value="<?= $factura['iva'] ?>" required><br>
        <label>Total:</label>
        <input type="number" name="total" value="<?= $factura['total'] ?>" required><br>
        <label>Tipo de Factura:</label>
        <input type="text" name="tipo_factura" value="<?= $factura['tipo_factura'] ?>" required><br>
        <label>Fecha:</label>
        <input type="date" name="fecha" value="<?= $factura['fecha'] ?>" required><br>
        <button type="submit">Modificar Factura</button>
    </form>
</body>
</html>
