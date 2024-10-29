$(document).ready(function () {
    //ejecuta el htlm 
    $("#submits").click(function (e) {
        e.preventDefault(); // recarga la paguina
        var data = new FormData($("#formDeAlta")[0]); // nuevo objeto con nuevo id
        $.ajax({ //solicitud ajax
            type: 'POST', 
            url: "./alta.php",
            processData: false, //permite enviar archivos
            contentType: false, // formularios
            cache: false, //no
            data: data, // envis form
            success: function (response) {
                console.log(response); 
                alert("Factura registrada exitosamente.");
                $("#formDeAlta")[0].reset(); //se reinicia el form
            },
            error: function () {
                alert("Error al registrar la factura.");
            }
        });
    });
});