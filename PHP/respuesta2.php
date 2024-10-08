<?php

// Verifica el método POST 
if (isset($_POST['numeroFactura']) && isset($_POST['fechaEmision']) && isset($_POST['montoFactura']) && isset($_POST['descripcion'])) {
    
    // datos enviados 
    $numeroFactura = htmlspecialchars($_POST['numeroFactura']);
    $fechaEmision = htmlspecialchars($_POST['fechaEmision']);
    $montoFactura = htmlspecialchars($_POST['montoFactura']);
    $descripcion = htmlspecialchars($_POST['descripcion']);
    
    // aarray  JSON para enviar la solicitud AJAX.
    $respuesta = array(
        "status" => "success",  
        "mensaje" => "Factura registrada exitosamente", 
        "numeroFactura" => $numeroFactura,  
        "fechaEmision" => $fechaEmision,  
        "montoFactura" => $montoFactura, 
        "descripcion" => $descripcion  
    );

    //mostrar en el frontd respuesta ak=jax
    echo json_encode($respuesta);

} else {

    
    $respuesta = array(
        "status" => "error",  
        "mensaje" => "Faltan datos en el formulario"  
    );

   
    echo json_encode($respuesta);
}
?>
