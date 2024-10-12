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

    // SQL query to select all data from factura
    $sql = "SELECT id, nro_factura, cuil_emisor, cuil_receptor, monto, descripcion, iva, total, tipo_id FROM factura";
    $result = mysqli_query($conn, $sql);

    // Check if there are results
    if (mysqli_num_rows($result) > 0) {
        // Fetch data row by row and output in HTML format
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

    // Close the connection
    mysqli_close($conn);
?>
