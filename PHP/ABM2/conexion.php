<?php
// Datos de conexión
$dbhost = 'localhost';
$dbuser = 'c2660848_UBRedes';
$dbpass = 'po06kiSOto';
$dbname = 'c2660848_UBRedes';

// Crear conexión
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Verificar conexión
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
