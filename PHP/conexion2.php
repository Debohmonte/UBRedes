<?php
    // Database connection details
    $dbhost = 'localhost';
    $dbuser = 'c2660848_UBRedes';
    $dbpass = 'po06kiSOto';
    $dbname = 'c2660848_UBRedes';

    // Create connection
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Start building the query
    $sql = "SELECT id, nro_factura, cuil_emisor, cuil_receptor, monto, descripcion, iva, total, tipo_id FROM factura WHERE 1=1";

    // Check for each filter and add to the query if present
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

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Initialize variables to store results
    $html = '';
    $count = 0;

    // Check if there are results
    if (mysqli_num_rows($result) > 0) {
        // Fetch data row by row and build HTML
        while($row = mysqli_fetch_assoc($result)) {
            $html .= '<tr>';
            $html .= '<td>' . $row["id"] . '</td>';
            $html .= '<td>' . $row["nro_factura"] . '</td>';
            $html .= '<td>' . $row["cuil_emisor"] . '</td>';
            $html .= '<td>' . $row["cuil_receptor"] . '</td>';
            $html .= '<td>' . $row["monto"] . '</td>';
            $html .= '<td>' . $row["descripcion"] . '</td>';
            $html .= '<td>' . $row["iva"] . '</td>';
            $html .= '<td>' . $row["total"] . '</td>';
            $html .= '<td>' . $row["tipo_id"] . '</td>';
            $html .= '</tr>';
            $count++;
        }
    } else {
        $html = "<tr><td colspan='9'>No records found.</td></tr>";
    }

    // Return the HTML and the count as a JSON response
    echo json_encode([
        'html' => $html,
        'count' => $count
    ]);

    // Close the connection
    mysqli_close($conn);
?>
