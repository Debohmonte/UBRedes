$(document).ready(function () {
    // carga factura
    $("#cargar").click(function () {
        cargaTabla();
    });
});

// jasx quwe carga datos
function cargaTabla() {
    $.ajax({
        url: 'facturas.php',   // Endpoint datos de facturas
        dataType: 'json',       // respuesta json
        success: function(response) {
            if (response.status === "success") {
                //limpia tabla anterior si hay flitos
                $("#tbDatos").empty();
                
                
                response.data.forEach(factura => {
                    $("#tbDatos").append(`
                        <tr>
                            <td>${factura.id}</td>
                            <td>${factura.nro_factura}</td>
                            <td>${factura.cuil_emisor}</td>
                            <td>${factura.cuil_receptor}</td>
                            <td>${factura.monto}</td>
                            <td>${factura.iva}</td>
                            <td>${factura.descripcion}</td>
                            <td>${factura.fecha}</td>
                            <td><a href='data:application/pdf;base64,${factura.pdf}' target='_blank'>Ver PDF</a></td>
                        </tr>
                    `);
                });
            } else {
                console.error("Error en la respuesta:", response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}


// borrar factura
function borrarFactura(id) {
    if (confirm('¿Desea eliminar la factura ' + id + '?')) {
        $.ajax({
            url: './baja.php',
            type: 'GET',
            data: { id: id },
            success: function (response) {
                alert('Factura eliminada exitosamente.');
                cargaTabla();
            }
        });
    }
}