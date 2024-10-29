<?php

include('db.php');

//conf json
header('Content-Type: application/json');

try {
    // obtiene facturas con el SQL
    $stmt = $conn->prepare("SELECT * FROM factura");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC); //INDICE ASOCIATIVO LA RESPUESTA

    // envia estpuesta al json
    echo json_encode([
        "status" => "success",
        "data" => $data
    ]);
} catch (Exception $e) {
    // elimina errores json
    echo json_encode([
        "status" => "error",
        "message" => "Error en la consulta: " . $e->getMessage()
    ]);
}
?>
