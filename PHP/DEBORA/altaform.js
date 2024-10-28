$(document).ready(function () {
    $("#submits").click(function (e) {
        e.preventDefault();
        var data = new FormData($("#formDeAlta")[0]);
        $.ajax({
            type: 'POST',
            url: "./alta.php",
            processData: false,
            contentType: false,
            cache: false,
            data: data,
            success: function (response) {
                console.log(response); 
                alert("Factura registrada exitosamente.");
            },
            error: function () {
                alert("Error al registrar la factura.");
            }
        });
    });
});