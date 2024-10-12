<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details for Donweb
$servername = "mysql.donweb.com";  // Replace with actual host provided by Donweb
$username = "cc2660848";  // Replace with your actual database username
$password = "febaMA14ku";  // Replace with your actual password
$dbname = "c2660848_UBRedes";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection works
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $tipo_factura = $_POST['tipo_factura'];
    $cuil_emisor = $_POST['cuil_emisor'];
    $nombre_emisor = $_POST['nombre_emisor'];
    $cuil_receptor = $_POST['cuil_receptor'];
    $nombre_receptor = $_POST['nombre_receptor'];
    $nro_factura = $_POST['nro_factura'];
    $monto = $_POST['monto'];
    $descripcion = $_POST['descripcion'];
    $iva = $_POST['iva'];
    $total = $_POST['total'];

    // Insert data into the factura table
    $sql = "INSERT INTO factura (nro_factura, cuil_emisor, cuil_receptor, monto, descripcion, iva, total, tipo_id) 
            VALUES ('$nro_factura', '$cuil_emisor', '$cuil_receptor', '$monto', '$descripcion', '$iva', '$total', '$tipo_factura')";

    // Execute the query and check for errors
    if ($conn->query($sql) === TRUE) {
        echo "Factura generada exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
