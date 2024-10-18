<?php
include 'conexion.php'; // Incluimos la conexión

$query = "SELECT * FROM facturas";
$result = mysqli_query($conn, $query);
$facturas = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Facturas</title>
</head>
<body>
    <div class="table-container">
        <table class="tabla-facturas">
            <thead>
                <tr>
                    <th>Nro Factura</th>
                    <th>Emisor</th>
                    <th>Receptor</th>
                    <th>Monto</th>
                    <th>Descripción</th>
                    <th>IVA</th>
                    <th>Total</th>
                    <th>Tipo de Factura</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($facturas as $factura): ?>
                    <tr>
                        <td><?= $factura['nro_factura'] ?></td>
                        <td><?= $factura['emisor'] ?></td>
                        <td><?= $factura['receptor'] ?></td>
                        <td><?= $factura['monto'] ?></td>
                        <td><?= $factura['descripcion'] ?></td>
                        <td><?= $factura['iva'] ?></td>
                        <td><?= $factura['total'] ?></td>
                        <td><?= $factura['tipo_factura'] ?></td>
                        <td><?= $factura['fecha'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

