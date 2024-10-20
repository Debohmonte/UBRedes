<?php
include 'conexion.php';

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

    $sql = "INSERT INTO factura (nro_factura, emisor, receptor, monto, descripcion, iva, total, tipo_factura, fecha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$nro_factura, $emisor, $receptor, $monto, $descripcion, $iva, $total, $tipo_factura, $fecha])) {
        header("Location: mostrarFacturas.php");
    } else {
        echo "Error al insertar la factura: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta de Factura</title>
</head>
<body>
    <h1>Alta de Factura</h1>
    <form action="altaFactura.php" method="POST">
        <label>Nro Factura:</label>
        <input type="text" name="nro_factura" required><br>
        <label>Emisor:</label>
        <input type="text" name="emisor" required><br>
        <label>Receptor:</label>
        <input type="text" name="receptor" required><br>
        <label>Monto:</label>
        <input type="number" name="monto" required><br>
        <label>Descripción:</label>
        <input type="text" name="descripcion" required><br>
        <label>IVA:</label>
        <input type="text" name="iva" required><br>
        <label>Total:</label>
        <input type="number" name="total" required><br>
        <label>Tipo de Factura:</label>
        <input type="text" name="tipo_factura" required><br>
        <label>Fecha:</label>
        <input type="date" name="fecha" required><br>
        <button type="submit">Agregar Factura</button>
    </form>
</body>
</html>
