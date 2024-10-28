<?php
$host = 'localhost';
$dbname = 'c2660848_UBRedes'; 
$user = 'c2660848_UBRedes'; 
$password = 'po06kiSOto';

try {
    
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    
    //  modo de error de PDO a excepciones
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // errores json
    echo json_encode(["status" => "error", "message" => "Conexión error: " . $e->getMessage()]);
    exit;
}
?>