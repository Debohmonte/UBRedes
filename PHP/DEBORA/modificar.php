<?php
include('./db.php'); 


try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    exit;
}

// AGARRA DATOS BD
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) { // id esta definido
    $Id = $_GET['id']; //almaccena el id
    $sql = "SELECT * FROM factura WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $Id);// vincual id
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        echo json_encode($result); //JSON
    } else {
        echo json_encode(["status" => "error", "message" => "Factura no encontrada."]);
    }
    exit; 
}

// POSTT NUEVO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Id = $_POST['id'];
    $nro_factura = $_POST['nro_factura'];
    $cuil_emisor = $_POST['cuil_emisor'];
    $cuil_receptor = $_POST['cuil_receptor'];
    $monto = $_POST['monto'];
    $iva = $_POST['iva'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha']; 

    // SQL altuaaliza
    $sql = "UPDATE factura SET nro_factura = :nro_factura, cuil_emisor = :cuil_emisor, 
            cuil_receptor = :cuil_receptor, monto = :monto, iva = :iva, 
            descripcion = :descripcion, fecha = :fecha WHERE id = :id";
    
    $stmt = $conn->prepare($sql); //actualizacion prepara
    $stmt->bindParam(':id', $Id);// vinvula id con lo nuevo
    $stmt->bindParam(':nro_factura', $nro_factura);
    $stmt->bindParam(':cuil_emisor', $cuil_emisor);
    $stmt->bindParam(':cuil_receptor', $cuil_receptor);
    $stmt->bindParam(':monto', $monto);
    $stmt->bindParam(':iva', $iva);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':fecha', $fecha); 

    try {
        $stmt->execute();
        echo json_encode(["status" => "success", "message" => "Factura actualizada exitosamente"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error al actualizar: " . $e->getMessage()]);
    }
}
?>