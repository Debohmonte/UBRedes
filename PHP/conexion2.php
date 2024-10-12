<?php
    // CONEXION BASSE DE DATOS
    $dbhost = 'localhost';
    $dbuser = 'c2660848_UBRedes';
    $dbpass = 'po06kiSOto';
    $dbname = 'c2660848_UBRedes';

    // CREA CINEXION
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // VALIDA CONEXION
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // QUERY DE FACTURA
    $sql = "SELECT id, nro_factura, cuil_emisor, cuil_receptor, monto, descripcion, iva, total, tipo_id FROM factura WHERE 1=1";

    // VALDIA DATOS FACTURA
    if (!empty($_GET['id'])) {
        $sql .= " AND id = " . intval($_GET['id']);
    }
    if (!empty($_GET['nro_factura'])) {
        $sql .= " AND nro_factura LIKE '%" . mysqli_real_escape_string($conn, $_GET['nro_factura']) . "%'";
    }
    if (!empty($_GET['cuil_emisor'])) {
        $sql .= " AND cuil_emisor LIKE '%" . mysqli_real_escape_string($conn, $_GET['cuil_emisor']) . "%'";
    }
    if (!empty($_GET['cuil_receptor'])) {
        $sql .= " AND cuil_receptor LIKE '%" . mysqli_real_escape_string($conn, $_GET['cuil_receptor']) . "%'";
    }
    if (!empty($_GET['monto'])) {
        $sql .= " AND monto = " . floatval($_GET['monto']);
    }
    if (!empty($_GET['descripcion'])) {
        $sql .= " AND descripcion LIKE '%" . mysqli_real_escape_string($conn, $_GET['descripcion']) . "%'";
    }
    if (!empty($_GET['iva'])) {
        $sql .= " AND iva = " . floatval($_GET['iva']);
    }
    if (!empty($_GET['tipo_id'])) {
        $sql .= " AND tipo_id = " . intval($_GET['tipo_id']);
    }

    // EJECUTA LA QUERY
    $result = mysqli_query($conn, $sql);

    // VALDIA RESULTADOS DE LA  UERY
    if (mysqli_num_rows($result) > 0) {
        
        while($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row["id"] . '</td>';
            echo '<td>' . $row["nro_factura"] . '</td>';
            echo '<td>' . $row["cuil_emisor"] . '</td>';
            echo '<td>' . $row["cuil_receptor"] . '</td>';
            echo '<td>' . $row["monto"] . '</td>';
            echo '<td>' . $row["descripcion"] . '</td>';
            echo '<td>' . $row["iva"] . '</td>';
            echo '<td>' . $row["total"] . '</td>';
            echo '<td>' . $row["tipo_id"] . '</td>';
            echo '</tr>';
        }
    } else {
        echo "<tr><td colspan='9'>No records found.</td></tr>";
    }

    // CIERRA CONEXION
    mysqli_close($conn);
?>
