<?php
$dbhost = 'localhost';
$dbuser = 'c2660848_UBRedes';
$dbpass = 'po06kiSOto';
$dbname = 'c2660848_UBRedes';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
    die('Error al conectarse a la base de datos: ' . mysqli_connect_error());
}
?>
